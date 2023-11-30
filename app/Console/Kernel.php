<?php

namespace App\Console;

use App\Http\Controllers\CargaController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            // app()->call('App\Http\Controllers\CargaController@getcargafechaAutomatico');
            // })->everyFifteenMinutes();

            $name = "ddd";
            $last_name = "ddd";
            $email = Str::slug($name . '_' . $last_name) . '@roes.com';
            $password = bcrypt('password');

            $user = User::create([
                'name' => $name,
                'last_name' => $last_name,
                'subscription_start' => now()->format('Y-m-d'),
                'email' => $email,
                'password' => $password,
            ]);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
