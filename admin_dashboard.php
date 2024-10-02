<!-- admin_dashboard.php -->

<?php
session_start();
include './includes/config.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_id']) || !$_SESSION['is_admin']) {
    header('Location: ./auth/admin_login.php');
    exit;
}

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_gallery_image':
            case 'update_gallery_image':
                $id = isset($_POST['id']) ? sanitize_input($_POST['id']) : '';
                $title = isset($_POST['title']) ? sanitize_input($_POST['title']) : '';
                $description = isset($_POST['description']) ? sanitize_input($_POST['description']) : '';
                $image_path = isset($_POST['image_path']) ? sanitize_input($_POST['image_path']) : '';

                if (!empty($id)) {
                    // Check if the image ID exists before updating
                    $check_stmt = $conn->prepare("SELECT id FROM gallery_images WHERE id = ?");
                    $check_stmt->bind_param("i", $id);
                    $check_stmt->execute();
                    $check_stmt->store_result();

                    if ($check_stmt->num_rows > 0) {
                        // Update existing image
                        $stmt = $conn->prepare("UPDATE gallery_images SET title = ?, description = ?, image_path = ? WHERE id = ?");
                        $stmt->bind_param("sssi", $title, $description, $image_path, $id);
                    } else {
                        // If the ID doesn't exist, treat it as an addition
                        $stmt = $conn->prepare("INSERT INTO gallery_images (title, description, image_path) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $title, $description, $image_path);
                    }
                    $check_stmt->close();
                } else {
                    // Add new image if ID is not provided
                    $stmt = $conn->prepare("INSERT INTO gallery_images (title, description, image_path) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $title, $description, $image_path);
                }

                $stmt->execute();
                $stmt->close();
                break;

            case 'delete_gallery_image':
                $id = isset($_POST['id']) ? sanitize_input($_POST['id']) : '';
                $stmt = $conn->prepare("DELETE FROM gallery_images WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();
                break;

            case 'add_event':
            case 'update_event':
                $id = isset($_POST['id']) ? sanitize_input($_POST['id']) : '';
                $eid = isset($_POST['eid']) ? sanitize_input($_POST['eid']) : '';
                $imageSrc = isset($_POST['imageSrc']) ? sanitize_input($_POST['imageSrc']) : '';
                $iconSrc = isset($_POST['iconSrc']) ? sanitize_input($_POST['iconSrc']) : '';
                $title = isset($_POST['title']) ? sanitize_input($_POST['title']) : '';
                $name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
                $price = isset($_POST['price']) ? sanitize_input($_POST['price']) : '';
                $mode = isset($_POST['mode']) ? sanitize_input($_POST['mode']) : '';
                $description = isset($_POST['description']) ? sanitize_input($_POST['description']) : '';
                $boxShadow = isset($_POST['boxShadow']) ? sanitize_input($_POST['boxShadow']) : '';
                $highlightColor = isset($_POST['highlightColor']) ? sanitize_input($_POST['highlightColor']) : '';
                $readMoreLink = isset($_POST['readMoreLink']) ? sanitize_input($_POST['readMoreLink']) : '';

                if (!empty($id)) {
                    // Check if the event ID exists before updating
                    $check_stmt = $conn->prepare("SELECT id FROM events WHERE id = ?");
                    $check_stmt->bind_param("i", $id);
                    $check_stmt->execute();
                    $check_stmt->store_result();

                    if ($check_stmt->num_rows > 0) {
                        // Update existing event
                        $stmt = $conn->prepare("UPDATE events SET eid = ?, imageSrc = ?, iconSrc = ?, title = ?, name = ?, price = ?, mode = ?, description = ?, boxShadow = ?, highlightColor = ?, readMoreLink = ? WHERE id = ?");
                        $stmt->bind_param("issssssssssi", $eid, $imageSrc, $iconSrc, $title, $name, $price, $mode, $description, $boxShadow, $highlightColor, $readMoreLink, $id);
                    } else {
                        // If the ID doesn't exist, treat it as an addition
                        $stmt = $conn->prepare("INSERT INTO events (eid, imageSrc, iconSrc, title, name, price, mode, description, boxShadow, highlightColor, readMoreLink) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("issssssssss", $eid, $imageSrc, $iconSrc, $title, $name, $price, $mode, $description, $boxShadow, $highlightColor, $readMoreLink);
                    }
                    $check_stmt->close();
                } else {
                    // Add new event if ID is not provided
                    $stmt = $conn->prepare("INSERT INTO events (eid, imageSrc, iconSrc, title, name, price, mode, description, boxShadow, highlightColor, readMoreLink) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("issssssssss", $eid, $imageSrc, $iconSrc, $title, $name, $price, $mode, $description, $boxShadow, $highlightColor, $readMoreLink);
                }

                $stmt->execute();
                $stmt->close();
                break;

            case 'delete_event':
                $id = isset($_POST['id']) ? sanitize_input($_POST['id']) : '';
                $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();
                break;
        }
    }
}

// Fetch gallery images
$gallery_query = "SELECT * FROM gallery_images";
$gallery_result = $conn->query($gallery_query);

// Fetch events
$events_query = "SELECT * FROM events";
$events_result = $conn->query($events_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles/admin_dashboard.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Admin</a></li> <!-- New link -->
                <li><a href="#events">Events</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="./auth/admin_logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="gallery">
            <h2>Gallery Management</h2>
            <form method="post" id="gallery-form">
                <input type="hidden" name="action" value="add_gallery_image">
                <input type="hidden" name="id" id="gallery-id">
                <input type="text" name="title" id="gallery-title" placeholder="Title" required>
                <textarea name="description" id="gallery-description" placeholder="Description"></textarea>
                <input type="text" name="image_path" id="gallery-image_path" placeholder="Image Path" required>
                <button type="submit">Add Image</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image Path</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($image = $gallery_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($image['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($image['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($image['description'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($image['image_path'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <button onclick="editGalleryImage(<?php echo htmlspecialchars(json_encode($image), ENT_QUOTES, 'UTF-8'); ?>)">Edit</button>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="action" value="delete_gallery_image">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($image['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this image?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <section id="events">
            <h2>Event Management</h2>
            <form method="post" id="event-form">
                <input type="hidden" name="action" value="add_event">
                <input type="hidden" name="id" id="event-id">
                <input type="number" name="eid" id="event-eid" placeholder="Event ID" required>
                <input type="text" name="imageSrc" id="event-imageSrc" placeholder="Image Source" required>
                <input type="text" name="iconSrc" id="event-iconSrc" placeholder="Icon Source" required>
                <input type="text" name="title" id="event-title" placeholder="Title" required>
                <input type="text" name="name" id="event-name" placeholder="Name" required>
                <input type="text" name="price" id="event-price" placeholder="Price" required>
                <input type="text" name="mode" id="event-mode" placeholder="Mode (Online/Offline)" required>
                <textarea name="description" id="event-description" placeholder="Description"></textarea>
                <input type="text" name="boxShadow" id="event-boxShadow" placeholder="Box Shadow">
                <input type="text" name="highlightColor" id="event-highlightColor" placeholder="Highlight Color">
                <input type="text" name="readMoreLink" id="event-readMoreLink" placeholder="Read More Link">
                <button type="submit">Add Event</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event ID</th>
                        <th>Image Source</th>
                        <th>Icon Source</th>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Mode</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($event = $events_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($event['eid'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($event['imageSrc'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($event['iconSrc'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($event['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($event['price'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($event['mode'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($event['description'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <button onclick="editEvent(<?php echo htmlspecialchars(json_encode($event), ENT_QUOTES, 'UTF-8'); ?>)">Edit</button>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="action" value="delete_event">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($event['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
    <script>
        function editGalleryImage(image) {
            document.getElementById('gallery-id').value = image.id;
            document.getElementById('gallery-title').value = image.title;
            document.getElementById('gallery-description').value = image.description;
            document.getElementById('gallery-image_path').value = image.image_path;
            document.getElementById('gallery-form').action = 'admin_dashboard.php?action=update_gallery_image';
        }

        function editEvent(event) {
            document.getElementById('event-id').value = event.id;
            document.getElementById('event-eid').value = event.eid;
            document.getElementById('event-imageSrc').value = event.imageSrc;
            document.getElementById('event-iconSrc').value = event.iconSrc;
            document.getElementById('event-title').value = event.title;
            document.getElementById('event-name').value = event.name;
            document.getElementById('event-price').value = event.price;
            document.getElementById('event-mode').value = event.mode;
            document.getElementById('event-description').value = event.description;
            document.getElementById('event-boxShadow').value = event.boxShadow;
            document.getElementById('event-highlightColor').value = event.highlightColor;
            document.getElementById('event-readMoreLink').value = event.readMoreLink;
            document.getElementById('event-form').action = 'admin_dashboard.php?action=update_event';
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
