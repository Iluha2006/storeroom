<?php

declare(strict_types=1);

namespace App\Commands;

use App\Models\User;
use App\Interfaces\CommandInterface;


readonly abstract class BaseCommand implements CommandInterface
{
    public function __construct(
        protected ?User $user = null
    )
    {
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
