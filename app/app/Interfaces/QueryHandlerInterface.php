<?php

declare(strict_types=1);

namespace App\Interfaces;


interface QueryHandlerInterface
{

    public function handle(QueryInterface $query): mixed;


    public function handleWithoutCache(QueryInterface $query): mixed;
}
