<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use ZipArchive;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database to storage/app/backups';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database backup...');

        $filename = 'backup-'.Carbon::now()->format('Y-m-d-H-i-s').'.sql';
        $backupPath = storage_path('app/backups');

        if (! file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $filePath = $backupPath.'/'.$filename;
        $zipPath = $filePath.'.zip';

        // Database configuration
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');

        // Mysqldump command
        // Note: putting password directly in command can be insecure in shared environments ps listing
        // But for this internal command it's a common trade-off.
        // Better approach is using .my.cnf but that requires file creation.
        // We'll use the command line with password for simplicity in this script.

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s --port=%s %s > %s',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($database),
            escapeshellarg($filePath)
        );

        // Mask password in output
        $displayCommand = str_replace($password, '*****', $command);
        $this->info('Executing: '.$displayCommand);

        $returnVar = null;
        $output = null;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error('Backup failed! Error code: '.$returnVar);

            return 1;
        }

        $this->info('Database dumped successfully.');

        // Zip the file
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
            $zip->addFile($filePath, $filename);
            $zip->close();
            $this->info('Backup zipped successfully: '.$zipPath);

            // Remove the raw sql file
            unlink($filePath);
        } else {
            $this->error('Failed to zip the backup.');

            return 1;
        }

        // Rotate backups: Keep only last 7 days
        $this->cleanupOldBackups($backupPath);

        $this->info('Backup process completed.');

        return 0;
    }

    private function cleanupOldBackups($path)
    {
        $files = glob($path.'/*.zip');
        $now = time();
        $retentionPeriod = 7 * 24 * 60 * 60; // 7 days

        foreach ($files as $file) {
            if (is_file($file)) {
                if ($now - filemtime($file) >= $retentionPeriod) {
                    unlink($file);
                    $this->info('Deleted old backup: '.basename($file));
                }
            }
        }
    }
}
