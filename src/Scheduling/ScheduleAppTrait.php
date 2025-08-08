<?php

/*
 * This file is part of the pkg6/console-cli
 *
 * (c) pkg6 <https://github.com/pkg6>
 *
 * (L) Licensed <https://opensource.org/license/MIT>
 *
 * (A) zhiqiang <https://www.zhiqiang.wang>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Pkg6\Console\Cli\Scheduling;

trait ScheduleAppTrait
{
    /**
     * @var Schedule
     */
    public static $schedule;

    /**
     * @param Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    }

    abstract public function getApplication();

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
