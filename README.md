<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## How to setup project

To run this backend application, you need to ensure that you have PHP version 8 or less installed on your system. You 
should also have composer installed on your system. If possible install XAMPP on your system. That way you will have 
the necessary tools to run the application.

- [Clone the backend repo here](https://github.com/elvisasante323/golden-shoe-backend.git).
- Navigate to the root of the backend repo and enter this command <code>composer install</code>.
- Once <code>composer</code> is installed, boot up phpMyadmin and create a database called <code>golden_shoe</code> and 
  run this sql file called <code>golden_shoe.sql</code>. You can find this file at the root of the repo.
- Running the sql file will bring up all the tables needed to run the application successfully.
- Lastly, run this command <code>php artisan serve</code>. Copy and paste the server url into your browser. When you 
see the laravel home page, then the application is successfully.
  
