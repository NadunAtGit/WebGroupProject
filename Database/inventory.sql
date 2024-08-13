CREATE DATABASE inventory1;

USE inventory1;

CREATE TABLE users (
    User_ID INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE suppliers (
    Supplier_ID INT AUTO_INCREMENT PRIMARY KEY,
    supplier_name VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    email VARCHAR(255),
    items TEXT
);

CREATE TABLE products (
    Product_ID INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    category VARCHAR(100)
);

CREATE TABLE purchases (
    Stock_ID INT,
    Product_ID INT,
    quantity INT NOT NULL,
    price_per_unit DECIMAL(10, 2) NOT NULL,
    Supplier_ID INT,
    Date DATE NOT NULL,
    PRIMARY KEY (Stock_ID, Product_ID),
    FOREIGN KEY (Product_ID) REFERENCES products(Product_ID),
    FOREIGN KEY (Supplier_ID) REFERENCES suppliers(Supplier_ID)
);


CREATE TABLE inventory (
    stock_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price_per_unit DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (stock_id, product_id),
    FOREIGN KEY (stock_id) REFERENCES purchases(Stock_ID),
    FOREIGN KEY (product_id) REFERENCES products(Product_ID)
);

CREATE TABLE orders (
    Order_ID INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    Total DECIMAL(10, 2) NOT NULL,
    price_per_unit DECIMAL(10, 2) NOT NULL,
    discounts DECIMAL(10, 2),
    FOREIGN KEY (product_id) REFERENCES products(Product_ID)
);

ALTER TABLE users
ADD image_path VARCHAR(255) DEFAULT NULL;

ALTER TABLE purchases
ADD selling_price DECIMAL(10, 2) NOT NULL;
