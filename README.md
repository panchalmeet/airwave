# Airwave

Airwave is a powerful web application built with PHP and GraphQL, designed for seamless management of airwave-related services. It integrates with a MySQL database for efficient data handling and provides a user-friendly interface for both administrators and users.

## Features
- User authentication and management
- GraphQL API integration for efficient data fetching
- Admin dashboard for managing services and data
- MySQL database integration for persistent data storage

## Tech Stack
- **Backend**: PHP, Laravel
- **API**: GraphQL
- **Database**: MySQL
- **Authentication**: Laravel Passport for API authentication

## Installation Instructions

### Prerequisites
- PHP >= 7.3
- Composer
- MySQL

### Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/panchalmeet/airwave.git
   cd airwave
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up environment variables:
   Copy `.env.example` to `.env` and update your database credentials.

4. Generate encryption keys:
   ```bash
   php artisan key:generate
   ```

5. Install Passport for API authentication:
   ```bash
   php artisan passport:install
   ```

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

7. (Optional) Seed the database with sample data:
   ```bash
   php artisan db:seed
   ```

8. Start the server:
   ```bash
   php artisan serve
   ```

### Access
Once set up, the application can be accessed at `http://localhost:8000`.

## Contributing
Contributions are welcome! Fork the repository, make your changes, and submit a pull request.

## License
MIT License
