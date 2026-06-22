<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MigrateProfilePhotos extends Command
{
    protected $signature   = 'images:migrate-profile-photos {--dry-run : Show what would change without moving files}';
    protected $description = 'Move profile photos from storage/app/public/profile-photos/ to public/uploads/profile-photos/ and update DB paths';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $dest   = public_path('uploads/profile-photos');

        if (!$dryRun && !is_dir($dest)) {
            mkdir($dest, 0775, true);
        }

        $users = User::whereNotNull('profile_photo')
            ->where('profile_photo', 'not like', 'uploads/%')
            ->get();

        if ($users->isEmpty()) {
            $this->info('No rows need migrating.');
            return 0;
        }

        $moved = 0;
        $skipped = 0;

        foreach ($users as $user) {
            $oldPath = $user->profile_photo; // e.g. "profile-photos/foo.jpg"

            // Normalise: strip a leading "profile-photos/" to get the filename
            if (!str_starts_with($oldPath, 'profile-photos/')) {
                $this->warn("  SKIP (unexpected path): [{$user->id}] $oldPath");
                $skipped++;
                continue;
            }

            $filename = substr($oldPath, strlen('profile-photos/'));
            $src      = storage_path('app/public/profile-photos/' . $filename);
            $dst      = $dest . DIRECTORY_SEPARATOR . $filename;
            $newPath  = 'uploads/profile-photos/' . $filename;

            if ($dryRun) {
                $this->line("  [DRY] user {$user->id}: $oldPath → $newPath" . (file_exists($src) ? '' : ' (source missing)'));
                $moved++;
                continue;
            }

            if (file_exists($src)) {
                if (!copy($src, $dst)) {
                    $this->error("  FAILED to copy: $src → $dst");
                    $skipped++;
                    continue;
                }
            } else {
                $this->warn("  Source missing, updating path only: $src");
            }

            $user->profile_photo = $newPath;
            $user->save();
            $this->line("  OK  user {$user->id}: $oldPath → $newPath");
            $moved++;
        }

        $this->newLine();
        $this->info($dryRun
            ? "Dry run complete. Would migrate $moved user(s), skip $skipped."
            : "Done. Migrated $moved user(s), skipped $skipped.");

        return 0;
    }
}
