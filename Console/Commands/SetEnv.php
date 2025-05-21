<?php

namespace Totocsa\IceCommands\Console\Commands;

use Illuminate\Console\Command;

class SetEnv extends Command
{
    protected $signature = 'ice:set-env'
        . ' {--file=*}'
        . ' {--vite_port=5173}';
    protected $description = 'Set variables in .env file';
    protected $files;

    public function handle()
    {
        $this->files = $this->option('file');
        $errors = $this->validateOptions();

        if (count($errors) === 0) {
            $dirArray = explode(DIRECTORY_SEPARATOR, base_path());
            $dir = array_pop($dirArray);

            $replaces = [];
            foreach ($this->files as $v) {
                $file = $this->replaceTilde($v);
                $replaces = array_merge($replaces, require $file);
            }

            $trFromTo = [
                '{{dir}}' => $dir,
                '{{vite_port}}' => preg_match('/^ice[0-9]{1,3}$/', $dir) ?
                    '6' . str_pad(substr($dir, 3), 3, '0', STR_PAD_LEFT) :
                    $this->option('vite_port'),
            ];

            foreach ($replaces as $v) {
                $patterns[] = $v['pattern'];
                $replacements[] = $v['replacement'];
            }

            $content = file_get_contents(base_path('.env'));

            $newContent = strtr(preg_replace($patterns, $replacements, $content), $trFromTo);
            file_put_contents('.env.0', $newContent);
            copy('.env', '.env.' . str_replace('.', '', microtime(true)));
            file_put_contents('.env', $newContent);
        } else {
            foreach ($errors as $field => $items) {
                $this->error("$field error:");
                foreach ($items as $item) {
                    $msg = is_array($item) ? $item['message'] : $item;
                    $this->line("  $msg");
                }
            }
        }
    }

    protected function validateOptions()
    {
        $errors = [];

        foreach ($this->files as $v) {
            $file = $this->replaceTilde($v);
            if (!is_file($file)) {
                $errors['file'][] = "File not found: $file";
            }
        }

        return $errors;
    }

    protected function replaceTilde($text)
    {
        if (substr($text, 0, 2) === '~' . DIRECTORY_SEPARATOR) {
            $homepath = $_SERVER['HOME'] ?? (/*windows compatibility: */$_SERVER['USERPROFILE']);
            return $homepath . substr($text, 1);
        } else {
            return $text;
        }
    }
}
