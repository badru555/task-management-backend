<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Task Management Backend

This is a backend for authentication, task management and task attachment file upload service. Get started:

- update the composer
- set database in .env
- do migration and seeder

## Endpoints [postman collection included (./postman)]
#### Authentication Endpoints:
- `POST /api/auth/login` - User authentication with JWT
- `POST /api/auth/logout` - Logout user
- `GET /api/auth/me` - Get current user info

#### Task Management Endpoints:
- `GET /api/tasks` - List tasks with pagination, filtering, and sorting
- `POST /api/tasks` - Create new task
- `PUT /api/tasks/{id}` - Update task
- `DELETE /api/tasks/{id}` - Delete task

#### File Upload Endpoints:
- `POST /api/tasks/{id}/attachments` - Upload file attachment
- `GET /api/attachments/{id}/download` - Download attachment
- `DELETE /api/attachments/{id}` - Delete attachment
