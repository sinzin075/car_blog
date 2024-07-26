<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MakersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makers = [
            ['country_id' => 1, 'name' => 'トヨタ'],
            ['country_id' => 1, 'name' => '日産'],
            ['country_id' => 1, 'name' => 'ホンダ'],
            ['country_id' => 1, 'name' => 'マツダ'],
            ['country_id' => 1, 'name' => 'スバル'],
            ['country_id' => 1, 'name' => '三菱'],
            ['country_id' => 1, 'name' => 'スズキ'],
            ['country_id' => 1, 'name' => 'ダイハツ'],
            ['country_id' => 1, 'name' => 'いすゞ'],
            ['country_id' => 1, 'name' => '日野'],
            ['country_id' => 1, 'name' => 'レクサス'],
            // アメリカのメーカー
            ['country_id' => 2, 'name' => 'フォード'],
            ['country_id' => 2, 'name' => 'テスラ'],
            ['country_id' => 2, 'name' => 'ゼネラルモーターズ (GM)'],
            // フランスのメーカー
            ['country_id' => 3, 'name' => 'ルノー'],
            ['country_id' => 3, 'name' => 'プジョー'],
            ['country_id' => 3, 'name' => 'シトロエン'],
            // イタリアのメーカー
            ['country_id' => 4, 'name' => 'フィアット'],
            ['country_id' => 4, 'name' => 'フェラーリ'],
            ['country_id' => 4, 'name' => 'ランボルギーニ'],
            ['country_id' => 4, 'name' => 'アバルト'],
            // ドイツのメーカー
            ['country_id' => 5, 'name' => 'フォルクスワーゲン'],
            ['country_id' => 5, 'name' => 'BMW'],
            ['country_id' => 5, 'name' => 'メルセデス・ベンツ'],
            // 中国のメーカー
            ['country_id' => 6, 'name' => '上汽集団'],
            ['country_id' => 6, 'name' => '比亜迪 (BYD)'],
            ['country_id' => 6, 'name' => '吉利汽車'],
            // 韓国のメーカー
            ['country_id' => 7, 'name' => 'ヒュンダイ'],
            ['country_id' => 7, 'name' => '起亜'],
            ['country_id' => 7, 'name' => 'サンヨン'],
        ];
        // 一括でデータベースに挿入
        DB::table('makers')->insert($makers);
    }
}
