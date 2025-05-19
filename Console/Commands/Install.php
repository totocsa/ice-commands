<?php

namespace Totocsa\IceCommands\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Totocsa\IceCommands\Traits\Install as TraitsInstall;
use Totocsa\IceCommands\Traits\ReConfig;

class Install extends Command
{
    use TraitsInstall;
    use ReConfig;

    protected $kitName = 'Ice Starter Kit';
    protected $signature = 'ice:install';
    protected $description = 'Install Ice Starter Kit';
    protected $results = [];

    public function handle()
    {
        $this->info("Installing $this->kitName...");
        $this->line("Laravel version: " . Application::VERSION);

        date_default_timezone_set(env('APP_TIMEZONE'));

        file_put_contents('storage' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'laravel.log', '');
        chmod('storage' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'laravel.log', 0666);

        $successRunInstallCommands = $this->runCommands($this->installCommands);

        if ($successRunInstallCommands) {
            if ($this->reConfig()) {
                $successRunLastCommands = $this->runCommands($this->lastCommands);
                if ($successRunLastCommands) {
                    $this->newLine();
                    $this->info("The installation was successful.");

                    return Command::SUCCESS;
                } else {
                    return $this->unsuccessful();
                }
            } else {
                return $this->unsuccessful();
            }
        } else {
            return $this->unsuccessful();
        }
    }

    protected function runCommands($commands)
    {
        $success = true;
        foreach ($commands as $v) {
            $this->newLine();
            $this->info("{$v['info']}");

            foreach ($v['commands'] as $arrayCommand) {
                if (PHP_OS_FAMILY === 'Windows' && isset($arrayCommand[1]) && $arrayCommand[1] === '|') {
                    array_unshift($arrayCommand, 'echo');
                    $arrayCommand[1] = "'{$arrayCommand[1]}'";
                }

                $stringCommand = implode(' ', $arrayCommand);
                $this->line("<comment>Command:</comment> <info>$stringCommand</info>");

                $exitCode = $this->runProcess($stringCommand);

                $this->results[] = [
                    'command' => $stringCommand,
                    'exitCode' => $exitCode,
                ];

                if ($exitCode !== 0) {
                    $success = false;
                    break;
                }
            }

            if (!$success) {
                break;
            }
        }

        return $success;
    }

    protected function runProcess($command)
    {
        $descriptorspec = [
            1 => ['pipe', 'w'], // STDOUT
            2 => ['pipe', 'w'], // STDERR
        ];

        $process = proc_open($command, $descriptorspec, $pipes);

        if (is_resource($process)) {
            while (!feof($pipes[1])) {
                $line = trim(fgets($pipes[1]));

                if ($line > '') {
                    $this->line($line);
                }

                flush();
            }
            fclose($pipes[1]);

            while (!feof($pipes[2])) {
                $line = trim(fgets($pipes[2]));

                if ($line > '') {
                    $this->line($line);
                }

                flush();
            }
            fclose($pipes[2]);

            return proc_close($process);
        }
    }

    protected function unsuccessful()
    {
        $this->newLine();
        $this->error("The installation was unsuccessful.");
        return Command::FAILURE;
    }
}
