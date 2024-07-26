<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            ['name' => '日本'],
            ['name' => 'アメリカ'],
            ['name' => 'フランス'],
            ['name' => 'イタリア'],
            ['name' => 'ドイツ'],
            ['name' => '中国'],
            ['name' => '韓国'],
            // 他の名前データを追加...
        ];

        // 一括でデータベースに挿入
        DB::table('countrys')->insert($names);
    }
}
