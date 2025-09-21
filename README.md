# Event Management REST API

A comprehensive Laravel 11 REST API for managing events and attendees, built following modern Laravel best practices and advanced concepts.

## 🚀 Features

### Core Functionality
- **Event Management**: Create, read, update, and delete events
- **Attendee System**: Users can register for events
- **Authentication**: Token-based authentication using Laravel Sanctum
- **Authorization**: Policy-based access control
- **Automated Reminders**: Daily scheduled event reminders via email
- **API Rate Limiting**: Built-in throttling for API protection

### Advanced Features
- **API Resources**: Clean, consistent JSON responses
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

## 👨‍💻 Author

Built as part of a comprehensive Laravel learning journey, implementing advanced concepts including:

- RESTful API design
- Authentication & Authorization
- Database relationships
- API Resources
- Task scheduling
- Email notifications
- Performance optimization
- Security best practices

---

**Note**: This project demonstrates proficiency in Laravel 11, modern PHP development, and API design principles.