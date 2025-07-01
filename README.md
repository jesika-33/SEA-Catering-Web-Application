# **SEA Catering Web Application**

This repository contains the full codebase for the SEA Catering web application, a system designed to manage meal plans, subscriptions, user testimonials, and user authentication. The application is built using a traditional Apache, MySQL, PHP for the backend and standard web technologies such as HTML, CSS, JavaScript for the frontend.

## **Table of Contents**

1. Project Overview  
2. Features  
3. Technologies Used  
4. Prerequisites  
5. Setup Guide  
   * 1\. Clone the Repository  
   * 2\. Web Server Setup  
   * 3\. Database Setup  
     * Create Database  
     * Create users Table  
     * Create testimonials Table  
     * Create meal\_plans Table  
     * Create subscriptions Table  
     * Insert Sample Data  
     * Configure Database Connection  
6. File Structure  
7. Running the Application  
8. Key Backend Endpoints

## **Project Overview**

The SEA Catering web application provides a platform for customers to browse meal plans, subscribe to recurring deliveries, submit testimonials, and manage their subscriptions through a personalized dashboard. An authentication system ensures secure access for users.

## **Features**

* **User Authentication:** Secure user registration and login.  
* **Dynamic Navigation:** Users can navigate between pages using the navigation bar.  
* **Meal Plans:** Display various meal plans fetched dynamically from the database.  
* **Subscription Management:** Users can subscribe to meal plans.  
* **Contact Page:** A simple contact form (frontend only).  
* **Responsive Design:** Adapts to various screen sizes (mobile, tablet, desktop).

## **Technologies Used**

* **Frontend:**  
  * HTML5  
  * CSS3  
  * JavaScript (ES6 Modules)  
* **Backend:**  
  * PHP 7.4+  
  * MySQL / MariaDB  
* **Web Server:**  
  * Apache HTTP Server

## **Prerequisites**

Before you begin, ensure you have the following installed on your system:

* **Git:** For cloning the repository.  
  * [Download Git](https://git-scm.com/downloads)  
* **XAMPP, WAMP, or MAMP:** A local server environment that includes Apache (or Nginx), MySQL (or MariaDB), and PHP.  
  * [Download XAMPP](https://www.apachefriends.org/index.html)  
  * [Download WAMPserver](https://www.wampserver.com/en/)  
  * [Download MAMP](https://www.mamp.info/en/)

## **Setup Guide**

Follow these steps to get the SEA Catering application running on your local machine.

### **1\. Clone the Repository**

Open your terminal or Git Bash and run the following command:

git clone https://github.com/jesika-33/SEA-Catering-Web-Application  
cd SEA-Catering-Web-Application

### **2\. Web Server Setup**

Place the cloned sea-catering folder into your web server's document root directory:

* **XAMPP:** `C:\xampp\htdocs\ (Windows)` or `/Applications/XAMPP/htdocs/` (macOS)  
* **WAMP:** `C:\wamp64\www\ (Windows)`  
* **MAMP:** `/Applications/MAMP/htdocs/` (macOS)

Ensure your Apache and MySQL services are running via your XAMPP/WAMP/MAMP control panel.

### **3\. Database Setup**

You will need to create the database and tables, then populate them with initial data.

#### **Create Database**

Open your web browser and go to http://localhost/phpmyadmin (or your MySQL administration tool).  
Create a new database named seacatering\_db.

#### **Create users Table**

This table stores user registration information.

USE seacatering\_db;

CREATE TABLE IF NOT EXISTS users (  
    id INT AUTO\_INCREMENT PRIMARY KEY,  
    full\_name VARCHAR(255) NOT NULL,  
    email VARCHAR(255) NOT NULL UNIQUE,  
    password\_hash VARCHAR(255) NOT NULL,  
    role ENUM('user', 'admin') DEFAULT 'user',  
    created\_at TIMESTAMP DEFAULT CURRENT\_TIMESTAMP  
);

#### **Configure Database Connection**

Open the file php/db\_config.php and update the database credentials if they differ from the defaults (e.g., if your MySQL username or password is not root and empty respectively).

\<?php  
// php/db\_config.php

define('DB\_SERVER', 'localhost'); // Your database host  
define('DB\_USERNAME', 'root');    // Your MySQL username  
define('DB\_PASSWORD', '');        // Your MySQL password  
define('DB\_NAME', 'seacatering\_db'); // The name of your database

// Attempt to connect to MySQL database  
$mysqli \= new mysqli(DB\_SERVER, DB\_USERNAME, DB\_PASSWORD, DB\_NAME);

// Check connection  
if ($mysqli-\>connect\_error) {  
    die("ERROR: Could not connect. " . $mysqli-\>connect\_error);  
}  
?\>

## **File Structure**

sea-catering/  
├── CSS/  
│   ├── SEACateringHomePage.css  
│   ├── SEACateringSubscription.css  
│   └── SeaCateringTestimonials.css  
├── Images/  
│   ├── ... (your image assets)  
├── Javascript/  
│   ├── SEACateringNavBar.js  
│   ├── SEACateringMealPlans.js  
│   ├── SEACateringSubscription.js  
│   └── SEACatering.js  
├── php/  
│   ├── db\_config.php             \# Database connection configuration  
│   ├── get\_testimonials.php      \# Fetches testimonials data (API) (Not Used Yet)  
│   ├── login.php                \# Handles user login  
│   ├── logout.php                \# Handles user logout (Not Working Yet)  
│   ├── register.php                \# Handles user logout (Not Working Yet)  
│   ├── session\_check.php         \# Checks user login status  
│   └── submit\_testimonial.php    \# Processes testimonial form submissions  
├── index.php         \# User login and registration page  
├── SEACateringContactPage.html       \# Contact page  
├── SEACateringHomePage.html      \# Home page  
├── SEACateringMealPlans.php      \# Meal Plans page (PHP-rendered)  
├── SEACateringSubscription.html  \# Subscription form page  
├── SEACateringTestimonials.html  \# Testimonials page  
└── SEACateringUserDashboard.html \# User dashboard page

## **Running the Application**

1. **Start your web server and MySQL service** (via XAMPP/WAMP/MAMP control panel).  
2. Open your web browser and navigate to the project's URL. If you placed it directly in htdocs, it might be:  
   http://localhost/sea-catering/SEACateringHomePage.html  
   or  
   `http://localhost/sea-catering/index.php`

You can then navigate through the different pages:

* `http://localhost/sea-catering/index.phpl`  
* `http://localhost/sea-catering/SEACateringHomePage.html`  
* `http://localhost/sea-catering/SEACateringMealPlans.php`  
* `http://localhost/sea-catering/SEACateringSubscription.html`  
* `http://localhost/sea-catering/SEACateringTestimonials.html`  
* `http://localhost/sea-catering/SEACateringUserDashboard.html`

## **Key Backend Endpoints**

* `php/session_check.php`: Used by JavaScript to determine if a user is logged in and retrieve basic user data.  
* `php/logout.php`: Handles user logout by clearing the session.  
* `php/submit_testimonial.php`: Receives and saves new testimonials to the testimonials table.  
* php/get\_testimonials.php: Retrieves all testimonials from the testimonials table.  
* `php/register.php`: Processes new user registrations by hashing passwords and storing user data in the `users` table.  
* `php/login.php`: Authenticates user login attempts by verifying credentials against the `users` table and establishing a session.

## **Project Status**

This project is currently under development. The backend authentication (login and registration) is implemented. However, the backend functionality for the following features is **not yet fully implemented**:

* **Testimonials:** While the frontend can submit, the backend processing for storing and retrieving testimonials is still in progress and only stored locally at the moment. Once the page is refreshed, all inputted data is lost.  
* **Meal Plans:** The backend for dynamically fetching and managing meal plan data is still under development.  
* **Subscriptions:** The backend logic for processing subscriptions and managing existing ones (pause/cancel) is not yet complete.  
* **Logout:** The logout functionality is currently not working as expected.

We are actively working to complete these features.

