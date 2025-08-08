<?php

namespace App;

use Pkg6\Console\Cli\App;
use Pkg6\Console\Cli\Scheduling\Schedule;

class ConsoleCliApp extends App
{
    /**
     * 定义任务计划
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command("schedule:list")->everyMinute();
//        $schedule->exec("sleep 5")->everyMinute();
//        $schedule->call(function(){
//            file_put_contents("console-scheduling.log",time().PHP_EOL,FILE_APPEND);
//        })->everyMinute();
    }
}