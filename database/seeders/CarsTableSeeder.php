<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CarsTableSeeder extends Seeder
{
    public function run()
    {
        // テーブルのデータを削除し、自動増分のカウンターをリセット
        Schema::disableForeignKeyConstraints();
        DB::table('cars')->truncate();
        Schema::enableForeignKeyConstraints();

        // 画像ファイルとその対応するcarのname
        $cars = [
            ['name' => 'カローラ', 'file' => public_path('images/カローラ.jpg'), 'maker_id' => 1],
            ['name' => 'プリウス', 'file' => public_path('images/プリウス.jpg'), 'maker_id' => 1],
            ['name' => 'ハイエース', 'file' => public_path('images/ハイエース.jpg'), 'maker_id' => 1],
            ['name' => 'スープラ', 'file' => public_path('images/スープラ.jpg'), 'maker_id' => 1],
            ['name' => '86', 'file' => public_path('images/86.jpg'), 'maker_id' => 1],
            ['name' => 'MR2', 'file' => public_path('images/MR2.jpg'), 'maker_id' => 1],
            ['name' => 'セリカ', 'file' => public_path('images/セリカ.jpg'), 'maker_id' => 1],
            ['name' => 'ソアラ', 'file' => public_path('images/ソアラ.jpg'), 'maker_id' => 1],
            ['name' => 'AE86', 'file' => public_path('images/AE86.jpg'), 'maker_id' => 1],
            ['name' => 'クラウン', 'file' => public_path('images/クラウン.jpg'), 'maker_id' => 1],
            // 日産の車種
            ['name' => 'スカイライン', 'file' => public_path('images/スカイライン.jpg'), 'maker_id' => 2],
            ['name' => 'リーフ', 'file' => public_path('images/リーフ.jpg'), 'maker_id' => 2],
            ['name' => 'ノート', 'file' => public_path('images/ノート.jpg'), 'maker_id' => 2],
            ['name' => 'GT-R', 'file' => public_path('images/GT-R.jpg'), 'maker_id' => 2],
            ['name' => 'フェアレディZ', 'file' => public_path('images/フェアレディZ.jpg'), 'maker_id' => 2],
            ['name' => 'シルビア', 'file' => public_path('images/シルビア.jpg'), 'maker_id' => 2],
            ['name' => '180SX', 'file' => public_path('images/180SX.jpg'), 'maker_id' => 2],
            ['name' => 'ブルーバード', 'file' => public_path('images/ブルーバード.jpg'), 'maker_id' => 2],
            ['name' => 'パルサー', 'file' => public_path('images/パルサー.jpg'), 'maker_id' => 2],
            ['name' => 'ローレル', 'file' => public_path('images/ローレル.jpg'), 'maker_id' => 2],
            // ホンダの車種
            ['name' => 'シビック', 'file' => public_path('images/シビック.jpg'), 'maker_id' => 3],
            ['name' => 'フィット', 'file' => public_path('images/フィット.jpg'), 'maker_id' => 3],
            ['name' => 'アコード', 'file' => public_path('images/アコード.jpg'), 'maker_id' => 3],
            ['name' => 'NSX', 'file' => public_path('images/NSX.jpg'), 'maker_id' => 3],
            ['name' => 'インテグラ', 'file' => public_path('images/インテグラ.jpg'), 'maker_id' => 3],
            ['name' => 'プレリュード', 'file' => public_path('images/プレリュード.jpg'), 'maker_id' => 3],
            ['name' => 'S2000', 'file' => public_path('images/S2000.jpg'), 'maker_id' => 3],
            ['name' => 'CR-X', 'file' => public_path('images/CR-X.jpg'), 'maker_id' => 3],
            ['name' => 'ビート', 'file' => public_path('images/ビート.jpg'), 'maker_id' => 3],
            // マツダの車種
            ['name' => 'アテンザ', 'file' => public_path('images/アテンザ.jpg'), 'maker_id' => 4],
            ['name' => 'デミオ', 'file' => public_path('images/デミオ.jpg'), 'maker_id' => 4],
            ['name' => 'CX-5', 'file' => public_path('images/CX-5.jpg'), 'maker_id' => 4],
            ['name' => 'RX-7', 'file' => public_path('images/RX-7.jpg'), 'maker_id' => 4],
            ['name' => 'ロードスター', 'file' => public_path('images/ロードスター.jpg'), 'maker_id' => 4],
            ['name' => 'RX-8', 'file' => public_path('images/RX-8.jpg'), 'maker_id' => 4],
            ['name' => 'コスモ', 'file' => public_path('images/コスモ.jpg'), 'maker_id' => 4],
            ['name' => 'サバンナ', 'file' => public_path('images/サバンナ.jpg'), 'maker_id' => 4],
            ['name' => 'ファミリア', 'file' => public_path('images/ファミリア.jpg'), 'maker_id' => 4],
            // スバルの車種
            ['name' => 'インプレッサ', 'file' => public_path('images/インプレッサ.jpg'), 'maker_id' => 5],
            ['name' => 'レガシィ', 'file' => public_path('images/レガシィ.jpg'), 'maker_id' => 5],
            ['name' => 'フォレスター', 'file' => public_path('images/フォレスター.jpg'), 'maker_id' => 5],
            ['name' => 'BRZ', 'file' => public_path('images/BRZ.jpg'), 'maker_id' => 5],
            ['name' => 'WRX', 'file' => public_path('images/WRX.jpg'), 'maker_id' => 5],
            ['name' => 'アルシオーネ', 'file' => public_path('images/アルシオーネ.jpg'), 'maker_id' => 5],
            ['name' => 'レオーネ', 'file' => public_path('images/レオーネ.jpg'), 'maker_id' => 5],
            ['name' => 'ヴィヴィオ', 'file' => public_path('images/ヴィヴィオ.jpg'), 'maker_id' => 5],
            // 三菱の車種
            ['name' => 'ランサー', 'file' => public_path('images/ランサー.jpg'), 'maker_id' => 6],
            ['name' => 'アウトランダー', 'file' => public_path('images/アウトランダー.jpg'), 'maker_id' => 6],
            ['name' => 'パジェロ', 'file' => public_path('images/パジェロ.jpg'), 'maker_id' => 6],
            ['name' => 'ランサーエボリューション', 'file' => public_path('images/ランサーエボリューション.jpg'), 'maker_id' => 6],
            ['name' => 'GTO', 'file' => public_path('images/GTO.jpg'), 'maker_id' => 6],
            ['name' => 'FTO', 'file' => public_path('images/FTO.jpg'), 'maker_id' => 6],
            ['name' => 'ギャラン', 'file' => public_path('images/ギャラン.jpg'), 'maker_id' => 6],
            ['name' => 'コルディア', 'file' => public_path('images/コルディア.jpg'), 'maker_id' => 6],
            ['name' => 'スタリオン', 'file' => public_path('images/スタリオン.jpg'), 'maker_id' => 6],
            // スズキの車種
            ['name' => 'アルト', 'file' => public_path('images/アルト.jpg'), 'maker_id' => 7],
            ['name' => 'ワゴンR', 'file' => public_path('images/ワゴンR.jpg'), 'maker_id' => 7],
            ['name' => 'スイフト', 'file' => public_path('images/スイフト.jpg'), 'maker_id' => 7],
            ['name' => 'スイフトスポーツ', 'file' => public_path('images/スイフトスポーツ.jpg'), 'maker_id' => 7],
            ['name' => 'カプチーノ', 'file' => public_path('images/カプチーノ.jpg'), 'maker_id' => 7],
            ['name' => 'エスクード', 'file' => public_path('images/エスクード.jpg'), 'maker_id' => 7],
            ['name' => 'ジムニー', 'file' => public_path('images/ジムニー.jpg'), 'maker_id' => 7],
            ['name' => 'フロンテ', 'file' => public_path('images/フロンテ.jpg'), 'maker_id' => 7],
            // ダイハツの車種
            ['name' => 'ムーヴ', 'file' => public_path('images/ムーヴ.jpg'), 'maker_id' => 8],
            ['name' => 'タント', 'file' => public_path('images/タント.jpg'), 'maker_id' => 8],
            ['name' => 'ハイゼット', 'file' => public_path('images/ハイゼット.jpg'), 'maker_id' => 8],
            ['name' => 'コペン', 'file' => public_path('images/コペン.jpg'), 'maker_id' => 8],
            ['name' => 'シャレード', 'file' => public_path('images/シャレード.jpg'), 'maker_id' => 8],
            ['name' => 'ミラ', 'file' => public_path('images/ミラ.jpg'), 'maker_id' => 8],
            ['name' => 'ストーリア', 'file' => public_path('images/ストーリア.jpg'), 'maker_id' => 8],
            // レクサスの車種
            ['name' => 'LS', 'file' => public_path('images/ls.jpg'), 'maker_id' => 11],
            ['name' => 'RX', 'file' => public_path('images/rx.jpg'), 'maker_id' => 11],
            ['name' => 'NX', 'file' => public_path('images/nx.jpg'), 'maker_id' => 11],
            ['name' => 'LC', 'file' => public_path('images/lc.jpg'), 'maker_id' => 11],
            ['name' => 'IS', 'file' => public_path('images/is.jpg'), 'maker_id' => 11],
            ['name' => 'SC', 'file' => public_path('images/sc.jpg'), 'maker_id' => 11],
            ['name' => 'GS', 'file' => public_path('images/gs.jpg'), 'maker_id' => 11],
            ['name' => 'ES', 'file' => public_path('images/es.jpg'), 'maker_id' => 11],
            // アメリカの車種
            ['name' => 'マスタング', 'file' => public_path('images/マスタング.jpg'), 'maker_id' => 12],
            ['name' => 'F-150', 'file' => public_path('images/F-150.jpg'), 'maker_id' => 12],
            ['name' => 'エクスプローラー', 'file' => public_path('images/エクスプローラー.jpg'), 'maker_id' => 12],
            ['name' => 'モデルS', 'file' => public_path('images/モデルS.jpg'), 'maker_id' => 13],
            ['name' => 'モデル3', 'file' => public_path('images/モデル3.jpg'), 'maker_id' => 13],
            ['name' => 'モデルX', 'file' => public_path('images/モデルX.jpg'), 'maker_id' => 13],
            ['name' => 'シボレー コルベット', 'file' => public_path('images/シボレーコルベット.jpg'), 'maker_id' => 14],
            ['name' => 'キャデラック エスカレード', 'file' => public_path('images/キャデラックエスカレード.jpg'), 'maker_id' => 14],
            ['name' => 'GMC ユーコン', 'file' => public_path('images/GMC ユーコン.jpg'), 'maker_id' => 14],
            // フランスの車種
            ['name' => 'メガーヌ', 'file' => public_path('images/メガーヌ.jpg'), 'maker_id' => 15],
            ['name' => 'クリオ', 'file' => public_path('images/クリオ.jpg'), 'maker_id' => 15],
            ['name' => 'カングー', 'file' => public_path('images/カングー.jpg'), 'maker_id' => 15],
            ['name' => '208', 'file' => public_path('images/208.jpg'), 'maker_id' => 16],
            ['name' => '308', 'file' => public_path('images/308.jpg'), 'maker_id' => 16],
            ['name' => '508', 'file' => public_path('images/508.jpg'), 'maker_id' => 16],
            ['name' => 'C3', 'file' => public_path('images/C3.jpg'), 'maker_id' => 17],
            ['name' => 'C4', 'file' => public_path('images/C4.jpg'), 'maker_id' => 17],
            ['name' => 'C5', 'file' => public_path('images/C5.jpg'), 'maker_id' => 17],
            // イタリアの車種
            ['name' => 'フィアット500', 'file' => public_path('images/フィアット.jpg'), 'maker_id' => 18],
            ['name' => 'パンダ', 'file' => public_path('images/パンダ.jpg'), 'maker_id' => 18],
            ['name' => 'ティーポ', 'file' => public_path('images/ティーポ.jpg'), 'maker_id' => 18],
            ['name' => '488 GTB', 'file' => public_path('images/488 GTB.jpg'), 'maker_id' => 19],
            ['name' => 'カリフォルニア', 'file' => public_path('images/カリフォルニア.jpg'), 'maker_id' => 19],
            ['name' => 'ラフェラーリ', 'file' => public_path('images/ラフェラーリ.jpg'), 'maker_id' => 19],
            ['name' => 'ウラカン', 'file' => public_path('images/ウラカン.jpg'), 'maker_id' => 20],
            ['name' => 'アヴェンタドール', 'file' => public_path('images/アヴェンタドール.jpg'), 'maker_id' => 20],
            ['name' => 'ガヤルド', 'file' => public_path('images/ガヤルド.jpg'), 'maker_id' => 20],
            ['name' => '500', 'file' => public_path('images/アバルト500.jpg'), 'maker_id' => 21],
            ['name' => '595', 'file' => public_path('images/アバルト595.jpg'), 'maker_id' => 21],
            ['name' => '695', 'file' => public_path('images/アバルト695.jpg'), 'maker_id' => 21],
            ['name' => '124 スパイダー', 'file' => public_path('images/124スパイダー.jpg'), 'maker_id' => 21],
            ['name' => 'プント', 'file' => public_path('images/プント.jpg'), 'maker_id' => 21],
            ['name' => 'グランデ プント', 'file' => public_path('images/グランデプント.jpg'), 'maker_id' => 21],
            ['name' => '695 ビポスト', 'file' => public_path('images/695 ビポスト.jpg'), 'maker_id' => 21],
            // ドイツの車種
            ['name' => 'ゴルフ', 'file' => public_path('images/ゴルフ.jpg'), 'maker_id' => 22],
            ['name' => 'ポロ', 'file' => public_path('images/ポロ.jpg'), 'maker_id' => 22],
            ['name' => 'ティグアン', 'file' => public_path('images/ティングアン.jpg'), 'maker_id' => 22],
            ['name' => '3シリーズ', 'file' => public_path('images/3シリーズ.jpg'), 'maker_id' => 23],
            ['name' => '5シリーズ', 'file' => public_path('images/5シリーズ.jpg'), 'maker_id' => 23],
            ['name' => 'X5', 'file' => public_path('images/X5.jpg'), 'maker_id' => 23],
            ['name' => 'Cクラス', 'file' => public_path('images/Cクラス.jpg'), 'maker_id' => 24],
            ['name' => 'Eクラス', 'file' => public_path('images/Eクラス.jpg'), 'maker_id' => 24],
            ['name' => 'Sクラス', 'file' => public_path('images/Sクラス.jpg'), 'maker_id' => 24],
            // 中国の車種
            ['name' => 'MG6', 'file' => public_path('images/MG6.jpg'), 'maker_id' => 25],
            ['name' => 'ハン', 'file' => public_path('images/ハン.jpg'), 'maker_id' => 26],
            // 韓国の車種
            ['name' => 'ソナタ', 'file' => public_path('images/ソナタ.jpg'), 'maker_id' => 28],
            ['name' => 'スポーテージ', 'file' => public_path('images/スポーテージ.jpg'), 'maker_id' => 29],
            ['name' => 'レクストン', 'file' => public_path('images/レクストン.jpg'), 'maker_id' => 30],
        ];

        foreach ($cars as $car) {
            // 画像をCloudinaryにアップロード
            if (file_exists($car['file'])) {
                $upload_result = Cloudinary::upload($car['file']);
                // URLを取得
                $photo_url = $upload_result->getSecurePath();
            } else {
                $photo_url = null; // ファイルが存在しない場合はnullを設定
            }

            // データベースに挿入
            DB::table('cars')->insert([
                'name' => $car['name'],
                'photo' => $photo_url,
                'maker_id' => $car['maker_id']
            ]);
        }
    }
}
