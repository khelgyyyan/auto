# Deploy PHP App from GitHub using Render.com

## Why Render?
- ✅ Deploys directly from GitHub
- ✅ Supports PHP & MySQL
- ✅ Free tier available
- ✅ Automatic deployments on git push
- ✅ Better than GitHub Pages for PHP

## Step-by-Step Deployment

### Step 1: Push to GitHub First

```bash
cd C:\xampp\htdocs\autometric
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/YOUR_USERNAME/autoshop-management.git
git branch -M main
git push -u origin main
```

### Step 2: Sign Up for Render

1. Go to https://render.com
2. Click "Get Started for Free"
3. Sign up with GitHub (easiest option)
4. Authorize Render to access your repositories

### Step 3: Create MySQL Database

1. In Render dashboard, click "New +"
2. Select "PostgreSQL" or use external MySQL
3. **For MySQL**: Use a free external service like:
   - **FreeSQLDatabase.com**
   - **db4free.net**
   - **RemoteMySQL.com**

#### Using db4free.net (Free MySQL):

1. Go to https://www.db4free.net/signup.php
2. Fill in:
   - Database name: `autoshop_db`
   - Username: (your choice)
   - Password: (your choice)
3. Note down credentials
4. Import your database:
   - Go to https://www.db4free.net/phpMyAdmin/
   - Login with your credentials
   - Import `database.sql`

### Step 4: Deploy Web Service on Render

1. In Render dashboard, click "New +"
2. Select "Web Service"
3. Connect your GitHub repository
4. Configure:
   - **Name**: `autoshop-management`
   - **Environment**: `PHP`
   - **Build Command**: `composer install --no-dev`
   - **Start Command**: `php -S 0.0.0.0:$PORT -t .`
   - **Plan**: Free

5. Add Environment Variables:
   - Click "Advanced"
   - Add these variables:
     ```
     DB_HOST = db4free.net
     DB_USER = your_username
     DB_PASS = your_password
     DB_NAME = autoshop_db
     ```

6. Click "Create Web Service"

### Step 5: Update Database Config

Update `config/database.php` to use environment variables:

```php
<?php
// Use environment variables if available (for Render)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'autoshop_db');

function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}
?>
```

### Step 6: Push Changes

```bash
git add .
git commit -m "Add Render configuration"
git push origin main
```

Render will automatically deploy!

### Step 7: Access Your Site

Your site will be live at:
```
https://autoshop-management.onrender.com
```

### Step 8: Run Setup

1. Visit: `https://autoshop-management.onrender.com/setup.php`
2. This creates default users
3. Login at: `https://autoshop-management.onrender.com/`

## Automatic Deployments

Every time you push to GitHub, Render automatically redeploys!

```bash
# Make changes
git add .
git commit -m "Your changes"
git push origin main
# Render deploys automatically!
```

## Troubleshooting

### "Database connection failed"
- Check environment variables in Render dashboard
- Verify database credentials
- Make sure database is accessible from external connections

### "502 Bad Gateway"
- Check build logs in Render dashboard
- Verify PHP version compatibility
- Check start command is correct

### Site is slow
- Free tier has limitations
- Consider upgrading to paid tier
- Or use InfinityFree for better performance

## Free Tier Limitations

- Site may sleep after 15 minutes of inactivity
- Limited bandwidth
- Slower than paid tiers

## Alternative: Railway.app

Railway is another option that deploys from GitHub:

1. Go to https://railway.app
2. Sign up with GitHub
3. Click "New Project"
4. Select "Deploy from GitHub repo"
5. Choose your repository
6. Add MySQL database
7. Configure environment variables
8. Deploy!

Railway URL: `https://autoshop-management.up.railway.app`
