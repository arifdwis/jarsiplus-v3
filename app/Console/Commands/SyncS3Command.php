<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SyncS3Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 's3:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi seluruh berkas lokal aplikasi ke AWS S3 tanpa menghapus berkas di storage lokal.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Memulai proses sinkronisasi berkas lokal ke AWS S3 (samarinda/jarsiplus)...');

        $baseDir = storage_path('app/public');
        if (!file_exists($baseDir)) {
            $this->error('Direktori storage/app/public tidak ditemukan.');
            return 1;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($baseDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        $count = 0;
        $success = 0;
        $failed = 0;

        foreach ($files as $file) {
            if ($file->isFile()) {
                $count++;
                $fullPath = $file->getRealPath();
                $relativePath = substr($fullPath, strlen($baseDir) + 1);

                if (in_array($file->getFilename(), ['.gitignore', '.DS_Store', 'index.php'])) {
                    continue;
                }

                $s3Key = 'storage/' . str_replace('\\', '/', $relativePath);

                $this->output->write("[$count] Syncing: $relativePath -> S3 ($s3Key)... ");

                try {
                    $res = sync_to_s3($fullPath);
                    if ($res) {
                        $this->info('OK');
                        $success++;
                    } else {
                        $this->warn('FAILED');
                        $failed++;
                    }
                } catch (\Throwable $e) {
                    $this->error('ERROR: ' . $e->getMessage());
                    $failed++;
                }
            }
        }

        $this->info("Sinkronisasi S3 Selesai! Total: $count file, Berhasil: $success, Gagal/Lewati: $failed.");
        return 0;
    }
}
