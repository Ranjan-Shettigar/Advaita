-- Create the database (if not already created)
CREATE DATABASE IF NOT EXISTS college_fest;

-- Use the database
USE college_fest;



-- Create the password_reset_requests table
CREATE TABLE IF NOT EXISTS password_reset_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    request_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45) NOT NULL
);


-- Create the gallery_images table
CREATE TABLE IF NOT EXISTS gallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Create the events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    eid INT,
    imageSrc VARCHAR(255) NOT NULL,
    iconSrc VARCHAR(255) NOT NULL,
    title VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    price VARCHAR(50) NOT NULL,
    mode ENUM('Solo', 'Duo', 'Team', 'Group') NOT NULL,
    description TEXT NOT NULL,
    boxShadow VARCHAR(100),
    highlightColor VARCHAR(100),
    readMoreLink VARCHAR(255) NOT NULL
);


-- ALTER TABLE events 
-- ADD COLUMN eid INT;



-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    reset_token VARCHAR(64) DEFAULT NULL,
    name VARCHAR(255) NOT NULL,
    college VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Create the orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_id VARCHAR(50) NOT NULL UNIQUE,
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'completed', 'failed') NOT NULL,
    transaction_id VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    receipt TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Create the order_items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    event_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (event_id) REFERENCES events(id)
);

-- Create the user_purchases table
CREATE TABLE IF NOT EXISTS user_purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    order_id VARCHAR(50) NOT NULL,
    status ENUM('pending', 'completed', 'failed') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (event_id) REFERENCES events(id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, event_id, order_id)
);


-- Create a trigger to update the status in user_purchases when it changes in orders
DELIMITER //

CREATE TRIGGER update_user_purchases_status
AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
    IF OLD.status <> NEW.status THEN
        UPDATE user_purchases
        SET status = NEW.status
        WHERE order_id = NEW.order_id;
    END IF;
END//

DELIMITER ;











CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `is_admin`) VALUES
(1, 'admin', '$2y$10$m4cRMJqc5wsW5nO.j7S8Pe5uAbGTLuzgZpqxYrxnfIi/rDNTTFB5m', 1);


-- Update the user_purchases table


-- Insert sample data into gallery_images
INSERT INTO gallery_images (title, description, image_path) VALUES
('Campus Library', 'Our state-of-the-art library facility', '/images/gallery/1.jpg'),
('Science Lab', 'Advanced equipment in our science laboratory', '/images/gallery/2.jpg'),
('Student Center', 'A place for students to relax and socialize', '/images/gallery/3.jpg'),
('Sports Field', 'Our multi-purpose sports field', '/images/gallery/4.jpg'),
('Lecture Hall', 'One of our modern lecture halls', '/images/gallery/5.jpg'),
('Art Studio', 'Creative space for our art students', '/images/gallery/6.jpg'),
('Dormitory', 'Comfortable living spaces for students', '/images/gallery/7.jpg'),
('Cafeteria', 'Diverse dining options for students and staff', '/images/gallery/8.jpg'),
('Computer Lab', 'High-tech computer facilities', '/images/gallery/9.jpg'),
('Gymnasium', 'Our fully-equipped gymnasium', '/images/gallery/10.jpg');

-- Insert sample data into users table
INSERT INTO users (username, email, password, reset_token, name, college, phone, created_at) VALUES
('loko', 'vekimiv319@acpeak.com', '$2y$10$m4cRMJqc5wsW5nO.j7S8Pe5uAbGTLuzgZpqxYrxnfIi/rDNTTFB5m', '8823355e0c8dc5b728113b3b3dcb6155', 'Receiver Name', 'nitte', '9945956485', '2024-08-21 05:39:15'),
('sharan', 'geroto6883@chaladas.com', '$2y$10$rdLhpBGxdJYBRYX.QRN8seyRwxT7dZRbvs0c7IzyPxUvb4xj7sX/C', 'b32175e6d9706ad8697013b790653ba2', 'Sharan Puthran', 'PIM', '7894517934', '2024-08-21 06:46:16');

-- Insert sample data into events table

INSERT INTO events (imageSrc, iconSrc, title, name, price, mode, description, boxShadow, highlightColor, readMoreLink, eid) VALUES
('./assets/events/code.jpg', './assets/events/code.jpg', 'CODE', 'KODE', '100', 'Solo', 'Showcase your coding skills in a race against time. Solve challenging problems and emerge as the coding champion.', '0 0px 10px #1E90FF', '#1E90FF', 'code_page.html', 1),
('./assets/events/gta5.jpg', './assets/events/gta5.jpg', 'GTA 5', 'RAKSHA', '150', 'Duo', 'Join forces and dominate the streets in the ultimate GTA 5 challenge. Outmaneuver your opponents and rule the city.', '0 0px 10px #FF4500', '#FF4500', 'gta5_page.html', 2),
('./assets/events/wwboard.jpg', './assets/events/wwboard.jpg', 'WWBOARD', 'SANGRAM', '120', 'Group', 'Strategize and lead your team to victory in a world of intense warfare. The battlefield awaits your command.', '0 0px 10px #800080', '#800080', 'wwboard_page.html', 3),
('./assets/events/cyberpunk.jpg', './assets/events/cyberpunk.jpg', 'CYBERPUNK', 'YAJNA', '200', 'Team', 'Dive into a futuristic world of cyber warfare and hacking. Will you emerge as the ultimate cyber warrior?', '0 0px 10px #32CD32', '#32CD32', 'cyberpunk_page.html', 4),
('./assets/events/food.jpg', './assets/events/food.jpg', 'FOOD', 'ANNAM', '80', 'Solo', 'Indulge in a culinary journey. Showcase your cooking skills or simply enjoy the delicious offerings.', '0 0px 10px #FF6347', '#FF6347', 'food_page.html', 5),
('./assets/events/gunfight.jpg', './assets/events/gunfight.jpg', 'GUNFIGHT', 'DHANUSH', '130', 'Duo', 'Gear up for an adrenaline-pumping gunfight. Team up and take down your rivals in this high-octane event.', '0 0px 10px #FFD700', '#FFD700', 'gunfight_page.html', 6),
('./assets/events/minecraft.jpg', './assets/events/minecraft.jpg', 'MINECRAFT', 'LOKA', '90', 'Group', 'Build, create, and survive in the world of Minecraft. Collaborate with your group to construct the ultimate masterpiece.', '0 0px 10px #00BFFF', '#00BFFF', 'minecraft_page.html', 7),
('./assets/events/signing.jpg', './assets/events/signing.jpg', 'SIGNING', 'SIGN', '50', 'Solo', 'Participate in our signing event, where you can showcase your autograph skills or meet and greet with special guests.', '0 0px 10px #8B0000', '#8B0000', 'signing_page.html', 8);
