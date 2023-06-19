# <p align="center">Laravel + Vue App by Joelrey</p>

<p align="center">
    Join a fast-growing team of rockstar creatives and code wizards who are passionate about making customers say “WOW”. If you believe you have what it takes and want to grow your career instead of just finding another job - you are at the right place!
</p>

## Instructions

1.	Install Required Software:

•	Install Git: If you haven't already, download and install Git from the official website: https://git-scm.com/downloads

•	Install PHP: Make sure you have PHP installed on your local machine. You can download PHP from the official website: https://www.php.net/downloads

•	Install Composer: Composer is a dependency management tool for PHP. Install it by following the instructions on the Composer website: https://getcomposer.org/download/

2.	Clone the Repository:

•	Open your terminal or command prompt.

•	Navigate to the directory where you want to store the project.

•	Clone the GitHub repository by running the following command:

git clone <repository_url>
Replace <repository_url> with the URL of the GitHub repository.

•	Change into the project directory:

cd <project_directory>

3.	Install Dependencies:

•	Run the following command to install the PHP dependencies specified in the composer.json file:

composer install

•	Next, install the JavaScript dependencies specified in the package.json file by running:

npm install

4.	Environment Configuration:

•	Copy the .env.example file to a new file called .env:

cp .env.example .env

•	Generate an application key by running the following command:

php artisan key:generate

5.	Database Configuration:

•	Create a new MySQL database for your project if you haven't already.

•	Open the .env file and update the database configuration parameters (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD) with your database credentials.

6.	Run Migrations:

•	Run the database migrations to create the required tables in the database:

php artisan migrate:fresh --seed

7.	Build Assets:

•	Compile the frontend assets (Vue components, CSS, etc.) by running:

npm run dev

8.	Start Local Server:

•	Run the Laravel development server:

php artisan serve

9.	Access the App:

•	Open your web browser and visit the URL displayed by the Laravel development server (usually http://localhost:8000).

•	You should now see your Laravel+Vue app running on the local server.

Congratulations! You have successfully pulled the Laravel+Vue app from the GitHub repository and set it up on your local server. You can now explore and interact with the application locally.
