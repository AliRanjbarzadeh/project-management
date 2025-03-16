# Laravel Project Management

This is a **Laravel-based project management** that enables users to register, authenticate, and manage projects and
tasks efficiently. Built with a **clean code structure** and following the **service pattern**, this API ensures
maintainability and scalability.

## Features

### User Authentication

- **Register** a new account
- **Login** using email and password
- **Password Reset** functionality
- **User Profile** with basic information

### Project Management

- **Users can create and manage projects**
- **Each project is associated with a user**

### Task Management

- **Tasks are linked to specific projects**
- **CRUD operations** for managing tasks efficiently

### API Endpoints

This project provides **5 API requests** with **basic authentication** for project and task management:

1. **Projects List** – Retrieve all projects related to the authenticated user.
2. **Tasks API**
    - **Store** – Create a new task under a project.
    - **List** – Get all tasks for a specific project.
    - **Mark as Complete** – Update the status of a task to completed.
    - **Delete** – Remove a task from a project.

### Documentation

- The API is **fully documented** using **Swagger** for better clarity and ease of integration.

### Code Structure

- The project follows the **Service Pattern** for a **clean and maintainable** architecture.
- **Dashboard Panel** for users to manage their projects and tasks efficiently.

## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/AliRanjbarzadeh/project-management
   ```
2. Navigate to the project directory:
   ```sh
   cd project-management
   ```
3. Install docker dependencies:
   ```sh
   docker compose up --build -d
   ```
4. Copy the environment file and update the necessary configurations:
   ```sh
   docker exec -it project-management cp .env.example .env
   ```
5. Install composer dependencies:
   ```sh
   docker exec -it project-management cp composer install
   ```
6. Generate application key:
   ```sh
   docker exec -it project-management php artisan key:generate
   ```
7. Link storage:
   ```sh
   docker exec -it project-management php artisan storage:link
   ```
8. Set database config in .env:
   ```sh
   DB_CONNECTION=pgsql
   DB_HOST=db
   DB_PORT=5432
   DB_DATABASE=crm
   DB_USERNAME=user
   DB_PASSWORD=123
   ```
9. Run migrations:
   ```sh
   docker exec -it project-management php artisan migrate
   ```
10. Run database seed:
   ```sh
   docker exec -it project-management php artisan db:seed
   ```
11. Open in browser:
   ```url
   http://localhost:8006
   
   username: test
   email: test@example.com
   password: 123
   ```

## API
   ```url
   http://localhost:8006/api/documentation
   ```

## Tests

Run tests:

   ```sh
   docker exec -it project-management php artisan test
   ```

# Notice

It's very important to run **db:seed** again after you run test, because all data in database will be cleared after
tests completed

## License

This project is licensed under the MIT License.