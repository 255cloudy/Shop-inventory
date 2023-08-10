<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

//use Illuminate\Contracts\Console\PromptsForMissingInput;

class CreateSuperuser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:su  { username : username for superuser } { password : password for superuser }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a superuser for the system';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $user = new User();
        $user->name = $this->argument("username");
        $user->password =  Hash::make($this->argument("password"));
        $user->su = true;
        $user->save();
       return Command::SUCCESS;

    }
}
