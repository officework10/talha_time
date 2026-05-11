<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CleanupNonCalculators extends Command
{
    protected $signature = 'cleanup:non-calculators {--dry-run : Only show what would be removed}';
    protected $description = 'Remove all non-calculator records from database and cleanup public/keys directory';

    public function handle()
    {
        $dryRun = $this->option('dry-run');

        // 1. Database Cleanup
        $nonCalculators = DB::table('calculators')
            ->where('is_calculator', '!=', 'Calculator')
            ->get();

        $this->info("Found " . $nonCalculators->count() . " non-calculator records.");

        foreach ($nonCalculators as $item) {
            if ($dryRun) {
                $this->line("Would delete: " . $item->cal_title . " (Type: " . $item->is_calculator . ")");
            } else {
                DB::table('calculators')->where('cal_id', $item->cal_id)->delete();
            }
        }

        if (!$dryRun) {
            $this->info("Database cleanup completed.");
        }

        // 2. public/keys Cleanup
        $keysDir = public_path('keys');
        if (File::exists($keysDir)) {
            $files = File::files($keysDir);
            $validLinks = DB::table('calculators')->pluck('cal_link')->toArray();
            
            // Files can be named-like-this.txt or lang-named-like-this.txt
            $this->info("Checking " . count($files) . " files in public/keys...");

            foreach ($files as $file) {
                $filename = $file->getFilenameWithoutExtension();
                
                // Check if it matches a valid link directly
                $isValid = in_array($filename, $validLinks);
                
                // If not, check if it's a language-prefixed version (e.g., 'es-link')
                if (!$isValid) {
                    foreach ($validLinks as $link) {
                        if (preg_match('/^[a-z]{2}-' . preg_quote($link, '/') . '$/', $filename)) {
                            $isValid = true;
                            break;
                        }
                    }
                }

                if (!$isValid && $filename !== '.antigravityignore') {
                    if ($dryRun) {
                        $this->line("Would delete orphaned file: " . $file->getFilename());
                    } else {
                        File::delete($file->getPathname());
                    }
                }
            }
        }

        $this->info("Cleanup done.");
    }
}
