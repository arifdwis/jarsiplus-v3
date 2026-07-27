<?php

namespace Novay\Nue\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nue:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a nue user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userModel = config('nue.database.users_model');
        $roleModel = config('nue.database.roles_model');

        $email = $this->ask('Please enter an email to login');

        $password = Hash::make($this->secret('Please enter a password to login'));

        $name = $this->ask('Please enter a name to display');

        $roles = $roleModel::all();

        /** @var array $selected */
        $selectedOption = $roles->pluck('name')->toArray();

        if (empty($selectedOption)) {
            $selected = $this->choice('Please choose a role for the user', $selectedOption, null, null, true);

            $roles = $roles->filter(function ($role) use ($selected) {
                return in_array($role->name, $selected);
            });
        }

        $user = new $userModel(compact('email', 'password', 'name'));

        $user->save();

        if (isset($roles)) {
            $user->roles()->attach($roles);
        }

        $this->info("🤙 User [$name] created successfully.");
    }
}