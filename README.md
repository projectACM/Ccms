# Credit Card Management System (CCMS)

A lightweight, zero-dependency Credit Card Management System built with plain PHP and vanilla JavaScript. This project is designed for easy deployment on modern hosting platforms like Render and Railway.

## Features

### Core Features (Backend Implemented)
- **User Authentication**: Secure user registration and login.
- **Profile Management**: Users can update their name, email, and password.
- **Card CRUD**: Add, view, edit, and delete credit cards.

### Dummy Features (Frontend Only)
The following features are implemented with a UI and mock data to simulate a complete experience:
- Expenditure Analysis
- EMI & Rewards Tracking
- Autopay Setup
- Credit Score Monitoring
- Fraud Monitoring

## Tech Stack

- **Backend**: PHP 8.x (No frameworks)
- **Frontend**: HTML, CSS, Vanilla JavaScript (No frameworks or libraries)
- **Database**: MySQL
- **Deployment**: Designed for Render (PHP Web Service) & Railway (MySQL Database)

## Deployment Instructions

This guide will walk you through deploying the application using Render for the PHP service and Railway for the MySQL database.

### Step 1: Set Up the MySQL Database on Railway

1.  **Create a Railway Account**: Sign up at [railway.app](https://railway.app/).
2.  **Create a New Project**: Start a new project and choose to provision a **MySQL** database.
3.  **Get Database Credentials**: Once the database is created, navigate to its "Connect" tab. You will find all the necessary credentials here:
    - `MYSQLHOST` (DB_HOST)
    - `MYSQLDATABASE` (DB_NAME)
    - `MYSQLUSER` (DB_USER)
    - `MYSQLPASSWORD` (DB_PASS)
    - `MYSQLPORT` (DB_PORT)
4.  **Import the Schema**:
    - In the "Data" tab of your Railway MySQL service, you will find a query editor.
    - Open the `schema.sql` file from this repository.
    - Copy the entire content of `schema.sql`.
    - Paste the SQL commands into the Railway query editor and run them. This will create the `users` and `cards` tables.

### Step 2: Deploy the PHP Application on Render

1.  **Create a Render Account**: Sign up at [render.com](https://render.com/).
2.  **Create a New Web Service**:
    - Click "New +" and select "Web Service".
    - Connect your GitHub account and select this repository.
3.  **Configure the Service**:
    - **Name**: Give your service a name (e.g., `ccms-app`).
    - **Region**: Choose a region close to your Railway database region.
    - **Branch**: Select your main branch.
    - **Runtime**: Select **PHP**.
    - **Build Command**: Leave this blank.
    - **Start Command**: `php -S 0.0.0.0:80 -t public`
    - **Instance Type**: The "Free" tier is sufficient for this project.

4.  **Add Environment Variables**:
    - This is the most critical step. Go to the "Environment" tab for your new Render service.
    - Add the following environment variables, using the credentials you got from Railway in Step 1:
      - `DB_HOST`: Your `MYSQLHOST` from Railway.
      - `DB_NAME`: Your `MYSQLDATABASE` from Railway.
      - `DB_USER`: Your `MYSQLUSER` from Railway.
      - `DB_PASS`: Your `MYSQLPASSWORD` from Railway.
      - `DB_PORT`: Your `MYSQLPORT` from Railway.

5.  **Deploy**:
    - Click "Create Web Service". Render will automatically pull your code, configure the environment, and start the application.
    - Once deployed, you can access your live site at the URL provided by Render.

## How It Works

- **`public/`**: This directory is the web root. All user-facing PHP files are here. `index.php` redirects to the dashboard or login page.
- **`config/db.php`**: This file handles the database connection using the environment variables you set. It also contains helper functions for authentication.
- **`schema.sql`**: Defines the database structure.
- **`assets/`**: Contains the single CSS and JS files for the entire application.
- **No Dependencies**: The project uses no external libraries, frameworks, or package managers (like Composer), making it extremely portable and easy to deploy.
