# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel-based Vietnamese English learning platform ("Học Tiếng Anh") with comprehensive course management, user roles, and progress tracking. The application supports three user roles: Admin, Instructor, and Student.

## Common Development Commands

### Laravel Commands
```bash
# Development server
php artisan serve

# Database operations
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed

# Cache management
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generate application key
php artisan key:generate

# Code quality
vendor/bin/pint
```

### Asset Management
```bash
# Development build (watch mode)
npm run dev

# Production build
npm run build

# Install dependencies
npm install
composer install
```

### Testing
```bash
# Run all tests
php artisan test
# or
vendor/bin/phpunit

# Run specific test suite
vendor/bin/phpunit tests/Feature
vendor/bin/phpunit tests/Unit
```

### Code Quality
```bash
# Laravel Pint (code formatting)
vendor/bin/pint

# Check code style
vendor/bin/pint --test
```

## Architecture Overview

### Core Models & Relationships
- **User**: Manages authentication with role-based access (Admin/Instructor/Student)
- **Course**: Central entity with categories, lessons, and enrollments
- **Lesson**: Belongs to courses, tracks completion via pivot table
- **Category**: Organizes courses into logical groups
- **Enrollment**: Links users to courses they've joined
- **Quiz**: Assessment system with questions and attempts
- **UserProgress**: Tracks learning progress across courses

### Authentication & Authorization
- Laravel Breeze for authentication scaffold
- Custom AdminMiddleware for admin-only routes (`app/Http/Middleware/AdminMiddleware.php`)
- Role-based permissions using User model methods (`isAdmin()`, `isInstructor()`, `isStudent()`)

### Frontend Architecture
- **Public routes**: Home, course listing, course details
- **Auth routes**: Dashboard, enrolled courses, lesson viewing
- **Admin routes**: Full CRUD operations for all entities (`/admin` prefix)
- Views use Blade templates with Bootstrap 5 styling
- AdminLTE integration for admin panel

### Database Structure
Key tables:
- `users` (with role_id foreign key)
- `courses` (with category_id and instructor_id)
- `lessons` (with course_id and order)
- `enrollments` (user_id + course_id)
- `lesson_user` (pivot for lesson completion tracking)
- `quiz_attempts` (tracks quiz completions)

## Development Workflow

### Database Setup
1. Ensure MySQL is running
2. Create database: `CREATE DATABASE hoctienganh;`
3. Run migrations: `php artisan migrate:fresh --seed`
4. Default admin login: admin@hoctienganh.com / password

### Adding New Features
1. Create migrations for database changes
2. Update/create models with appropriate relationships
3. Add routes to `routes/web.php` (separate frontend/admin)
4. Create controllers in appropriate namespace
5. Build views using existing layout templates
6. Update seeders if needed for demo data

### Admin Panel Development
- All admin controllers in `app/Http/Controllers/Admin/`
- Views in `resources/views/admin/`
- Uses AdminLTE template (`layouts/adminlte-pure.blade.php`)
- Routes protected by `admin` middleware
- Dashboard uses `admin.dashboard-adminlte` view
- Quiz functionality fully implemented with create/edit/delete

### Frontend Development
- Public controllers in `app/Http/Controllers/`
- Views in `resources/views/`
- Uses main app layout (`layouts/app.blade.php`)
- Bootstrap 5 + custom CSS in `resources/css/app.css`

## Important Configuration

### Environment Variables
- Database connection in `.env`
- APP_KEY must be generated (`php artisan key:generate`)
- Default timezone: Asia/Ho_Chi_Minh

### Key Dependencies
- **Backend**: Laravel 10, Laravel Breeze, Laravel Sanctum
- **Frontend**: Vite, TailwindCSS, AlpineJS, Bootstrap 5
- **Database**: MySQL 8.0+
- **PHP**: 8.1+

### File Permissions
Ensure proper permissions for:
- `storage/` directory
- `bootstrap/cache/` directory
- `.env` file

## Testing Guidelines

- Feature tests in `tests/Feature/`
- Unit tests in `tests/Unit/`
- Authentication tests already exist
- Database uses SQLite for testing (configured in `phpunit.xml`)

## Deployment Notes

- Run `php artisan config:cache` in production
- Use `npm run build` for production assets
- Ensure proper file permissions on server
- Set up queue workers if using background jobs
- Configure proper error logging

## Security Considerations

- CSRF protection enabled globally
- Role-based access control implemented
- Input validation in Form Requests
- Mass assignment protection in models
- SQL injection prevention through Eloquent ORM