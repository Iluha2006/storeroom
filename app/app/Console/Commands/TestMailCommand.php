<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email}'; // принимает email как аргумент

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отправить тестовое письмо на указанный email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        Mail::raw('Это тестовое письмо из Laravel!', function ($message) use ($email) {
            $message->to($email)
                    ->subject('[Тест] Проверка SMTP');
        });

        $this->info("✅ Тестовое письмо отправлено на: $email");
    }
}