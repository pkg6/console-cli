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

namespace Pkg6\Console\Cli;

use Composer\InstalledVersions;
use Pkg6\Console\Command;
use RuntimeException;

class InitCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'init';

    /**
     * @var string
     */
    protected $description = 'project init';

    /**
     * @return int
     */
    public function handle()
    {
        $pkg = "pkg6/console-cli";
        try {
            $composerFile = getcwd() . DIRECTORY_SEPARATOR . 'composer.json';
            if ( ! file_exists($composerFile)) {
                throw new RuntimeException("Can't find composer.json. Please run this command in the project root directory.");
            }
            if ( ! InstalledVersions::isInstalled($pkg)) {
                throw new RuntimeException("The dependency is not declared. Please run the following command to add the dependency and try again：composer require pkg6/console-cli");
            }
            $composerData = json_decode(file_get_contents($composerFile), true);
            if ( ! empty($composerData['name']) && $composerData['name'] == $pkg) {
                throw new RuntimeException("Initialization is not possible in source code");
            }
            $this->composer($composerFile, $composerData);
            $this->app();
            @exec('composer dump-autoload');
            $this->info('init success');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return self::SUCCESS;
    }

    protected function composer($composerFile, $composerData)
    {
        $w = false;
        if ( ! isset($composerData['autoload']['psr-4']['App\\'])) {
            $composerData['autoload']['psr-4']['App\\'] = "app/";
            $w = true;
        }
        if (isset($composerData['autoload-dev']['psr-4']['App\\'])) {
            $w = false;
        }
        if ($w) {
            file_put_contents($composerFile, json_encode($composerData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }

    protected function app()
    {
        // 定位 vendor 包根目录
        $packageRoot = __DIR__;
        $tmpDir = $packageRoot . DIRECTORY_SEPARATOR . 'tpl';
        // 要复制的文件映射
        $files = [
            $tmpDir . DIRECTORY_SEPARATOR . 'ConsoleCliApp.php.tpl' => getcwd() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'ConsoleCliApp.php',
            $tmpDir . DIRECTORY_SEPARATOR . 'console-cli.tpl' => getcwd() . DIRECTORY_SEPARATOR . 'console-cli',
        ];
        foreach ($files as $src => $dst) {
            if ( ! file_exists($src)) {
                throw new \RuntimeException("The source template file does not exist: {$src}");
            }
            // 自动创建目标目录
            $dir = dirname($dst);
            if ( ! is_dir($dir)) {
                if ( ! mkdir($dir, 0777, true) && ! is_dir($dir)) {
                    throw new \RuntimeException("Unable to create directory: {$dir}");
                }
            }
            if (file_put_contents($dst, file_get_contents($src)) === false) {
                throw new \RuntimeException("Failed to write tpl file: {$dst}");
            }
        }
    }
}
