<?php

namespace Totocsa\IceCommands\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Totocsa\IceCommands\Mail\TestEmail;

class SendEmail extends Command
{
    protected $signature = 'ice:send-email'
        . ' {--to=}'
        . ' {--subject=Test email}'
        . ' {--html=<h1>This is a test email.</h1>}';

    protected $description = 'Send email.';

    public function handle()
    {
        $validator = $this->validateOptions();
        if ($validator->passes()) {
            try {
                Mail::to($this->option('to'))->send(new TestEmail($this->option('subject'), $this->option('html')));

                $this->info("The email was sent successfully.");
                return Command::SUCCESS;
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
                $this->line("{$th->getFile()}:{$th->getLine()}");

                return Command::FAILURE;
            }
        } else {
            foreach ($validator->messages()->toArray() as $field => $items) {
                $this->error("$field error:");
                foreach ($items as $item) {
                    $msg = is_array($item) ? $item['message'] : $item;
                    $this->line("  $msg");
                }
            }

            return Command::INVALID;
        }
    }

    public function validateOptions()
    {
        $rules = [
            'to' => 'required|email',
            'subject' => 'required|string',
            'html' => 'required|string',
        ];

        $validator = Validator::make($this->options(), $rules);

        return $validator;
    }
}
