<?php

namespace App\Handlers\Commands;

use BackedEnum;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CommandInterface;
use App\Interfaces\CommandHandlerInterface;


abstract class BaseCommandHandler implements CommandHandlerInterface
{
    /**
     * Выполнить команду с логированием и проверкой прав
     * @throws Throwable
     */
    public function handle(CommandInterface $command): mixed
    {
        $this->logCommandStart($command);

        try {
            // Проверка прав доступа
            $this->authorize($command);

            // Выполнение команды
            $result = $this->execute($command);

            $this->logCommandSuccess($command, $result);

            return $result;
        } catch (Throwable $e) {
            $this->logCommandError($command, $e);
            throw $e;
        }
    }

    /**
     * Реальное выполнение команды (переопределяется в наследниках)
     */
    abstract protected function execute(CommandInterface $command): mixed;

    /**
     * Проверка разрешений (переопределяется в наследниках)
     */
    public function authorize(CommandInterface $command): void
    {
        // По умолчанию разрешено
        // Наследники могут переопределить для своей логики
    }

    /**
     * Логирование начала выполнения команды
     */
    protected function logCommandStart(CommandInterface $command): void
    {
        Log::channel('commands')->info('Command started', [
            'command' => class_basename($command),
            'user_id' => $command->getUser()?->id,
            'data' => $this->getCommandData($command),
        ]);
    }

    /**
     * Логирование успешного выполнения
     */
    protected function logCommandSuccess(CommandInterface $command, mixed $result): void
    {
        Log::channel('commands')->info('Command completed', [
            'command' => class_basename($command),
            'user_id' => $command->getUser()?->id,
            'result' => $this->serializeResult($result),
        ]);
    }

    /**
     * Логирование ошибки
     */
    protected function logCommandError(CommandInterface $command, Throwable $exception): void
    {
        Log::channel('commands')->error('Command failed', [
            'command' => class_basename($command),
            'user_id' => $command->getUser()?->id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }

    /**
     * Получить данные команды для логирования
     */
    protected function getCommandData(CommandInterface $command): array
    {
        $reflection = new \ReflectionClass($command);
        $data = [];

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->getName() === 'user') {
                continue; // Пропускаем пользователя
            }

            $value = $property->getValue($command);
            $data[$property->getName()] = $this->serializeValue($value);
        }

        return $data;
    }

    /**
     * Сериализация значения для логирования
     */
    protected function serializeValue(mixed $value): mixed
    {
        if ($value instanceof Model) {
            return ['id' => $value->id, 'type' => get_class($value)];
        }

        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if (is_object($value) && method_exists($value, 'toArray')) {
            return $value->toArray();
        }

        return $value;
    }

    /**
     * Сериализация результата для логирования
     */
    protected function serializeResult(mixed $result): mixed
    {
        if ($result instanceof Model) {
            return ['id' => $result->id, 'type' => get_class($result)];
        }

        if (is_bool($result)) {
            return $result;
        }

        if (is_scalar($result)) {
            return $result;
        }

        return 'Result logged';
    }
}
