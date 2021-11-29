<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Location;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) //  Прописываем команду
    {
        $schedule->command('message:delete')// Название команды
            ->everyMinute(); // Отрабатывает каждую минуту
            /*->appendOutputTo('scheduler.log')*/ // Сохраняет в определенный файл
            /*->emailOutputTo('printcodestudio@gmail.com');*/ // Отправляется на Email
            /*->timezone('Europe/Minsk')
            ->at('10.31');*/
    }


    public function scheduleTimezone()
    {
       /* return 'Europe/Minsk'*/; //
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
