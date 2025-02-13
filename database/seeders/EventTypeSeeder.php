<?php

namespace Database\Seeders;

use App\Models\EventRule;
use App\Models\EventType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = database_path('/seeders/EventTypes/event_types.json');

        // Проверка существования файла
        if (File::exists($jsonFile)) {
            // Чтение и декодирование JSON
            $jsonData = File::get($jsonFile);
            $eventTypes = json_decode($jsonData, true);

            // Вставка данных в таблицу event_types
            foreach ($eventTypes as $eventType) {
                DB::transaction(function () use ($eventType) {
                    $_eventType = EventType::query()->firstOrCreate(['id' => $eventType['id']], [
                        'name' => $eventType['name'],
                        'slug' => $eventType['slug'],
                        'description' => $eventType['description'],
                        'icon' => $eventType['icon'],
                    ]);
                    foreach ($eventType['store_rules'] ?? [] as $rule) {
                        Log::debug($rule);
                        $eventRule = EventRule::query()->firstOrCreate([
                            'name' => $rule['name'],
                            'rule_method' => 'store',
                        ], [
                            "name" => $rule['name'],
                            "title" => $rule['title'],
                            "number" => $rule['number'],
                            "event_type_id" => $_eventType['id'],
                            "rules" => $rule['rules'],
                            "rule_method" => 'store',
                        ]);
                    }
                    foreach ($eventType['update_rules'] ?? [] as $rule) {
                        $eventRule = EventRule::query()->firstOrCreate([
                            'name' => $rule['name'],
                            'rule_method' => 'update',
                        ], [
                            "name" => $rule['name'],
                            "title" => $rule['title'],
                            "number" => $rule['number'],
                            "event_type_id" => $_eventType['id'],
                            "rules" => $rule['rules'],
                            "rule_method" => 'update',
                        ]);
                    }
                });
            }
        } else {
            $this->command->error("Файл event_types.json не найден.");
        }
    }
}
