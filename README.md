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

### Extra features

- **Mail server** to see emails
- **Languages** used to make key translations

## Installation

1. Run install bash

```sh
bash install.sh
```

2. Open in browser:

```url
http://localhost:8006

username: test
email: test@test.com
password: 123
```

### To stop

   ```sh
   bash stop.sh
   ```

### To start again

   ```sh
   bash start.sh
   ```

## API

   ```url
   http://localhost:8006/api/documentation
   ```

## Local Mail Server

Open mail server to see emails for reset password

   ```url
   http://localhost:8025
   ```

## Tests

Run tests:

   ```sh
   bash test.sh
   ```

## License

This project is licensed under the MIT License.