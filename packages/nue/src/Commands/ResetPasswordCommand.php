<?php

namespace Novay\Nue\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nue:reset-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for a specific nue user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userModel = config('nue.database.users_model');

        askForUserName:
        $email = $this->ask('Please enter an email who needs to reset his password');

        $user = $userModel::query()->where('email', $email)->first();

        if (is_null($user)) {
            $this->error('The user you entered is not exists');
            goto askForUserName;
        }

        enterPassword:
        $password = $this->secret('Please enter a password');

        if ($password !== $this->secret('Please confirm the password')) {
            $this->error('The passwords entered twice do not match, please re-enter');
            goto enterPassword;
        }

        $user->password = Hash::make($password);

        $user->save();

        $this->info('🤙 User ['.$user->name.'] password reset successfully.');
    }
}