<?php

declare(strict_types=1);

namespace App\Interfaces;


interface CommandHandlerInterface
{
    /**
     * Обработка команды
     */
    public function handle(CommandInterface $command): mixed;

    /**
     * Проверка разрешений перед выполнением
     */
    public function authorize(CommandInterface $command): void;
}
