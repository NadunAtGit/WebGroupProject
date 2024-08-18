CREATE DATABASE inventory2;

USE inventory2;

CREATE TABLE users (
    User_ID VARCHAR(50) PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    image_path VARCHAR(255) DEFAULT NULL
);

CREATE TABLE suppliers (
    Supplier_ID VARCHAR(50) PRIMARY KEY,
    supplier_name VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    email VARCHAR(255),
    items TEXT
);

CREATE TABLE products (
    Product_ID VARCHAR(50) PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    category VARCHAR(100)
);

CREATE TABLE purchases (
    Stock_ID VARCHAR(50),
    Product_ID VARCHAR(50),
    quantity INT NOT NULL,
    price_per_unit DECIMAL(10, 2) NOT NULL,
    Supplier_ID VARCHAR(50),
    Date DATE NOT NULL,
    PRIMARY KEY (Stock_ID, Product_ID),
    selling_price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE inventory (
    stock_id VARCHAR(50),
    product_id VARCHAR(50),
    quantity INT NOT NULL,
    price_per_unit DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (stock_id, product_id)
);

CREATE TABLE orders (
    Order_ID VARCHAR(50) PRIMARY KEY,
    product_id VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    Total DECIMAL(10, 2) NOT NULL,
    price_per_unit DECIMAL(10, 2) NOT NULL,
    discounts DECIMAL(10, 2)
);
