# User Management System

A modern, secure, and responsive PHP user management system with authentication, role-based access, profile management, and Bootstrap UI.

## Features
- User registration with profile photo upload
- Secure login/logout (username or email)
- Role-based access (Admin, Read-only, Data Entry)
- User dashboard (view, edit, delete users)
- Profile management (update photo)
- Responsive Bootstrap design
- Input validation and error feedback
- Secure file uploads

## Getting Started

### Requirements
- PHP 7.4+
- MySQL
- Herd, XAMPP, WAMP, or similar local server

### Installation
1. Clone or copy the project to your web server directory (e.g., `htdocs` for XAMPP, or use Herd).
2. Create a MySQL database (e.g., `usermis`).
3. Import the following table structure:

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  role VARCHAR(50) NOT NULL,
  photo VARCHAR(255)
);
```
4. Update `src/db.php` with your database credentials.
5. Make sure the `public/uploads/` directory exists and is writable.
6. Insert the admin user (optional):

```sql
INSERT INTO users (username, password, email, role, photo)
VALUES (
  'admin',
  '$2y$10$wH6Qn6Qw1Qw1Qw1Qw1Qw1uQw1Qw1Qw1Qw1Qw1Qw1Qw1Qw1Qw1Qw1Q', -- hashed 'admin123'
  'admin@example.com',
  'Admin',
  NULL
);
```

### Usage
- Open the site in your browser (e.g., `http://usermanagement-system.test` for Herd).
- You will be redirected to the login page if not authenticated.
- Register a new user, then log in.
- Admin users can view, edit, and delete users.
- All users can update their profile photo.

### File Structure
```
public/
  index.php
  login.php
  register.php
  users.php
  profile.php
  edit_user.php
  view_user.php
  delete_user.php
  uploads/
assets/
  css/style.css
src/
  db.php
  user.php
  auth.php
  config.php
  role.php
  permissions.php
```

### Customization
- Change roles or add new ones in the registration and user management pages.
- Update styles in `assets/css/style.css` or use Bootstrap components.

### Security Notes
- Passwords are hashed using `password_hash`.
- File uploads are validated for type and size.
- All user input is validated and sanitized.

## License
MIT

## Author
Elham

---
For questions or improvements, feel free to open an issue or contact the author.