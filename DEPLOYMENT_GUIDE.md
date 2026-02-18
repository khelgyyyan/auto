# Deployment Guide - Auto Shop Management System

## Step-by-Step Guide to Deploy on GitHub and Host for Free

### Part 1: Push to GitHub

#### Step 1: Initialize Git Repository

Open your terminal/command prompt in your project folder and run:

```bash
# Initialize git repository
git init

# Add all files to staging
git add .

# Commit files
git commit -m "Initial commit: Auto Shop Management System"
```

#### Step 2: Create GitHub Repository

1. Go to https://github.com
2. Click the "+" icon in top right
3. Select "New repository"
4. Name it: `autoshop-management` (or your preferred name)
5. Keep it **Public** (for free hosting)
6. Don't initialize with README (we already have one)
7. Click "Create repository"

#### Step 3: Connect and Push to GitHub

Copy the commands from GitHub (they'll look like this):

```bash
# Add GitHub as remote origin
git remote add origin https://github.com/YOUR_USERNAME/autoshop-management.git

# Rename branch to main (if needed)
git branch -M main

# Push to GitHub
git push -u origin main
```

**Replace `YOUR_USERNAME` with your actual GitHub username!**

### Part 2: Free Hosting Options

## Option A: InfinityFree (Easiest for PHP)

### Why InfinityFree?
- ✅ Free PHP & MySQL hosting
- ✅ No ads
- ✅ phpMyAdmin included
- ✅ FTP access
- ✅ Good uptime

### Steps:

#### 1. Sign Up
- Go to https://infinityfree.net
- Click "Sign Up"
- Create account with email

#### 2. Create Website
- Click "Create Account"
- Choose subdomain (e.g., `yourshop.infinityfreeapp.com`)
- Or use custom domain if you have one
- Click "Create Account"

#### 3. Upload Files

**Method A: File Manager (Easier)**
1. Login to control panel
2. Click "File Manager"
3. Navigate to `htdocs` folder
4. Delete default files
5. Click "Upload"
6. Upload all your project files
7. Extract if uploaded as ZIP

**Method B: FTP (Faster for many files)**
1. Download FileZilla: https://filezilla-project.org
2. Get FTP credentials from InfinityFree control panel
3. Connect via FTP
4. Upload all files to `htdocs` folder

#### 4. Create Database
1. In control panel, go to "MySQL Databases"
2. Click "Create Database"
3. Note down:
   - Database name (e.g., `epiz_12345678_autoshop`)
   - Username (e.g., `epiz_12345678`)
   - Password
   - Hostname (usually `sql123.infinityfree.com`)

#### 5. Import Database
1. Click "phpMyAdmin" in control panel
2. Select your database from left sidebar
3. Click "Import" tab
4. Choose `database.sql` file
5. Click "Go"
6. Wait for success message

#### 6. Update Configuration
1. Open File Manager
2. Navigate to `htdocs/config/database.php`
3. Click "Edit"
4. Update with your database credentials:
```php
define('DB_HOST', 'sql123.infinityfree.com'); // Your hostname
define('DB_USER', 'epiz_12345678');           // Your username
define('DB_PASS', 'your_password');           // Your password
define('DB_NAME', 'epiz_12345678_autoshop');  // Your database name
```
5. Save file

#### 7. Run Setup
1. Visit: `https://yourshop.infinityfreeapp.com/setup.php`
2. This creates users with proper passwords
3. You should see success messages

#### 8. Login & Test
1. Visit: `https://yourshop.infinityfreeapp.com/`
2. Login with:
   - Email: `admin@autoshop.com`
   - Password: `admin123`
3. **Change password immediately!**

---

## Option B: 000webhost

### Steps:

1. **Sign Up**: https://www.000webhost.com
2. **Create Website**: Choose free plan
3. **Upload Files**: Use File Manager or FTP
4. **Create Database**: In control panel
5. **Import SQL**: Via phpMyAdmin
6. **Update Config**: Edit `config/database.php`
7. **Run Setup**: Visit `/setup.php`

---

## Option C: Heroku (More Advanced)

### Prerequisites:
- Heroku account
- Heroku CLI installed
- Git installed

### Steps:

1. **Install Heroku CLI**
   ```bash
   # Download from: https://devcenter.heroku.com/articles/heroku-cli
   ```

2. **Login to Heroku**
   ```bash
   heroku login
   ```

3. **Create Heroku App**
   ```bash
   heroku create your-autoshop-app
   ```

4. **Add ClearDB MySQL**
   ```bash
   heroku addons:create cleardb:ignite
   ```

5. **Get Database Credentials**
   ```bash
   heroku config:get CLEARDB_DATABASE_URL
   ```

6. **Update Config for Heroku**
   Create `config/database_heroku.php`:
   ```php
   <?php
   $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
   define('DB_HOST', $url["host"]);
   define('DB_USER', $url["user"]);
   define('DB_PASS', $url["pass"]);
   define('DB_NAME', substr($url["path"], 1));
   ```

7. **Deploy**
   ```bash
   git push heroku main
   ```

---

## Post-Deployment Checklist

### Security
- [ ] Change all default passwords
- [ ] Update database credentials
- [ ] Delete or secure `setup.php` after first run
- [ ] Enable HTTPS if available
- [ ] Test all user roles

### Testing
- [ ] Test admin login
- [ ] Test staff login
- [ ] Test customer login
- [ ] Create test appointment
- [ ] Test all CRUD operations
- [ ] Check mobile responsiveness

### Maintenance
- [ ] Bookmark admin panel URL
- [ ] Save database backup
- [ ] Document custom domain setup (if applicable)
- [ ] Set up regular backups

---

## Troubleshooting

### "Database connection failed"
- Check database credentials in `config/database.php`
- Verify database exists in hosting control panel
- Check if database server is running

### "Page not found" errors
- Ensure files are in correct directory (`htdocs` or `public_html`)
- Check file permissions (should be 644 for files, 755 for folders)
- Verify `.htaccess` if using Apache

### "Headers already sent" error
- Check for whitespace before `<?php` tags
- Ensure no output before `header()` calls
- Check file encoding (should be UTF-8 without BOM)

### Blank white page
- Enable error reporting temporarily
- Check PHP error logs in hosting control panel
- Verify PHP version (needs 7.4+)

---

## Custom Domain Setup (Optional)

### If you have a domain:

1. **Update DNS Records**
   - Add A record pointing to hosting IP
   - Or add CNAME pointing to hosting subdomain

2. **Update Hosting**
   - Add domain in hosting control panel
   - Wait for DNS propagation (24-48 hours)

3. **Enable SSL**
   - Most free hosts offer free SSL
   - Enable in control panel

---

## Updating Your Live Site

When you make changes:

```bash
# Commit changes
git add .
git commit -m "Description of changes"
git push origin main

# Then re-upload changed files to hosting
# Or use FTP to sync files
```

---

## Need Help?

- **GitHub Issues**: Open issue in your repository
- **InfinityFree Forum**: https://forum.infinityfree.net
- **Stack Overflow**: Tag questions with `php` and `mysql`

---

## Quick Reference

### Your URLs
- **GitHub Repo**: `https://github.com/YOUR_USERNAME/autoshop-management`
- **Live Site**: `https://yourshop.infinityfreeapp.com`
- **Admin Panel**: `https://yourshop.infinityfreeapp.com/admin/dashboard.php`

### Default Logins
- Admin: `admin@autoshop.com` / `admin123`
- Staff: `staff@autoshop.com` / `admin123`
- Customer: `customer@autoshop.com` / `admin123`

**🔒 Change these immediately after deployment!**
