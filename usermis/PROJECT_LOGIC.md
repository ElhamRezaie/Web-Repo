# User Management System - Project Logic Overview

## 1. Authentication & Session Management
- **Login:** Users log in with username/email and password. Credentials are checked against the database using secure password hashing (`password_verify`). On success, user info (ID, role, username) is stored in the session.
- **Session:** All pages that require authentication check for `$_SESSION['user_id']`. If not set, users are redirected to the login page.
- **Logout:** Destroys the session and redirects to login.

## 2. User Roles & Permissions
- **Roles:** Each user has a role: `Admin`, `Read-only`, or `Data Entry`.
- **Permissions:**
  - Only `Admin` users can access the registration page and the user management dashboard (`users.php`).
  - Navigation links for "Register" and "Users" are only visible to Admins.
  - Basic users cannot access or see these pages/links.

## 3. Registration & User Management
- **Registration:**
  - Only Admins can register new users.
  - Registration form collects username, email, password, role, and profile photo.
  - Validates input, checks for unique username/email, and securely uploads the photo.
  - Passwords are hashed before storing in the database.
- **User Management (Admin only):**
  - Admins can view all users, edit user details, and delete users.
  - Each user has a profile photo, username, email, and role.

## 4. Profile Management
- **Profile Page:**
  - All users can view and update their own profile and photo.
  - Profile photo uploads are validated for type and size.

## 5. Navigation & UI
- **Bootstrap:** All pages use Bootstrap for a modern, responsive UI.
- **Custom CSS:** Additional styles in `assets/css/style.css`.
- **Navigation Bar:**
  - Shows/hides links based on user role and authentication status.
  - Only Admins see "Register" and "Users" links.

## 6. Security
- **Password Hashing:** All passwords are hashed using `password_hash`.
- **Input Validation:** All user input is validated and sanitized.
- **File Uploads:** Only image files (jpg, jpeg, png, gif) under 2MB are allowed for profile photos.
- **Access Control:** Direct access to restricted pages is blocked for unauthorized users (checked via session and role).

## 7. Database
- **users Table:** Stores user info (id, username, password, email, role, photo).
- **Demo Admin:** A default admin user can be inserted for initial access.

## 8. File Structure (Key Files)
- `public/login.php` - Login form and logic
- `public/register.php` - Registration form (Admin only)
- `public/users.php` - User management dashboard (Admin only)
- `public/profile.php` - User profile page
- `public/view_user.php` - View user details
- `public/edit_user.php` - Edit user details
- `src/user.php` - User class (CRUD operations)
- `src/db.php` - Database connection
- `assets/css/style.css` - Custom styles

## 9. Flow Summary
1. User visits site → redirected to login if not authenticated.
2. After login, navigation and access are based on user role.
3. Admins can manage users; basic users can only view/edit their own profile.
4. All actions are protected by session and role checks.

---
This file explains the core logic and security of the project. For further details, see the code and README.
