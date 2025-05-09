<?php

namespace Totocsa\IceCommands\Console\Commands;

use Illuminate\Console\Command;

class SetEnv extends Command
{
    protected $signature = 'ice:set-env'
        . ' {--replace-file=~/.config/laravel/ice/defaults/env.replaces.php}'
        . ' {--vite_port=5173}';
    protected $description = 'Set variables in .env file';
    protected $replaceFile;
    protected $defaults;

    public function handle()
    {
        $this->replaceFile = $this->option('replace-file');
        $errors = $this->validateOptions();

        if (count($errors) === 0) {
            $dirArray = explode(DIRECTORY_SEPARATOR, base_path());
            $dir = array_pop($dirArray);
            $trFromTo = [
                '{{dir}}' => $dir,
                '{{vite_port}}' => preg_match('/^ice[0-9]{1,3}$/', $dir) ?
                    '6' . str_pad(substr($dir, 3), 3, '0', STR_PAD_LEFT) :
                    $this->option('vite_port'),
            ];

            $this->defaults = include $this->replaceFile;

            foreach ($this->defaults as $v) {
                $patterns[] = $v['pattern'];
                $replacements[] = $v['replacement'];
            }

            $content = file_get_contents(base_path('.env'));

            $newContent = str_replace("{{dir}}", $dir, preg_replace($patterns, $replacements, $content));
            $newContent = strtr(preg_replace($patterns, $replacements, $content), $trFromTo);

            copy('.env', '.env.' . str_replace('.', '', microtime(true)));
            file_put_contents('.env', $newContent);
        }
    }

    protected function validateOptions()
    {
        $errors = [];
        if (substr($this->replaceFile, 0, 2) === '~' . DIRECTORY_SEPARATOR) {
            $homepath = $_SERVER['HOME'] ?? (/*windows compatibility: */$_SERVER['USERPROFILE']);
            $this->replaceFile = $homepath . substr($this->replaceFile, 1);
        }

        if (!file_exists($this->replaceFile)) {
            $errors[] = "Defaults file not found: $this->replaceFile";
        }

        return $errors;
    }
}
