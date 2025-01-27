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
        $data = [
            'number' => '111',
            'number_rf' => '',
            'number_rshn' => '',
            'number_tavro' => ''
        ];

        $animal = QueryBuilder::for(Animal::class)
            ->allowedFilters([
                AllowedFilter::exact('number'),
                AllowedFilter::exact('number_rf'),
                AllowedFilter::exact('number_rshn'),
                AllowedFilter::exact('number_tavro'),
            ])
            ->when($data['number'], function($query) use ($data) {
                return $query->where('number', $data['number']);
            })
            ->when($data['number_rf'], function($query) use ($data) {
                return $query->where('number_rf', $data['number_rf']);
            })
            ->when($data['number_rshn'], function($query) use ($data) {
                return $query->where('number_rshn', $data['number_rshn']);
            })
            ->when($data['number_tavro'], function($query) use ($data) {
                return $query->where('number_tavro', $data['number_tavro']);
            })
            ->get();

        dd($animal);
    }
}
