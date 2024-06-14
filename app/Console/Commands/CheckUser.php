<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:user {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing check to a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $name = $this->ask('What is your name?');

        // $language = $this->choice('Which language do you prefer?', [
        //     'PHP',
        //     'Ruby',
        //     'Python',
        // ]);

        // $this->line('Your name is '.$name.' and you prefer '.$language.'.');

        $user = User::find($this->argument('user'));
        Log::debug($user);
        $this->line("Found user with name: {$user->name}");

        //return Command::SUCCESS;
    }
}
