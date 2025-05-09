<?php

namespace Totocsa\IceCommands\Console\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class DirPerms extends Command
{
    protected $signature = 'ice:dir-perms
                            {--dir= : The directory to apply permissions to (required)}
                            {--mode=0777 : The permission mode (octal)}';

    protected $description = 'Recursively set directory permissions';

    public function handle()
    {
        $dirOption = $this->option('dir');

        if (!$dirOption) {
            $this->error("Missing required option: --dir");
            return Command::INVALID;
        }

        $dir = base_path($dirOption);
        $mode = octdec($this->option('mode')); // convert "0777" to octal

        if (!is_dir($dir)) {
            $this->error("Directory does not exist: $dir");
            return Command::FAILURE;
        }

        $this->info("Setting permissions on directories in: $dir");
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                if (chmod($file->getPathname(), $mode)) {
                    $this->info("Setting permissions on directories in: " . $file->getPathname());
                } else {
                    $this->warn("Failed to chmod: " . $file->getPathname());
                }
            }
        }

        $this->info("Done.");
        return Command::SUCCESS;
    }
}
