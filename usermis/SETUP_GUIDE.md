# User Management System - Setup Guide

## 🎯 Overview

This is a complete user management system built with PHP, SQLite, and Bootstrap. It provides secure user authentication, role-based access control, and comprehensive user management features.

## ✨ Features

- **User Authentication**: Secure login/logout with password hashing
- **Role-Based Access Control**: Admin, Data Entry, and Read-only roles
- **User Management**: Full CRUD operations for users (Admin only)
- **Profile Management**: Users can update their profiles and photos
- **Security**: Input validation, SQL injection prevention, secure file uploads
- **Modern UI**: Bootstrap-based responsive design
- **Database**: SQLite for easy deployment

## 🚀 Quick Start

### Prerequisites

- PHP 8.4+ with SQLite support
- Apache web server
- Basic understanding of PHP and web development

### Installation

1. **Clone or copy the project** to your web server directory
2. **Install dependencies** (if using a package manager):
   ```bash
   sudo apt update
   sudo apt install php php-sqlite3 sqlite3 apache2
   ```

3. **Initialize the database**:
   ```bash
   cd /path/to/usermis
   php init_db.php
   ```

4. **Configure Apache** (optional - create virtual host):
   ```apache
   <VirtualHost *:80>
       ServerName usermis.local
       DocumentRoot /path/to/usermis/public
       
       <Directory /path/to/usermis/public>
           AllowOverride All
           Require all granted
           DirectoryIndex index.php
       </Directory>
   </VirtualHost>
   ```

5. **Set permissions**:
   ```bash
   chmod 755 public/uploads/
   chmod 644 database/usermis.db
   ```

### Default Users

After running `init_db.php`, you'll have these users:

| Username | Password | Role | Email |
|----------|----------|------|-------|
| admin | admin123 | Admin | admin@example.com |
| user | user123 | Read-only | user@example.com |

## 🔧 Configuration

### Database Configuration

The system uses SQLite by default. Configuration is in `src/config.php`:

```php
define('DB_TYPE', 'sqlite');
define('DB_PATH', __DIR__ . '/../database/usermis.db');
```

### Upload Directory

Profile photos are stored in `public/uploads/`. Make sure this directory is writable:

```bash
chmod 755 public/uploads/
```

## 📋 Usage Guide

### Admin Functions

**Admin users can:**
- Register new users
- View all users
- Edit any user's details
- Delete users
- Manage user roles
- Access all system features

### Regular User Functions

**Regular users can:**
- Login/logout
- View their own profile
- Update their profile information
- Upload/change profile photo
- View dashboard (limited based on role)

### Role Permissions

1. **Admin**: Full system access
2. **Data Entry**: Can modify data but limited administrative access
3. **Read-only**: Can only view their own profile

## 🛡️ Security Features

### Password Security
- Passwords are hashed using `password_hash()` with bcrypt
- Minimum password requirements can be enforced
- Secure password verification

### Input Validation
- All user inputs are validated and sanitized
- SQL injection prevention using prepared statements
- XSS protection through proper output escaping

### File Upload Security
- Only image files allowed for profile photos
- File size restrictions (2MB default)
- File type validation
- Secure file naming

### Session Management
- Secure session handling
- Session timeout
- Role-based access control

## 🗂️ File Structure

```
usermis/
├── public/                 # Web-accessible files
│   ├── index.php          # Main dashboard
│   ├── login.php          # Login page
│   ├── register.php       # User registration
│   ├── users.php          # User management
│   ├── profile.php        # User profile
│   ├── edit_user.php      # Edit user
│   ├── view_user.php      # View user details
│   ├── delete_user.php    # Delete user
│   ├── logout.php         # Logout
│   └── uploads/           # Profile photos
├── src/                   # Backend logic
│   ├── db.php            # Database connection
│   ├── auth.php          # Authentication
│   ├── user.php          # User management
│   ├── config.php        # Configuration
│   ├── role.php          # Role management
│   └── permissions.php   # Permissions
├── assets/               # Static assets
│   ├── css/style.css    # Custom styles
│   └── js/main.js       # JavaScript
├── database/            # Database files
│   └── usermis.db      # SQLite database
└── templates/          # HTML templates
```

## 🔍 Testing

Run the test script to verify everything is working:

```bash
php test_system.php
```

This will check:
- Database connectivity
- User authentication
- File permissions
- Admin user creation
- Password verification

## 🐛 Troubleshooting

### Common Issues

1. **Database connection errors**:
   - Check if SQLite extension is installed: `php -m | grep sqlite`
   - Verify database file permissions
   - Ensure database directory exists and is writable

2. **File upload issues**:
   - Check `public/uploads/` directory permissions
   - Verify PHP upload settings in `php.ini`
   - Check file size limits

3. **Login problems**:
   - Verify user exists in database
   - Check password hash in database
   - Ensure session support is enabled

4. **Permission denied errors**:
   - Check file/directory permissions
   - Verify web server user has access
   - Check SELinux/AppArmor if applicable

### Debug Mode

To enable debug mode, add this to the top of any PHP file:

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 🔄 Customization

### Adding New Roles

1. Update role definitions in `src/role.php`
2. Modify permission checks in `src/permissions.php`
3. Update navigation logic in templates

### Changing Database

To use MySQL instead of SQLite:

1. Update `src/db.php` with MySQL connection
2. Create MySQL database and tables
3. Update configuration in `src/config.php`

### UI Customization

- Modify `assets/css/style.css` for custom styles
- Update Bootstrap version in templates
- Add custom JavaScript in `assets/js/main.js`

## 📞 Support

For issues or questions:
1. Check the troubleshooting section
2. Review error logs
3. Verify configuration settings
4. Test with provided demo script

## 📄 License

This project is released under the MIT License.

---

**Happy coding! 🎉**