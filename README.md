# RideOn Cars – Database-Driven Website

## Project Overview

RideOn Cars is a database-driven e-commerce website developed as part of the **Database Driven Websites Project**.

The application demonstrates the design and implementation of a dynamic web system using **PHP, MySQL, HTML5, CSS3, and JavaScript**. It enables users to browse and interact with a catalogue of ride-on cars for children, while also providing administrative functionality for managing products and users.

A live version of the website is available at:  
http://rideoncars.infinityfreeapp.com

---

## Objectives

The purpose of this project is to:

- Develop a fully functional database-driven website
- Apply server-side scripting to interact with a relational database
- Implement user authentication and session management
- Demonstrate awareness of web accessibility and security principles
- Produce a maintainable and structured web application

---

## Key Features

### User Functionality

- User registration and login system
- Secure password storage using hashing
- Product browsing and filtering (search, price range, sorting)
- Individual product detail pages
- Session-based shopping cart
- Customer reviews system (submission and display)
- Contact form for enquiries

### Administrative Functionality

- Restricted admin access via authentication
- Add new products with image upload
- Edit and update existing products
- Delete products from the database
- Manage user accounts (including deletion)

---

## Technologies Used

- **Frontend:** HTML5, CSS3, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL (using PDO)  
- **Server Environment:** Apache (WAMP recommended)

---

## Database Structure

The system is built on a relational database consisting of the following core tables:

- `users` – stores user credentials and roles (admin/user)
- `products` – stores product details including pricing, descriptions and images
- `reviews` – stores customer reviews linked to users

---

## Security Considerations

The application incorporates several security practices:

- Use of **PDO prepared statements** to prevent SQL injection
- Password hashing using `password_hash()` and `password_verify()`
- Output sanitisation using `htmlspecialchars()` to mitigate XSS attacks
- Session-based authentication and role-based access control for admin features

---

## Accessibility and Usability

The website has been developed with accessibility in mind:

- Use of semantic HTML elements
- Proper labelling of form inputs
- Skip navigation links for keyboard users
- Alternative text for images
- Responsive design for different screen sizes

---

## Installation and Setup (Local Environment – WAMP)

### 1. Install WAMP Server

Download and install WAMP Server from:  
https://www.wampserver.com/

Ensure that:
- Apache and MySQL services are running
- The WAMP icon is green

---

### 2. Place Project in Web Directory

Copy the project folder into:
# RideOn Cars – Database Driven Website

## Project Overview

RideOn Cars is a database-driven e-commerce website developed as part of the **Database Driven Websites (Level 5)** unit.

The application demonstrates the design and implementation of a dynamic web system using **PHP, MySQL, HTML5, CSS3, and JavaScript**. It enables users to browse and interact with a catalogue of ride-on cars for children, while also providing administrative functionality for managing products and users.

A live version of the website is available at:  
http://rideoncars.infinityfreeapp.com

---

## Objectives

The purpose of this project is to:

- Develop a fully functional database-driven website
- Apply server-side scripting to interact with a relational database
- Implement user authentication and session management
- Demonstrate awareness of web accessibility and security principles
- Produce a maintainable and structured web application

---

## Key Features

### User Functionality

- User registration and login system
- Secure password storage using hashing
- Product browsing and filtering (search, price range, sorting)
- Individual product detail pages
- Session-based shopping cart
- Customer reviews system (submission and display)
- Contact form for enquiries

### Administrative Functionality

- Restricted admin access via authentication
- Add new products with image upload
- Edit and update existing products
- Delete products from the database
- Manage user accounts (including deletion)

---

## Technologies Used

- **Frontend:** HTML5, CSS3, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL (using PDO)  
- **Server Environment:** Apache (WAMP recommended)

---

## Database Structure

The system is built on a relational database consisting of the following core tables:

- `users` – stores user credentials and roles (admin/user)
- `products` – stores product details including pricing, descriptions and images
- `reviews` – stores customer reviews linked to users

---

## Security Considerations

The application incorporates several security practices:

- Use of **PDO prepared statements** to prevent SQL injection
- Password hashing using `password_hash()` and `password_verify()`
- Output sanitisation using `htmlspecialchars()` to mitigate XSS attacks
- Session-based authentication and role-based access control for admin features

---

## Accessibility and Usability

The website has been developed with accessibility in mind:

- Use of semantic HTML elements
- Proper labelling of form inputs
- Skip navigation links for keyboard users
- Alternative text for images
- Responsive design for different screen sizes

---

## Installation and Setup (Local Environment – WAMP)

### 1. Install WAMP Server

Download and install WAMP Server from:  
https://www.wampserver.com/

Ensure that:
- Apache and MySQL services are running
- The WAMP icon is green

---

### 2. Place Project in Web Directory

Copy the project folder into:
C:\wamp64\www\


---

### 3. Create Database

1. Open your browser and go to:
http://localhost/phpmyadmin

2. Create a new database named:
ride_on_cars

3. Import the provided SQL file 

---

### 4. Configure Database Connection

Open `db.php` and ensure the connection is correct:

```php
$pdo = new PDO(
 "mysql:host=localhost;dbname=ride_on_cars;charset=utf8",
 "root",
 ""
);
```
### 5. Run Website

Open: http://localhost/project-folder/

## Project Structure

/project-root
│
├── index.php
├── about.php
├── products.php
├── product_details.php
├── cart.php
├── login.php
├── register.php
├── reviews.php
├── contact.php
│
├── admin/
│   ├── dashboard.php
│   ├── add_product.php
│   ├── edit_product.php
│   ├── delete_product.php
│   ├── manage_users.php
│
├── css/
├── js/
├── images/
├── db.php
├── header.php
├── footer.php

## Learning Outcomes
- LO1: Database-driven content using PHP and MySQL
- LO2: Accessible and secure web development
- LO3: Evaluation of usability, accessibility, and security

## Limitations and Future Improvements

- No payment or checkout system
- Limited file upload validation
- No CSRF protection
- UI/UX improvements possible

## Author

Arslan Hassan


