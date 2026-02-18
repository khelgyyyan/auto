# FTP Upload Guide - InfinityFree

## Why Use FTP?
- Faster for multiple files
- More reliable than web upload
- Can see exact folder structure

## Step-by-Step FTP Upload

### 1. Get FTP Credentials

1. Login to InfinityFree control panel
2. Look for "FTP Details" or "FTP Accounts"
3. Note down:
   - **FTP Hostname**: (e.g., `ftpupload.net`)
   - **FTP Username**: (e.g., `epiz_12345678`)
   - **FTP Password**: (your account password)
   - **FTP Port**: `21`

### 2. Download FileZilla

1. Go to: https://filezilla-project.org/download.php
2. Download FileZilla Client (FREE)
3. Install it

### 3. Connect to Your Server

1. Open FileZilla
2. Enter at the top:
   - **Host**: `ftpupload.net` (or your FTP hostname)
   - **Username**: Your FTP username
   - **Password**: Your FTP password
   - **Port**: `21`
3. Click "Quickconnect"

### 4. Navigate to htdocs

**Left side** = Your computer
**Right side** = Your server

On the right side (server):
1. Double-click folders to navigate
2. Find and open `htdocs` folder
3. Delete any default files inside

### 5. Upload Your Files

On the left side (your computer):
1. Navigate to your project folder
2. Select ALL files and folders:
   - admin/
   - customer/
   - staff/
   - includes/
   - assets/
   - config/
   - index.php
   - setup.php
   - etc.
3. Right-click → Upload
4. Wait for upload to complete

### 6. Verify Upload

On the right side (server), you should see:
```
htdocs/
├── index.php
├── setup.php
├── logout.php
├── admin/
├── customer/
├── staff/
├── includes/
├── assets/
└── config/
```

### 7. Test Your Site

Visit: `https://yoursite.infinityfreeapp.com/`

You should see the login page!

## Troubleshooting FTP

### "Connection refused"
- Check FTP hostname is correct
- Try port 21
- Check firewall isn't blocking FTP

### "Login incorrect"
- Verify username (usually starts with `epiz_`)
- Check password
- Try resetting FTP password in control panel

### "Permission denied"
- Make sure you're uploading to `htdocs` folder
- Don't try to upload to root directory

### Upload is very slow
- InfinityFree free tier has speed limits
- Be patient, it may take 10-15 minutes for all files
- Consider uploading as ZIP and extracting on server

## Quick Reference

### FileZilla Interface
```
┌─────────────────────────────────────────┐
│ Host: [ftpupload.net] Port: [21]        │
│ Username: [epiz_xxx] Password: [***]    │
│ [Quickconnect]                          │
├──────────────────┬──────────────────────┤
│ YOUR COMPUTER    │  YOUR SERVER         │
│ (Left Side)      │  (Right Side)        │
│                  │                      │
│ C:\autometric\   │  /htdocs/           │
│ ├── admin/       │  ← Upload here      │
│ ├── customer/    │                      │
│ └── index.php    │                      │
└──────────────────┴──────────────────────┘
```

### Common FTP Commands
- **Upload**: Right-click file → Upload
- **Download**: Right-click file → Download
- **Delete**: Right-click file → Delete
- **Rename**: Right-click file → Rename
- **Create folder**: Right-click → Create directory

## After Upload Checklist

- [ ] All folders uploaded (admin, customer, staff, includes, assets, config)
- [ ] index.php is in htdocs root
- [ ] No files in subfolders like htdocs/autometric/
- [ ] Database imported via phpMyAdmin
- [ ] config/database.php updated with correct credentials
- [ ] Visited setup.php to create users
- [ ] Can login at index.php

## Still Having Issues?

### Check File Permissions
In FileZilla:
1. Right-click on folders
2. File permissions
3. Set to `755` for folders
4. Set to `644` for files

### Clear Browser Cache
- Press `Ctrl + F5` to hard refresh
- Or clear browser cache completely

### Check Error Logs
In InfinityFree control panel:
1. Go to "Error Logs"
2. Check for PHP errors
3. This will tell you exactly what's wrong
