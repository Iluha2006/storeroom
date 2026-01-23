<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\User;


interface CommandInterface
{
    public function getUser(): ?User;
}
