# Deployment Guide

## 1. Environment Setup

Copy the example production environment file:
```bash
cp .env.production.example .env
```
Edit `.env` and set your database credentials, app URL, and other secrets.

## 2. Server Configuration

### Nginx
Copy `deployment/nginx.conf` to `/etc/nginx/sites-available/school-erp` and symlink it.
Update `server_name` and paths as needed.

### Supervisor (Queue Workers)
Copy `deployment/supervisor.conf` to `/etc/supervisor/conf.d/school-erp-worker.conf`.
Update `user` and paths as needed.
Run:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start school-erp-worker:*
```

### Scheduler (Cron)
Add the following to your crontab (`crontab -e`):
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 3. Deployment

Run the deployment script:
```bash
chmod +x deployment/deploy.sh
./deployment/deploy.sh
```

## 4. Backups

Backups are handled by a custom Artisan command.
Add this to your scheduler (already in `Console/Kernel.php` if configured, or run manually):
```bash
php artisan backup:run
```
Backups are stored in `storage/app/backups`.
