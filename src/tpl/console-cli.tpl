#!/usr/bin/env php
<?php
require __DIR__ . "/vendor/autoload.php";

define("BASE_PATH", __DIR__);

define("CONSOLE_NAME", "console-cli");

date_default_timezone_set("Asia/Shanghai");

(new \App\ConsoleCliApp)->handle();