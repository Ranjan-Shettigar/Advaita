<?php
include 'includes/config.php';

// Establish database connection
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname: " . $e->getMessage());
}

// Function to get image dimensions and calculate aspect ratio
function getImageAspectRatio($imagePath)
{
    if (file_exists($imagePath) && is_readable($imagePath)) {
        $imageSize = getimagesize($imagePath);
        if ($imageSize !== false) {
            $width = $imageSize[0];
            $height = $imageSize[1];
            if ($width > 0) {
                return $height / $width * 100;
            }
        }
    }
    return 75; // Default to a 4:3 aspect ratio
}

// Fetch images from the database
try {
    $stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY id DESC");
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching images: " . $e->getMessage());
}

// Define a placeholder image URL
$placeholderImage = 'https://via.placeholder.com/300x225.png?text=Image+Not+Found';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Gallery - Pinterest Style</title>
    <link rel="stylesheet" href="./styles/gallery.css">
</head>

<body>
    <div class="gallery">
        <?php foreach ($images as $image) : ?>
            <?php
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . $image['image_path'];  
            $aspectRatio = getImageAspectRatio($imagePath);
            $imageUrl = file_exists($imagePath) ? $image['image_path'] : $placeholderImage;  
            ?>
            <div class="gallery-item" data-src="<?php echo htmlspecialchars($imageUrl); ?>" data-title="<?php echo htmlspecialchars($image['title']); ?>" data-description="<?php echo htmlspecialchars($image['description']); ?>">
                <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($image['title']); ?>" style="aspect-ratio: 1 / <?php echo $aspectRatio / 100; ?>;" loading="lazy">
                <div class="image-info">
                    <h3><?php echo htmlspecialchars($image['title']); ?></h3>
                    <p><?php echo htmlspecialchars($image['description']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="lightbox">
        <span class="lightbox-close">&times;</span>
        <div class="lightbox-content">
            <img src="" alt="Lightbox Image">
            <div class="lightbox-info">
                <h3></h3>
                <p></p>
            </div>
        </div>
    </div>

    <script src="./js/gallery.js"></script>
</body>

</html>
