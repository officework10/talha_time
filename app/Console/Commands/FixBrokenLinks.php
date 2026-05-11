<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixBrokenLinks extends Command
{
    protected $signature = 'fix:broken-links {--dry-run : Only show what would be changed}';
    protected $description = 'Remove literal Blade tags from URL fields in the database';

    public function handle()
    {
        $dryRun = $this->option('dry-run');

        // Check Calculators
        $calculators = DB::table('calculators')
            ->where('cal_link', 'like', '%{{%')
            ->get();

        $this->info("Checking calculators...");
        foreach ($calculators as $calc) {
            $newLink = $this->sanitizeUrl($calc->cal_link);
            if ($newLink !== $calc->cal_link) {
                if ($dryRun) {
                    $this->line("Would update calc ID {$calc->cal_id}: '{$calc->cal_link}' -> '{$newLink}'");
                } else {
                    DB::table('calculators')->where('cal_id', $calc->cal_id)->update(['cal_link' => $newLink]);
                    $this->info("Updated calc ID {$calc->cal_id}");
                }
            }
        }

        // Check Posts
        if (Schema::hasTable('posts')) {
            $posts = DB::table('posts')
                ->where('post_url', 'like', '%{{%')
                ->get();

            $this->info("Checking posts...");
            foreach ($posts as $post) {
                $newUrl = $this->sanitizeUrl($post->post_url);
                if ($newUrl !== $post->post_url) {
                    if ($dryRun) {
                        $this->line("Would update post ID {$post->post_id}: '{$post->post_url}' -> '{$newUrl}'");
                    } else {
                        DB::table('posts')->where('post_id', $post->post_id)->update(['post_url' => $newUrl]);
                        $this->info("Updated post ID {$post->post_id}");
                    }
                }
            }
        }

        $this->info("Done.");
    }

    private function sanitizeUrl($url)
    {
        // Remove literal Blade tags like {{ url('/') }} or {{ route('...') }}
        // This is a naive cleanup for the specific patterns seen
        $url = preg_replace('/\{\{\s*url\(\s*\'\/\'\s*\)\s*\}\}/', '', $url);
        $url = preg_replace('/\{\{\s*route\(\s*\'[^\']+\'\s*\)\s*\}\}/', '', $url);
        
        // Clean up any remaining leading/trailing slashes if they got messed up
        $url = trim($url, '/');
        
        return $url;
    }
}
