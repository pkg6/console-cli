<?php

namespace Pkg6\Console\Cli\Scheduling;


trait ScheduleAppTrait
{
    /**
     * @var Schedule
     */
    public static $schedule;

    /**
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    }

    abstract public function getAppaction();

    /**
     * @return $this
     */
    public function defineSchedule()
    {
        $schedule = new Schedule();
        $this->schedule($schedule);
        static::$schedule = $schedule;
        return $this;
    }
}