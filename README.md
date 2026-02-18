# Auto Shop Management System

A modern, full-featured auto shop management system built with PHP and MySQL. Features role-based access control for administrators, staff, and customers.

## Features

### Admin Features
- Dashboard with business analytics
- User management (create, view, delete users)
- Service management (add, edit, delete services)
- Appointment management
- Business reports and revenue tracking

### Staff Features
- Daily appointment schedule
- Customer directory
- Appointment status updates
- Branch operations management

### Customer Features
- Book appointments online
- View appointment history
- Manage profile
- Cancel appointments

## Tech Stack

- **Frontend**: HTML5, CSS3 (Modern gradient design)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Design**: Custom CSS with Inter font, gradient backgrounds

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- phpMyAdmin (optional, for database management)

### Local Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/autoshop-management.git
   cd autoshop-management
   ```

2. **Create database**
   - Import `database.sql` into your MySQL database
   - Or run the SQL commands manually

3. **Configure database connection**
   - Open `config/database.php`
   - Update the database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'autoshop_db');
   ```

4. **Run setup script**
   - Navigate to `http://localhost/autoshop-management/setup.php`
   - This will create default users with proper password hashing

5. **Login**
   - Navigate to `http://localhost/autoshop-management/`
   - Use default credentials:
     - Admin: `admin@autoshop.com` / `admin123`
     - Staff: `staff@autoshop.com` / `admin123`
     - Customer: `customer@autoshop.com` / `admin123`

## Free Hosting Options

### Option 1: InfinityFree (Recommended for PHP)
- **Website**: https://infinityfree.net
- **Features**: Free PHP hosting, MySQL database, no ads
- **Steps**:
  1. Sign up for free account
  2. Create new website
  3. Upload files via FTP or File Manager
  4. Import database via phpMyAdmin
  5. Update `config/database.php` with provided credentials

### Option 2: 000webhost
- **Website**: https://www.000webhost.com
- **Features**: Free PHP & MySQL hosting
- **Limitations**: Some downtime, ads on free plan

### Option 3: Heroku (with ClearDB MySQL)
- **Website**: https://www.heroku.com
- **Features**: Professional hosting, Git deployment
- **Note**: Requires some configuration for PHP apps

## Deployment Steps

### Deploy to InfinityFree

1. **Sign up** at https://infinityfree.net
2. **Create account** and choose subdomain
3. **Upload files**:
   - Use File Manager or FTP client (FileZilla)
   - Upload all files to `htdocs` folder
4. **Create database**:
   - Go to MySQL Databases in control panel
   - Create new database
   - Note the database name, username, and password
5. **Import database**:
   - Open phpMyAdmin
   - Select your database
   - Import `database.sql`
6. **Update config**:
   - Edit `config/database.php` with your database credentials
7. **Run setup**:
   - Visit `https://yoursite.infinityfreeapp.com/setup.php`
8. **Done!** Access your site

## Project Structure

```
autoshop-management/
├── admin/              # Admin panel pages
├── staff/              # Staff panel pages
├── customer/           # Customer portal pages
├── includes/           # Reusable components & functions
├── assets/
│   └── css/           # Stylesheets
├── config/            # Configuration files
├── database.sql       # Database schema
├── index.php          # Login page
└── setup.php          # Initial setup script
```

## Security Notes

- Change default passwords immediately after deployment
- Update `config/database.php` with strong credentials
- Consider adding `.htaccess` for additional security
- Enable HTTPS on production
- Never commit `config/database.php` with real credentials to GitHub

## Default Credentials

**⚠️ Change these immediately after first login!**

- **Admin**: admin@autoshop.com / admin123
- **Staff**: staff@autoshop.com / admin123
- **Customer**: customer@autoshop.com / admin123

## Screenshots

(Add screenshots of your application here)

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is open source and available under the [MIT License](LICENSE).

## Support

For issues and questions, please open an issue on GitHub.

## Author

Your Name - [Your GitHub Profile](https://github.com/YOUR_USERNAME)

## Acknowledgments

- Inter font by Google Fonts
- Modern gradient design inspiration
- PHP community
