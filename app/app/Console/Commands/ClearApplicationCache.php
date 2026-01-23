<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheManager;


class ClearApplicationCache extends Command
{
    protected $signature = 'app:cache:clear {--tags=* : Specific cache tags to clear}';
    protected $description = 'Clear application cache with optional tags';

    public function __construct(
        private readonly CacheManager $cacheManager
    )
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $tags = $this->option('tags');

        if (!empty($tags)) {
            $this->info('Clearing cache for tags: ' . implode(', ', $tags));
            $this->cacheManager->flushTags($tags);
        } else {
            $this->warn('Clearing ALL application cache');
            $this->cacheManager->flushAll();
        }

        $this->info('Cache cleared successfully!');

        return self::SUCCESS;
    }
}
