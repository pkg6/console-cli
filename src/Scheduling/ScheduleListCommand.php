<?php


namespace Pkg6\Console\Cli\Scheduling;


use Pkg6\Console\Cli\App;
use Pkg6\Console\Command;

class ScheduleListCommand extends Command
{
    /**
     * @var string
     */
    protected $name = 'schedule:list';
    /**
     * @var string
     */
    protected $description = 'List the scheduled commands';

    /**
     * @return int
     * @throws \Exception
     */
    public function handle()
    {
        $schedule = App::$schedule;
        foreach ($schedule->events as $event) {
            $rows[] = [
                $event->command,
                $event->expression,
                $event->description,
                $event->getNextRunDate()->format('Y-m-d H:i:s P'),

            ];
        }
        $this->table([
            'Command',
            'Interval',
            'Description',
            'NextDue',
        ], $rows ?? []);
        return self::SUCCESS;
    }
}