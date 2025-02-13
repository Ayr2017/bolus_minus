<?php

namespace App\Console\Commands\Scaffold;

use AllowDynamicProperties;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

#[AllowDynamicProperties] class MakeScaffold extends Command
{
    protected $name;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:scaffold {name} {--namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new scaffold classes';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->nameSpace = $this->option('namespace');
        $this->name = $this->argument('name');

        $migrationResult = $this->makeMigration();
        $modelResult = $this->makeModel();
        $modelResult = $this->makeFactory();
        $seederResult = $this->makeSeeder();
        $requestResult = $this->makeRequests();
        $resourceResult = $this->makeResource();
        $resourceResult = $this->makeService();
        $controllerResult = $this->makeControllerFromStub();
        $routeResult = $this->makeRouteResource();
    }

    /**
     * @return bool
     */
    private  function makeMigration(): bool
    {
        $tableName = Str::lower(Str::snake(Str::plural($this->name)));

        $migrationExists = collect(File::files(database_path('migrations')))
            ->contains(function ($file) use ($tableName) {
                return str_contains($file->getFilename(), $tableName);
            });

        if ($migrationExists) {
            $this->warn("Migration for table '{$tableName}' already exists.");
            return true;
        }

        $exitCode = Artisan::call('make:migration', [
            'name' => "create_{$tableName}_table", // Название миграции
        ]);

        $output = Artisan::output();

        if ($exitCode === 0) {
            $this->info("Migration created successfully:\n" . $output);
            return true;
        } else {
            $this->error("Failed to create migration. Output:\n" . $output);
            return false;
        }
    }

    private function makeModel(): bool
    {
        $modelName = Str::studly(Str::singular($this->name)); // Генерируем имя модели (e.g., "Cow" для "cows")

        $this->info("Creating model: {$modelName}");

        // Выполняем Artisan команду make:model
        $exitCode = Artisan::call('make:model', [
            'name' => $modelName,
        ]);

        $output = Artisan::output(); // Получаем вывод Artisan

        if ($exitCode === 0) {
            $this->info("Model '{$modelName}' created successfully:\n" . $output);
            return true;
        } else {
            $this->error("Failed to create model '{$modelName}'. Output:\n" . $output);
            return false;
        }
    }

    private function makeSeeder(): bool
    {
        $seederName = Str::studly(Str::singular($this->name)) . 'Seeder'; // Имя сидера, например "CowSeeder"

        $this->info("Creating seeder: {$seederName}");

        // Выполняем Artisan команду make:seeder
        $exitCode = Artisan::call('make:seeder', [
            'name' => $seederName,
        ]);

        $output = Artisan::output(); // Получаем вывод Artisan

        if ($exitCode === 0) {
            $this->info("Seeder '{$seederName}' created successfully:\n" . $output);
            return true;
        } else {
            $this->error("Failed to create seeder '{$seederName}'. Output:\n" . $output);
            return false;
        }
    }

    private function makeRequests(): bool
    {
        $entityName = Str::studly(Str::singular($this->name)); // Имя сущности, например "Cow"
        $requests = ['Index', 'Show', 'Store', 'Update', 'Delete']; // Список запросов

        $this->info("Creating requests for entity: {$entityName}");

        foreach ($requests as $request) {
            $requestName = "{$entityName}/{$request}{$entityName}Request";

            $exitCode = Artisan::call('make:request', [
                'name' => $requestName,
            ]);

            $output = Artisan::output(); // Получаем вывод Artisan

            if ($exitCode !== 0) {
                $this->error("Failed to create request '{$requestName}'. Output:\n" . $output);
                return false;
            }

            $this->info("Request '{$requestName}' created successfully.");
        }

        return true;
    }

    private function makeResource(): bool
    {
        $entityName = Str::studly(Str::singular($this->name)); // Имя сущности, например "Cow"
        $resourceName = "{$entityName}/{$entityName}Resource"; // Имя ресурса, например "CowResource"

        $this->info("Creating resource: {$resourceName}");

        // Выполняем Artisan команду make:resource
        $exitCode = Artisan::call('make:resource', [
            'name' => $resourceName,
        ]);

        $output = Artisan::output(); // Получаем вывод Artisan

        if ($exitCode === 0) {
            $this->info("Resource '{$resourceName}' created successfully:\n" . $output);
            return true;
        } else {
            $this->error("Failed to create resource '{$resourceName}'. Output:\n" . $output);
            return false;
        }
    }

    private function makeControllerFromStub(): bool
    {
        // Преобразуем имя сущности в единственное число для запросов и ресурсов
        $entityNameSingular = Str::studly($this->name); // Например, "MyCow"
        $entityNamePlural = Str::plural($entityNameSingular); // Например, "MyCows"
        $entityNameSnake = Str::snake($entityNameSingular); // Например, "my_cow"
        $entityNameCamel = Str::camel($entityNameSingular); // Например, "my_cow"

        $controllerName = "{$entityNameSingular}Controller"; // Имя контроллера во единственном числе, например "MyCowController"
        $namespace = "App\\Http\\Controllers\\Api\\V1"; // Пространство имен контроллера
        $controllerPath = app_path("Http/Controllers/Api/V1/{$controllerName}.php");

        $this->info("Creating controller from stub: {$controllerName}");

        // Проверяем, существует ли контроллер
        if (file_exists($controllerPath)) {
            $this->error("Controller '{$controllerName}' already exists.");
            return false;
        }

        // Загрузка шаблона из stub файла
        $stub = file_get_contents(base_path('stubs/api-controller.stub'));

        // Заменяем переменные в шаблоне
        $controllerContent = str_replace(
            ['{{EntityName}}', '{{EntityNamePlural}}', '{{entityName}}', '{{entityNameSnake}}'],
            [$entityNameSingular, $entityNamePlural, $entityNameCamel, $entityNameSnake], // Используем единственное число для запросов и ресурсов
            $stub
        );

        // Создаём контроллер
        file_put_contents($controllerPath, $controllerContent);

        $this->info("Controller '{$controllerName}' created successfully.");
        return true;
    }

    private function makeRouteResource(): bool
    {
        // Преобразование в camelCase для имени сущности
        $entityNameSingular = Str::camel($this->name); // Например, "myCow"
        $entityNamePlural = Str::plural($entityNameSingular); // Например, "myCows"

        // Преобразуем camelCase в kebab-case (с дефисами)
        $entityNamePluralKebab = Str::kebab($entityNamePlural); // Например, "my-cows"

        // Контроллер теперь во множественном числе, с заглавной первой буквой
        $controllerName = Str::studly($entityNameSingular) . 'Controller'; // Имя контроллера во единственном числе, например "MyCowController"

        $routeFile = base_path('routes/api.php'); // Путь к файлу маршрутов

        // Формируем строку маршрута
        $routeString = "\nRoute::apiResource('{$entityNamePluralKebab}', {$controllerName}::class);";

        // Проверяем, есть ли уже такой маршрут в файле
        if (file_exists($routeFile)) {
            $routeContent = file_get_contents($routeFile);

            // Если маршрут уже существует, не добавляем его снова
            if (strpos($routeContent, $routeString) !== false) {
                $this->info("Route for '{$entityNamePluralKebab}' already exists.");
                return false;
            }

            // Добавляем маршрут в конец файла
            file_put_contents($routeFile, $routeString, FILE_APPEND);

            $this->info("Route for '{$entityNamePluralKebab}' created successfully.");
            return true;
        }

        $this->error("Routes file not found.");
        return false;
    }

    /**
     * @return bool
     */
    protected function makeFactory(): bool
    {
        $factoryName = $this->name . 'Factory';
        $factoryPath = base_path('database/factories/' . $factoryName . '/' . $factoryName . '.php');

        // Проверяем, существует ли уже фабрика
        if (file_exists($factoryPath)) {
            $this->warn("Factory $factoryName already exists.");
            return false;
        }

        // Создаем фабрику через команду Artisan
        $this->callSilent('make:factory', [
            'name' => $factoryName,
            '--model' => $this->getQualifiedModelName(),
        ]);

        $this->info("Factory $factoryName created successfully.");
        return true;
    }

    /**
     * @return string
     */
    protected function getQualifiedModelName(): string
    {
        $namespace = $this->nameSpace ?? 'App\\Models';
        return $namespace . '\\' . $this->name;
    }

    /**
     * @return bool
     */
    private function makeService(): bool
    {
        Artisan::call('make:service', ['service_name' => $this->name . "/" . $this->name]);
        return true;
    }
}
