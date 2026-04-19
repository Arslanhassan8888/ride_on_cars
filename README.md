# RideOn Cars – Database-Driven E-Commerce Website

## Demo Accounts (For Testing)

You can use the following accounts to test the system:

**Admin Account**
- Email: arslan@gmail.com  
- Password: ciao123  

**User Account**
- Email: usman@gmail.com  
- Password: ciao123  

---

## Project Overview

RideOn Cars is a database-driven e-commerce web application developed using PHP and MySQL. The system allows users to browse, search, and interact with a catalogue of ride-on cars for children, while providing administrative tools for managing products and users.

The project was developed and tested locally using **WAMP Server**, with data stored in a **MySQL database**.

---

## Live Website

https://rideoncars2026.is-great.net/


---

## Technologies Used

### Backend
- PHP
- MySQL (PDO)

### Frontend
- HTML5
- CSS3
- JavaScript

### Environment & Tools
- WAMP Server (Apache + MySQL)
- phpMyAdmin
- Visual Studio Code
- Git & GitHub

---

## Key Features

### User Features
- User registration and login system
- Secure password hashing
- Product browsing and filtering
  - Search by name
  - Price range filtering
  - Sorting (price, rating, name)
- Product details page
- Session-based shopping cart
- Customer reviews system
- Contact form with validation

### Admin Features
- Admin authentication and access control
- Add new products (with image upload)
- Edit existing products
- Delete products
- Manage users (view and delete accounts)

---

## Database Structure

The application uses a relational database with the following tables:

- `users` – user accounts and roles (admin/user)
- `products` – product details (name, price, image, description)
- `reviews` – customer reviews linked to users

---

## Security Features

- PDO prepared statements (SQL injection protection)
- Password hashing using `password_hash()` and `password_verify()`
- Output sanitisation using `htmlspecialchars()`
- Session-based authentication
- Role-based access control (admin vs user)

---

## Accessibility

The project has been tested using:

- W3C Validator  
- WAVE  
- AXE DevTools  
- Google Lighthouse  

Accessibility features include:

- Semantic HTML structure
- Keyboard navigation support
- Skip navigation links
- Screen reader-friendly labels
- Accessible forms and error messages
- Hidden headings for assistive technologies

---

## Installation (Local Setup using WAMP)

### 1. Install WAMP Server
Download from:  
https://www.wampserver.com/

Ensure:
- Apache is running
- MySQL is running
- WAMP icon is green

---

### 2. Place Project Folder
Copy the project into:

C:\wamp64\www\


---

### 3. Create Database
Go to:
http://localhost/phpmyadmin

- Create database: `ride_on_cars`
- Import the provided `.sql` file  
- (Ensure the file is fully uncommented before importing)

---

### 4. Configure Database Connection

Open `db.php`:

```php
$pdo = new PDO(
    "mysql:host=localhost;dbname=ride_on_cars;charset=utf8",
    "root",
    ""
);
```
### 5. Run the Project

Open in browser:
http://localhost/project-folder/


## Project Structure
```
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
│
├── db.php
├── header.php
├── footer.php
```

## Learning Outcomes
- Building a dynamic website using PHP and MySQL
- Implementing authentication and session management
- Applying web security best practices
- Developing accessible web interfaces
- Structuring a maintainable project

----

## Limitations
- No payment or checkout system
- No CSRF protection
- Limited file upload validation
- No email verification system
  
---

## Future Improvements
- Security
- Add CSRF protection
- Implement password reset system
- Add email verification
  
---

## Features
- Full checkout and payment system
- Order history for users
- Product categories and filtering improvements
- UI/UX
- Improve mobile responsiveness
- Add dark mode
- Enhance user interface design

## Author

## Arslan Hassan
