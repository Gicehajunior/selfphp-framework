-- users table --
CREATE TABLE users(
	id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    userEmail VARCHAR(255) NOT NULL,
    accPassword LONGTEXT NOT NULL,
    avatar VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    county VARCHAR(255) NOT NULL,
    residence VARCHAR(255) NOT NULL,
    TelephoneNumber VARCHAR(14) NOT NULL,
    confirmation_number VARCHAR(6) NOT NULL,
    contact_confirmation_status VARCHAR(11) NOT NULL,
    created_at datetime NOT NULL,
    updated_at datetime NOT NULL
);

-- products table --
CREATE TABLE products(
	id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    product_img_name VARCHAR(255) NOT NULL,
    product_img_price VARCHAR(255) NOT NULL,
    product_img_id VARCHAR(255) NOT NULL,
    product_img_url VARCHAR(255) NOT NULL,
    product_amount VARCHAR(14) NOT NULL,
    product_total_amount int NOT NULL,
    created_at datetime NOT NULL,
    updated_at datetime NOT NULL
);

-- Contacts table --
CREATE TABLE messages(
	id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    userEmail VARCHAR(255) NOT NULL,
    message LONGTEXT NOT NULL,
    status VARCHAR(6) NOT NULL,
    created_at datetime NOT NULL,
    updated_at datetime NOT NULL
);

-- Newsletter subscriptions --
CREATE TABLE newslettersubscribers(
	id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    userEmail VARCHAR(255) NOT NULL,
    status VARCHAR(12) NOT NULL,
    created_at datetime NOT NULL,
    updated_at datetime NOT NULL
);

-- Stock table --
CREATE TABLE stock(
	id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
    price VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    status VARCHAR(12) NOT NULL,
    created_at datetime NOT NULL,
    updated_at datetime NOT NULL
);