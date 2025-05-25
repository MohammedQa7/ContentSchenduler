# Laravel + Vue.js Project

This is a Laravel and Vue.js application. Follow the instructions below to set it up on your local machine.

Clone the repository using the command below:

git clone https://github.com/your-username/your-repository.git

Navigate into the project directory (replace `your-repository` with your actual folder name):

cd your-repository

Once inside the project folder, run the following commands:

Install PHP dependencies using Composer:

composer install

Copy the example environment file:

cp .env.example .env

Generate the application key:

php artisan key:generate

Open the .env file and update your database credentials:

DB_DATABASE=your_database_name  
DB_USERNAME=your_database_user  
DB_PASSWORD=your_database_password

Make sure the database exists.

Run database migrations:

php artisan migrate

(Optional) Run seeders to populate initial data:

php artisan db:seed

Install Node.js dependencies:

npm install

Run the frontend development server (Vite):

npm run dev

In another terminal window/tab, start the Laravel development server:

php artisan serve

Open your browser and visit:

http://localhost:8000
