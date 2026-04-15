<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;


class CacheFlushedEvent
{
    use Dispatchable;

    public function __construct(
        public array   $tags,
        public ?string $reason = null
    )
    {
    }
}
