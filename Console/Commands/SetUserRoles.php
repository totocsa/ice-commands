<?php

namespace Totocsa\IceCommands\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class SetUserRoles extends Command
{
    protected $signature = 'ice:set-user-roles'
        . ' {--email= : Email address of user}'
        . ' {--roles= : Roles assigned to the user in a JSON array. Example: --roles=\'["role1","role2"]\'}';

    protected $description = 'Set user roles';

    protected $email;
    protected $roles;

    public function handle()
    {
        $this->getOptions();
        $validator = $this->validate();

        if ($validator->passes()) {
            $user = User::where('email', $this->email)->first();

            foreach ($this->roles as $v) {
                try {
                    $user->assignRole($v);
                } catch (\Throwable $th) {
                    $this->error($th->getMessage());
                }
            }

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

    protected function getOptions()
    {
        $this->email = $this->option('email');
        $this->roles = json_decode($this->option('roles'));
    }


    protected function validate()
    {
        $a = $this->option('roles');
        $attributes = [
            'email' => $this->email,
            'roles' => $this->roles,
        ];

        $rules = [
            'email' => 'required|exists:users,email',
            'roles' => 'required|array',
        ];

        $validator = Validator::make($attributes, $rules);

        return $validator;
    }
}
