# 🎓 Event Management REST API - Learning Project

> **A comprehensive Laravel 11 REST API built for educational purposes**  
> *Mastering Laravel through hands-on development of a real-world event management system*

This project serves as a practical learning journey through Laravel 11's advanced features, implementing modern PHP development practices and API design principles. Perfect for developers looking to understand Laravel's ecosystem through a complete, production-ready application.

## 🎯 Learning Objectives

This project demonstrates mastery of:

### 🏗️ **Laravel Fundamentals**
- **Eloquent ORM**: Advanced relationships, eager loading, and query optimization
- **Migrations & Seeders**: Database schema design and test data generation
- **Model Factories**: Realistic data generation for testing and development
- **Validation**: Comprehensive input validation and error handling

### 🔐 **Authentication & Security**
- **Laravel Sanctum**: Token-based API authentication
- **Authorization Policies**: Role-based access control and resource protection
- **Rate Limiting**: API protection against abuse and overuse
- **Security Best Practices**: Input sanitization and secure data handling

### 🚀 **Advanced Laravel Concepts**
- **API Resources**: Clean, consistent JSON response formatting
- **Task Scheduling**: Automated background job processing
- **Queue System**: Asynchronous job processing for better performance
- **Notifications**: Email notification system with custom templates
- **Service Layer**: Organized business logic separation

### 📊 **Database & Performance**
- **Relationship Management**: Complex many-to-many relationships
- **Query Optimization**: Eager loading and N+1 query prevention
- **Pagination**: Efficient data handling for large datasets
- **Database Design**: Normalized schema with proper indexing

## 🚀 Features Implemented

### Core Functionality
- **Event Management**: Full CRUD operations with validation
- **Attendee System**: User registration and management for events
- **Authentication**: Secure token-based API authentication
- **Authorization**: Policy-based access control with role management
- **Automated Reminders**: Scheduled email notifications for upcoming events
- **API Rate Limiting**: Built-in protection against API abuse

### Advanced Features
- **API Resources**: Clean, consistent JSON responses with relationship loading
- **Eager Loading**: Optimized database queries with conditional relationship loading
- **Pagination**: Efficient data pagination for large datasets
- **Validation**: Comprehensive input validation and error handling
- **Queuing**: Background job processing for notifications
- **Seeding**: Realistic test data generation with factories

## 🛠️ Technologies Used

- **Laravel 11** - PHP framework
- **Laravel Sanctum** - API authentication
- **SQLite** - Database (easily configurable for MySQL/PostgreSQL)
- **Faker** - Test data generation
- **Laravel Queues** - Background job processing
- **Laravel Notifications** - Email notifications
- **Laravel Policies** - Authorization system

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- SQLite (or MySQL/PostgreSQL)

## 🔧 Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd event-management
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Start the development server**
   ```bash
   php artisan serve
   ```

## 📚 API Documentation

### Authentication

#### Login
```http
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

### Events

#### Get All Events
```http
GET /api/events
GET /api/events?include=user,attendees
```

#### Get Single Event
```http
GET /api/events/{id}
GET /api/events/{id}?include=user,attendees,attendees.user
```

#### Create Event (Protected)
```http
POST /api/events
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Laravel Conference 2024",
    "description": "Annual Laravel conference",
    "start_time": "2024-12-01 09:00:00",
    "end_time": "2024-12-01 17:00:00"
}
```

#### Update Event (Protected)
```http
PUT /api/events/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Updated Event Name",
    "description": "Updated description"
}
```

#### Delete Event (Protected)
```http
DELETE /api/events/{id}
Authorization: Bearer {token}
```

### Attendees

#### Get Event Attendees
```http
GET /api/events/{event_id}/attendees
GET /api/events/{event_id}/attendees?include=user
```

#### Register for Event (Protected)
```http
POST /api/events/{event_id}/attendees
Authorization: Bearer {token}
```

#### Unregister from Event (Protected)
```http
DELETE /api/events/{event_id}/attendees/{attendee_id}
Authorization: Bearer {token}
```

## 🔐 Authorization

The API implements comprehensive authorization using Laravel Policies:

- **Events**: Only event owners can update or delete their events
- **Attendees**: Event owners or the attendee themselves can remove attendance
- **Public Access**: Anyone can view events and attendees

## 📊 Database Schema

### Events Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `name` - Event name
- `description` - Event description
- `start_time` - Event start time
- `end_time` - Event end time
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Attendees Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `event_id` - Foreign key to events table
- `created_at` - Registration timestamp
- `updated_at` - Last update timestamp

## 🔄 Automated Features

### Event Reminders
The system automatically sends email reminders for events starting within 24 hours:

```bash
# Run manually
php artisan app:send-event-reminders

# Or let the scheduler handle it (runs daily)
php artisan schedule:work
```

### Task Scheduling
The reminder system is configured to run daily via Laravel's task scheduler.

## 🧪 Testing

### Seed Data
The application includes comprehensive seeders:

```bash
# Seed users, events, and attendees
php artisan db:seed

# Or seed specific data
php artisan db:seed --class=EventSeeder
php artisan db:seed --class=AttendeeSeeder
```

### Factory Data
- **EventFactory**: Generates realistic event data
- **UserFactory**: Creates test users
- **AttendeeSeeder**: Simulates user event registrations

## 🚀 Performance Features

### Eager Loading
Use the `include` query parameter to load relationships:

```http
GET /api/events?include=user,attendees,attendees.user
```

### Pagination
All list endpoints support pagination:

```http
GET /api/events?page=2&per_page=10
```

### Rate Limiting
API endpoints are protected with rate limiting:
- 60 requests per minute per user/IP
- Applied to protected routes only

## 📁 Project Structure

```
app/
├── Console/Commands/          # Artisan commands
├── Http/
│   ├── Controllers/Api/       # API controllers
│   ├── Resources/             # API resources
│   └── Traits/                # Reusable traits
├── Models/                    # Eloquent models
├── Notifications/             # Email notifications
└── Policies/                  # Authorization policies

database/
├── factories/                 # Model factories
├── migrations/                # Database migrations
└── seeders/                   # Database seeders
```

## 🔧 Configuration

### Mail Configuration
Configure your mail settings in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### Queue Configuration
For production, configure a queue driver:

```env
QUEUE_CONNECTION=database
# or
QUEUE_CONNECTION=redis
```

## 📝 API Response Examples

### Event Resource
```json
{
    "id": 1,
    "name": "Laravel Conference 2024",
    "description": "Annual Laravel conference",
    "start_time": "2024-12-01T09:00:00.000000Z",
    "end_time": "2024-12-01T17:00:00.000000Z",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "attendees": [
        {
            "id": 1,
            "user": {
                "id": 2,
                "name": "Jane Smith",
                "email": "jane@example.com"
            }
        }
    ]
}
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🎓 Learning Journey & Skills Developed

### 📈 **Progression Timeline**
This project represents a comprehensive learning journey through Laravel 11's ecosystem:

1. **Foundation Phase**: Understanding Laravel's MVC architecture and routing
2. **Database Mastery**: Learning Eloquent ORM, migrations, and relationships
3. **Security Implementation**: Implementing authentication and authorization
4. **API Development**: Building RESTful APIs with proper resource formatting
5. **Advanced Features**: Task scheduling, queuing, and performance optimization
6. **Production Readiness**: Error handling, validation, and security best practices

### 🛠️ **Technical Skills Acquired**
- **Laravel 11**: Latest framework features and best practices
- **RESTful API Design**: Proper HTTP methods, status codes, and response formatting
- **Authentication & Authorization**: Token-based auth with role management
- **Database Design**: Normalized schema with proper relationships
- **Performance Optimization**: Eager loading, caching, and query optimization
- **Security**: Input validation, rate limiting, and secure data handling
- **Testing**: Factory-based test data generation and comprehensive seeding
- **DevOps**: Task scheduling, background jobs, and production deployment

## 👨‍💻 Author

**Ahmed Aladdin**  
*Laravel Developer & Learning Enthusiast*

This project was created as part of a comprehensive learning journey to master Laravel 11 and modern PHP development practices. The goal was to build a production-ready application while understanding the framework's advanced features and best practices.

### 🎯 **Learning Goals Achieved**
- ✅ Mastered Laravel 11's advanced features
- ✅ Implemented secure authentication and authorization
- ✅ Built scalable RESTful APIs
- ✅ Optimized database performance and queries
- ✅ Applied modern PHP development practices
- ✅ Understood production deployment considerations

### 📚 **What This Project Teaches**
- **Laravel Fundamentals**: MVC architecture, routing, and middleware
- **Database Management**: Eloquent ORM, migrations, and relationships
- **API Development**: RESTful design, resources, and response formatting
- **Security**: Authentication, authorization, and input validation
- **Performance**: Query optimization, eager loading, and caching
- **Production Practices**: Error handling, logging, and monitoring

---

**🎓 Educational Value**: This project serves as a comprehensive example of modern Laravel development, demonstrating real-world application of framework features, security best practices, and performance optimization techniques. Perfect for developers looking to understand Laravel's ecosystem through hands-on learning.