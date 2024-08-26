## Database Setup

Go to the `Database` folder, and you will find a SQL file named `inventory2.sql`. Import this file into phpMyAdmin before running the project.

## ----Tech-Tool Inventory Management System----

Tech-Tool is a web-based Inventory Management System built with PHP and MySQL. 
It helps users manage inventory items efficiently with features like item addition, deletion, updates, reporting, and Point of Sales (POS).

Prerequisites:
- PHP 7.4+
- MySQL 5.7+
- Apache Web Server
- JavaScript-enabled Web Browser (Chrome, Firefox, Safari, etc.)

Installation:
1. Download zip file from git repository: https://github.com/NadunAtGit/WebGroupProject
2. Extract the zip file and move the project folder to your web server's root directory (e.g., htdocs for Apache).
3. Create a database named "inventory2" and import the "inventory2.sql" file into the inventory2 database to set up the schema.

Configuration:
1. Edit db.php with your database credentials:
   - HOSTNAME: Your database host (usually 'localhost')
   - USERNAME: Your MySQL username
   - PASSWORD: Your MySQL password
   - DATABASE: inventory2

Running the Application:
1. Start Apache and MySQL services using XAMPP or WAMP.
2. Access the application via your web browser at http://localhost/techtool (replace techtool with the actual folder name if different).
3. Log in using the default credentials:

	Admin - User name :- admin
	        Password  :- admin@1234

	User - User name :- user
	       Password  :- user@1234

Troubleshooting:
1.Ensure that Apache and MySQL services are running.
2.Verify that your database credentials in db.php are correct.
3.Check the web server error logs for any issues if the application does not load.




