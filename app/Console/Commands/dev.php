<?php

namespace App\Console\Commands;

use App\Models\CategoryActive;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Console\Command;

class dev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $user =  User::find(1)->assignRole('admin');
        dd($user->getRoleNames);
        $d = Organisation::find(8);
    }
}
