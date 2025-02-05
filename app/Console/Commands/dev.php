<?php

namespace App\Console\Commands;

use App\Models\Animal;
use App\Models\CategoryActive;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Console\Command;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
        $animal = User::find(13);
        dd($animal->getRoleNames());
    }
}
