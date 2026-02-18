# Auto Shop Management System - Structure Guide

## Component-Based Architecture

The system now uses a modular component structure with separate header, sidebar, and footer files for each user role.

### Directory Structure

```
includes/
├── auth.php                 # Authentication functions
├── functions.php            # Helper functions
├── admin_header.php         # Admin HTML head and opening tags
├── admin_sidebar.php        # Admin navigation sidebar
├── admin_footer.php         # Admin closing tags and footer
├── staff_header.php         # Staff HTML head and opening tags
├── staff_sidebar.php        # Staff navigation sidebar
├── staff_footer.php         # Staff closing tags and footer
├── customer_header.php      # Customer HTML head and opening tags
├── customer_sidebar.php     # Customer navigation sidebar
└── customer_footer.php      # Customer closing tags and footer
```

### How to Use Components

#### For Admin Pages

```php
<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('admin');

// Set page variables
$pageTitle = 'Page Title';  // Optional: Sets browser tab title
$currentPage = 'dashboard'; // Required: Highlights active menu item

// Your PHP logic here...

// Include header and sidebar
require_once '../includes/admin_header.php';
require_once '../includes/admin_sidebar.php';
?>

<!-- Your HTML content here -->
<h1>Your Page Content</h1>

<?php require_once '../includes/admin_footer.php'; ?>
```

#### For Staff Pages

```php
<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('staff');

$pageTitle = 'Page Title';
$currentPage = 'appointments'; // Options: dashboard, appointments, customers

// Your PHP logic...

require_once '../includes/staff_header.php';
require_once '../includes/staff_sidebar.php';
?>

<!-- Your content -->

<?php require_once '../includes/staff_footer.php'; ?>
```

#### For Customer Pages

```php
<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('customer');

$pageTitle = 'Page Title';
$currentPage = 'dashboard'; // Options: dashboard, book-appointment, my-appointments, profile

// Your PHP logic...

require_once '../includes/customer_header.php';
require_once '../includes/customer_sidebar.php';
?>

<!-- Your content -->

<?php require_once '../includes/customer_footer.php'; ?>
```

### Current Page Values

**Admin:**
- `dashboard`
- `users`
- `services`
- `appointments`
- `reports`

**Staff:**
- `dashboard`
- `appointments`
- `customers`

**Customer:**
- `dashboard`
- `book-appointment`
- `my-appointments`
- `profile`

### Benefits

1. **Maintainability**: Update navigation in one place
2. **Consistency**: All pages use the same structure
3. **Flexibility**: Easy to add new menu items
4. **Clean Code**: Separation of concerns
5. **DRY Principle**: Don't Repeat Yourself

### Footer

The footer automatically displays:
- Copyright year (dynamic)
- Company name
- Consistent styling across all pages
