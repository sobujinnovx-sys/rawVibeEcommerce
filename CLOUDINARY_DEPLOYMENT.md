# Cloudinary Deployment Guide

This guide explains how to deploy the Raw Vibe ecommerce application to Render.com with persistent file storage using Cloudinary.

## Prerequisites

- Cloudinary account with API credentials (provided)
- Render.com account
- Git configured on your machine

## Step-by-Step Deployment

### 1. Update Local `.env` File

Open your `.env` file and add your Cloudinary credentials:

```env
FILESYSTEM_DISK=cloudinary
CLOUDINARY_URL=cloudinary://312768889131255:ZwM6w9mxGY_QgLnGk-Nsw6MPPdc@djfodjq4g
```

### 2. Install Dependencies

Run the following commands in your local environment:

```bash
composer install
composer update
npm install
npm run build
```

### 3. Test Locally (Optional)

To verify everything works before deploying:

```bash
php artisan serve
# Upload a test product or carousel banner to ensure images work
```

### 4. Commit Changes to Git

```bash
git add .
git commit -m "Set up Cloudinary for persistent file storage"
git push origin main
```

### 5. Update Render.com Environment Variables

Go to your Render.com dashboard for your service:

1. Click **Environment** tab
2. Update these variables:

```
FILESYSTEM_DISK=cloudinary
CLOUDINARY_URL=cloudinary://312768889131255:ZwM6w9mxGY_QgLnGk-Nsw6MPPdc@djfodjq4g
```

3. Click **Save and Deploy**

### 6. Wait for Deployment

Render will automatically rebuild and deploy your application. This may take 2-5 minutes.

## Verification

After deployment:

1. Go to your Render.com app URL: `http://rawvibeecommerce.onrender.com`
2. Log in to admin panel
3. Try uploading a product image or carousel banner
4. Wait 5 minutes and refresh the page
5. The image should still be there ✅

## How It Works

- **Before**: Files were stored on Render's ephemeral filesystem (deleted on restart)
- **Now**: Files are uploaded to Cloudinary's CDN and stored permanently
- **Benefits**:
  - ✅ Files persist across deployments
  - ✅ Automatic CDN distribution (faster loading)
  - ✅ Free tier covers most ecommerce needs
  - ✅ No AWS costs

## Storage Limits

Your Cloudinary free tier includes:
- **25 credits/month** (enough for ~50 high-quality images)
- **Up to 10GB total storage** (very generous for starting stores)
- **Unlimited bandwidth** from CDN

## Troubleshooting

### Images Not Uploading
1. Check that `CLOUDINARY_URL` is correct on Render
2. Verify your API key hasn't expired
3. Check Render logs: `Admin` → `Logs`

### Old Images Still Missing
- These were stored locally on Render. Unfortunately, they cannot be recovered.
- Only new uploads will use Cloudinary and persist.

### Reset Cloudinary in Development
If you want to use local storage in development:

```env
# .env (local development)
FILESYSTEM_DISK=local
```

```env
# .env.production (or set on Render.com)
FILESYSTEM_DISK=cloudinary
CLOUDINARY_URL=cloudinary://YOUR_KEY:YOUR_SECRET@YOUR_CLOUD_NAME
```

## Files Changed

This deployment adds/modifies:

- ✅ `composer.json` - Added `cloudinary-labs/cloudinary-laravel`
- ✅ `config/filesystems.php` - Added Cloudinary disk configuration
- ✅ `.env.example` - Added Cloudinary environment variables
- ✅ `app/Services/ImageUploadService.php` - New service for consistent uploads
- ✅ `app/Http/Controllers/Admin/ProductController.php` - Updated to use service
- ✅ `app/Http/Controllers/Admin/CarouselBannerController.php` - Updated to use service

All changes are production-ready and can be safely pushed to GitHub.

## Important Notes

⚠️ **Do NOT commit your actual `.env` file to GitHub!**
- The `.env` file is in `.gitignore` and won't be uploaded
- Credentials are only on Render.com environment variables (secure)

✅ **The `.env.example` is safe to commit** - it doesn't have real credentials

## Support

If you encounter issues:
1. Check Render.com logs for errors
2. Verify Cloudinary URL format is correct
3. Ensure API credentials have not expired
4. Re-deploy from Render dashboard if needed

---

**Your app is now production-ready with persistent file storage! 🚀**
