<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreedsSeeder extends Seeder
{
    private array $breeds = [
        ["id" => 1, "name" => "Абердин-ангусская", "type" => "мясная"],
        ["id" => 2, "name" => "Айрширская", "type" => "молочная"],
        ["id" => 3, "name" => "Айрширская финская", "type" => "молочная"],
        ["id" => 4, "name" => "Алатауская", "type" => "мясо-молочная"],
        ["id" => 5, "name" => "Альгау", "type" => "молочная"],
        ["id" => 6, "name" => "Англерская", "type" => "мясо-молочная"],
        ["id" => 7, "name" => "Аулиекольская", "type" => "молочная"],
        ["id" => 8, "name" => "Барыбинский тип", "type" => "молочная"],
        ["id" => 9, "name" => "Белая аквитанская", "type" => "мясная"],
        ["id" => 10, "name" => "Белоголовая украинская", "type" => "молочная"],
        ["id" => 11, "name" => "Бестужевская", "type" => "молочная"],
        ["id" => 12, "name" => "Бланк-блю бельгийская", "type" => "мясная"],
        ["id" => 13, "name" => "Богородский тип", "type" => "молочная"],
        ["id" => 14, "name" => "Бородинский тип", "type" => "молочная"],
        ["id" => 15, "name" => "Браманская", "type" => "мясная"],
        ["id" => 16, "name" => "Британо-фризская", "type" => "молочная"],
        ["id" => 17, "name" => "Бурая карпатская", "type" => "молочная"],
        ["id" => 18, "name" => "Бурая латвийская", "type" => "молочная"],
        ["id" => 19, "name" => "Бурая швицкая", "type" => "молочная"],
        ["id" => 20, "name" => "Бурая швицкая американская", "type" => "молочная"],
        ["id" => 21, "name" => "Бушуевская", "type" => "молочная"],
        ["id" => 22, "name" => "Вазузский тип", "type" => "молочная"],
        ["id" => 23, "name" => "Вологодский тип", "type" => "молочная"],
        ["id" => 24, "name" => "Воронежский тип", "type" => "молочная"],
        ["id" => 25, "name" => "Восточно-финская", "type" => "молочная"],
        ["id" => 26, "name" => "Вятский тип", "type" => "молочная"],
        ["id" => 27, "name" => "Галловейская", "type" => "мясная"],
        ["id" => 28, "name" => "Герефордская", "type" => "мясная"],
        ["id" => 29, "name" => "Горный скот Дагестана", "type" => "мясо-молочная"],
        ["id" => 30, "name" => "Джерсейская", "type" => "молочная"],
        ["id" => 31, "name" => "Джерсейская датская", "type" => "молочная"],
        ["id" => 32, "name" => "Енисейский тип", "type" => "молочная"],
        ["id" => 33, "name" => "Заря (тип)", "type" => "молочная"],
        ["id" => 34, "name" => "Зебу", "type" => "мясная"],
        ["id" => 35, "name" => "Ирменский тип", "type" => "молочная"],
        ["id" => 36, "name" => "Истобенская", "type" => "молочная"],
        ["id" => 37, "name" => "Кавказская бурая", "type" => "молочная"],
        ["id" => 38, "name" => "Кавказский тип", "type" => "молочная"],
        ["id" => 39, "name" => "Казахская белоголовая", "type" => "молочная"],
        ["id" => 40, "name" => "Калмыцкая", "type" => "мясная"],
        ["id" => 41, "name" => "Караваевский тип", "type" => "молочная"],
        ["id" => 42, "name" => "Кианская", "type" => "молочная"],
        ["id" => 43, "name" => "Костромская", "type" => "молочная"],
        ["id" => 44, "name" => "Красно-пестрая голштинская", "type" => "молочная"],
        ["id" => 45, "name" => "Красно-пестрая немецкая", "type" => "молочная"],
        ["id" => 46, "name" => "Красная белорусская скотина", "type" => "молочная"],
        ["id" => 47, "name" => "Красная горбатовская", "type" => "молочная"],
        ["id" => 48, "name" => "Красная датская", "type" => "молочная"],
        ["id" => 49, "name" => "Красная литовская", "type" => "молочная"],
        ["id" => 50, "name" => "Красная польская", "type" => "молочная"],
        ["id" => 51, "name" => "Красная степная", "type" => "молочная"],
        ["id" => 52, "name" => "Красная тамбовская", "type" => "молочная"],
        ["id" => 53, "name" => "Красная эстонская", "type" => "молочная"],
        ["id" => 54, "name" => "Красно-пестрая", "type" => "молочная"],
        ["id" => 55, "name" => "Красноярский тип", "type" => "молочная"],
        ["id" => 56, "name" => "Кубанский тип", "type" => "молочная"],
        ["id" => 57, "name" => "Кулундинский тип", "type" => "молочная"],
        ["id" => 58, "name" => "Курганская", "type" => "молочная"],
        ["id" => 59, "name" => "Курганская (мясная)", "type" => "мясная"],
        ["id" => 60, "name" => "Лебединская", "type" => "молочная"],
        ["id" => 61, "name" => "Ленинградский тип", "type" => "молочная"],
        ["id" => 62, "name" => "Лесновский тип", "type" => "молочная"],
        ["id" => 63, "name" => "Лимузинская", "type" => "мясная"],
        ["id" => 64, "name" => "Мандалог спешилс", "type" => "молочная"],
        ["id" => 65, "name" => "Мен-Анжу", "type" => "молочная"],
        ["id" => 66, "name" => "Михайловский тип", "type" => "молочная"],
        ["id" => 67, "name" => "Монбельярд", "type" => "молочная"],
        ["id" => 68, "name" => "Московский тип", "type" => "молочная"],
        ["id" => 69, "name" => "Непецинский тип", "type" => "молочная"],
        ["id" => 70, "name" => "Новоладожский тип", "type" => "молочная"],
        ["id" => 71, "name" => "Норвинж Ред", "type" => "молочная"],
        ["id" => 72, "name" => "Обрак", "type" => "молочная"],
        ["id" => 73, "name" => "Петровский тип", "type" => "молочная"],
        ["id" => 74, "name" => "Печорский тип", "type" => "молочная"],
        ["id" => 75, "name" => "Пинцгау", "type" => "молочная"],
        ["id" => 76, "name" => "Приобский тип", "type" => "молочная"],
        ["id" => 77, "name" => "Печорский тип", "type" => "молочная"],
        ["id" => 80, "name" => "Русская комолая", "type" => "молочная"],
        ["id" => 81, "name" => "Салер", "type" => "молочная"],
        ["id" => 82, "name" => "Самарский тип", "type" => "молочная"],
        ["id" => 83, "name" => "Санта-Гертруда", "type" => "молочная"],
        ["id" => 84, "name" => "Северная комолая", "type" => "молочная"],
        ["id" => 85, "name" => "Северный тип", "type" => "молочная"],
        ["id" => 86, "name" => "Сибирский тип", "type" => "молочная"],
        ["id" => 87, "name" => "Сибирячка", "type" => "молочная"],
        ["id" => 88, "name" => "Симментальская", "type" => "молочная"],
        ["id" => 89, "name" => "Симментальская (мясная)", "type" => "мясная"],
        ["id" => 90, "name" => "Смена тип", "type" => "молочная"],
        ["id" => 91, "name" => "Смоленский тип", "type" => "молочная"],
        ["id" => 92, "name" => "Сонский тип", "type" => "молочная"],
        ["id" => 93, "name" => "Суксунский скот", "type" => "молочная"],
        ["id" => 94, "name" => "Сычевская", "type" => "молочная"],
        ["id" => 95, "name" => "Тагильская", "type" => "молочная"],
        ["id" => 96, "name" => "Татарстанский тип", "type" => "молочная"],
        ["id" => 97, "name" => "Уральский тип", "type" => "молочная"],
        ["id" => 98, "name" => "Холмогорская", "type" => "молочная"],
        ["id" => 99, "name" => "Центральный тип", "type" => "молочная"],
        ["id" => 100, "name" => "Черно-пестрая голландская", "type" => "молочная"],
        ["id" => 101, "name" => "Черно-пестрая датская", "type" => "молочная"],
        ["id" => 102, "name" => "Черно-пестрая литовская", "type" => "молочная"],
        ["id" => 103, "name" => "Черно-пестрая немецкая", "type" => "молочная"],
        ["id" => 104, "name" => "Без породы", "type" => ""],
        ["id" => 105, "name" => "Черно-пестрая голштинская", "type" => "молочная"],
        ["id" => 107, "name" => "Черно-пестрая остфризская", "type" => "молочная"],
        ["id" => 108, "name" => "Черно-пестрая польская", "type" => "молочная"],
        ["id" => 109, "name" => "Черно-пестрая шведская", "type" => "молочная"],
        ["id" => 110, "name" => "Черно-пестрая эстонская", "type" => "молочная"],
        ["id" => 111, "name" => "Черно-пестрая", "type" => "молочная"],
        ["id" => 112, "name" => "Шароле", "type" => "мясная"],
        ["id" => 113, "name" => "Шведиш Ред", "type" => "молочно-мясная"],
        ["id" => 114, "name" => "Шортгорнская (мол.)", "type" => "молочная"],
        ["id" => 115, "name" => "Шортгорнская (мясн.)", "type" => "мясная"],
        ["id" => 116, "name" => "Юринская", "type" => "молочно-мясная"],
        ["id" => 117, "name" => "Яки", "type" => "мясная"],
        ["id" => 118, "name" => "Якутский скот", "type" => "молочно-мясная"],
        ["id" => 119, "name" => "Ярославская", "type" => "молочно-мясная"],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->breeds as $breed) {
            Breed::updateOrCreate([
                'id' => $breed['id'],
            ], $breed);
        }

        if (DB::getDriverName() === 'pgsql') {
            DB::statement("SELECT SETVAL(pg_get_serial_sequence('breeds', 'id'), (SELECT MAX(id) FROM breeds))");
        }
    }
}
