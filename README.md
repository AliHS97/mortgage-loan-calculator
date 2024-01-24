# Mortgage Loan Calculator

This application is designed for managing loans, including user profiles and loan amortization schedules.

## Installation

1. **Clone the repository to your local machine:**

   ```bash
   git clone https://github.com/AliHS97/mortgage-loan-calculator.git
   ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Copy the .env.example file to create a .env file:**

    ```bash
    cp .env.example .env
    ```

4. **Configure your database connection in the .env file:**

    ```env
    DB_CONNECTION=mysql
    DB_HOST=your-db-host
    DB_PORT=your-db-port
    DB_DATABASE=your-db-name
    DB_USERNAME=your-db-username
    DB_PASSWORD=your-db-password
    ```

5. **Run the database migrations:**

    ```bash
    php artisan migrate
    ```

6. **Start dev server in watch mode:**

    ```bash
    npm run dev
    ```

7. **Run the tests:**

    ```bash
    php artisan test
    ```
    
8. **Start the development server:**

    ```bash
    php artisan serve
    ```

9. **Visit: http://127.0.0.1:8000/register and add your info**

## Usage

# Dashboard
Access the dashboard after authentication to get an overview of the application.

# Profile Management
Edit your profile: /profile/edit  
Update your profile: PATCH /profile  
Delete your profile: DELETE /profile  

# Loan Management
View all loans: /loans  
Create a new loan: /loans/create  
Store a new loan: POST /loans  
View amortization schedule for a loan: /loans/{loan}/amortization/schedule  
Make extra payment for a loan: POST /loans/{loan}/extra/payment  

# Routes
Homepage: http://localhost:8000  
Dashboard: http://localhost:8000/dashboard  
Edit Profile: http://localhost:8000/profile/edit  
All Loans: http://localhost:8000/loans  
Create Loan: http://localhost:8000/loans/create  
Make Extra Payment: http://localhost:8000/loans/{loan}/extra/payment  

# Contributing
Feel free to contribute by opening issues or submitting pull requests. Ensure you follow the established coding standards.
