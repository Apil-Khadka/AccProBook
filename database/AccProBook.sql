use ProBook;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(100),
    lastName VARCHAR(100),
    useremail VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Insert into users (firstName, lastName, useremail, password) values
('John', 'Doe', 'test@example.com', '$2a$10$vmunZShzMEzd3sifMM0mYuSyqpmU5ZBNTYUuVC1bQFJXzRf8iplMS');


CREATE TABLE BusinessInfo (
    business_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    business_name VARCHAR(255),
    address TEXT,
    contact_number VARCHAR(20),
    email VARCHAR(150),
    website VARCHAR(255),
    logo_path VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE Company (
    company_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    companyName VARCHAR(255),
    companyAddress TEXT,
    contactName VARCHAR(150),
    companyEmail VARCHAR(150),
    phoneNumber VARCHAR(20),
    landLineNumber VARCHAR(20),
    state VARCHAR(100),
    country VARCHAR(100),
    URL VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE Customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    email VARCHAR(150),
    phone VARCHAR(20),
    street VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    postalcode VARCHAR(20),
    country VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE Product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    productName VARCHAR(255),
    productPrice DECIMAL(10,2),
    productDescription TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE Terms (
    term_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    termName VARCHAR(255),
    termData TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

USE ProBook;

CREATE TABLE Invoice (
    invoice_id         INT             AUTO_INCREMENT PRIMARY KEY,
    user_id            INT             NOT NULL,
    customer_id        INT             DEFAULT NULL,
    company_id         INT             DEFAULT NULL,
    product_id         INT             NOT NULL,
    invoice_number     VARCHAR(100)    NOT NULL UNIQUE,
    invoice_date       DATE            NOT NULL,
    invoice_due_date   DATE            NOT NULL,
    terms              TEXT,
    quantity           INT             NOT NULL,
    rate               DECIMAL(10,2)   NOT NULL,
    discount           DECIMAL(10,2)   DEFAULT 0,
    subtotal           DECIMAL(12,2)   NOT NULL,
    tax                DECIMAL(10,2)   DEFAULT 0,
    total_amount       DECIMAL(12,2)   NOT NULL,
    notes              TEXT,
    created_at         TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_one_party CHECK (
        (customer_id IS NOT NULL AND company_id IS NULL) OR
        (customer_id IS NULL AND company_id IS NOT NULL)
    ),
    FOREIGN KEY (user_id)     REFERENCES users(user_id),
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
    FOREIGN KEY (company_id)  REFERENCES Company(company_id),
    FOREIGN KEY (product_id)  REFERENCES Product(product_id)
);
