<?php

namespace Totocsa\IceCommands\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUser extends Command
{
    protected $signature = 'ice:create-user'
        . ' {--name=}'
        . ' {--email=}'
        . ' {--password=}';

    protected $description = 'Create a user';

    protected $attributes = [
        'name' => 'Ice Admin',
        'email' => 'ice.admin@mail.lan',
        'password' => '',
        'passwordConfirm' => '',
    ];

    public function handle()
    {
        $this->setAttributes();

        $user = new User();

        $rules = $user->rules($this->attributes);
        $rules['passwordConfirm'] = 'required|same:password';
        $validator = Validator::make($this->attributes, $rules);

        if ($validator->passes()) {
            foreach (['name', 'email', 'password'] as $v) {
                $user->setAttribute($v, $this->attributes[$v]);
            }

            $user->save();

            return Command::SUCCESS;
        } else {
            foreach ($validator->messages()->toArray() as $field => $items) {
                $this->error(User::label($field) . ' error:');
                foreach ($items as $item) {
                    $msg = is_array($item) ? $item['message'] : $item;
                    $this->line("  $msg");
                }
            }

            return Command::INVALID;
        }
    }

    protected function setAttributes()
    {
        if (is_null($this->option('name'))) {
            $this->attributes['name'] = text(User::label('name'), '', $this->attributes['name'], true);
        } else {
            $this->attributes['name'] = $this->option('name');
        }

        if (is_null($this->option('email'))) {
            $this->attributes['email'] = text(User::label('email'), '', $this->attributes['email'], true);
        } else {
            $this->attributes['email'] = $this->option('email');
        }

        if (is_null($this->option('password'))) {
            $this->attributes['password'] = password(User::label('password'), '', true);
            $this->attributes['passwordConfirm'] = password(User::label('passwordConfirm'), '', true);
        } else {
            $this->attributes['password'] = $this->option('password');
            $this->attributes['passwordConfirm'] = $this->option('password');
        }
    }
}
