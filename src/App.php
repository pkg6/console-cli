<?php

namespace Pkg6\Console\Cli;

use Pkg6\Console\Application;
use Pkg6\Console\Cli\Scheduling\ScheduleAppTrait;
use Pkg6\Console\Cli\Scheduling\ScheduleListCommand;
use Pkg6\Console\Cli\Scheduling\ScheduleRunCommand;
use Pkg6\Console\Cli\Scheduling\ScheduleWorkCommand;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class App
{
    use ScheduleAppTrait;

    /**
     * @var Application
     */
    protected $appaction;
    /**
     * @var array
     */
    protected $commands = [
        /***
         * 计划任务
         */
        InitCommand::class,
        ScheduleListCommand::class,
        ScheduleRunCommand::class,
        ScheduleWorkCommand::class,
    ];

    /**
     * @return void
     */
    protected function commands()
    {
        // $this->addCommand(ScheduleInitCommand::class);
    }

    public function addCommand(string $command)
    {
        $this->commands[] = $command;
    }

    /**
     * @return Application
     */
    public function getAppaction()
    {
        $this->appaction = (new Application('console-cli'))
            ->resolveCommands($this->commands);
        return $this->appaction;
    }

    /**
     * @param       $command
     * @param array $parameters
     * @param       $outputBuffer
     * @return int
     * @throws \Exception
     */
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        $this->bootstrap();
        return $this->getAppaction()->call($command, $parameters, $outputBuffer);
    }

    /**
     * @return void
     */
    protected function bootstrap()
    {
        $this->defineSchedule();
        $this->commands();
    }

    /**
     * @param $input
     * @param $output
     * @return int
     * @throws \Exception
     */
    public function handle($input = null, $output = null)
    {
        $this->bootstrap();
        return $this->getAppaction()->run($input ?: new ArgvInput(), $output ?: new ConsoleOutput());
    }
}