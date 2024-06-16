<?php

namespace App\Console\Commands;

use App\Services\FileService;
use Illuminate\Console\Command;

class StorageCleanupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune and truncate the main storage from "storage/app/public/" directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        FileService::cleanupDisk();
    }
}
