<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('news')->truncate();

        $items = [
            [
                'title' => 'Trailer mới nhất của Interstellar tái xuất',
                'excerpt' => 'Đạo diễn Nolan nhá hàng đoạn trailer mới gây sốt...',
                'image_path' => 'img/interstellar.jpg',
            ],
            [
                'title' => 'Avatar 2 chạm mốc doanh thu khủng',
                'excerpt' => 'Bom tấn phòng vé tiếp tục lập kỉ lục...',
                'image_path' => 'img/avatar.jpg',
            ],
            [
                'title' => 'The Boys season mới đã ấn định ngày chiếu',
                'excerpt' => 'Dàn diễn viên xác nhận trở lại...',
                'image_path' => 'img/the-boys.jpg',
            ],
            [
                'title' => 'Danh sách đề cử Oscar năm nay',
                'excerpt' => 'Những bộ phim nổi bật góp mặt...',
                'image_path' => 'img/black-panther.jpg',
            ],
        ];

        foreach ($items as $i) {
            $i['slug'] = Str::slug($i['title']) . '-' . Str::random(5);
            $i['content'] = ($i['excerpt'] ?? 'Tin tức phim') . "\n\nChi tiết bài viết đang cập nhật.";
            $i['is_published'] = true;
            $i['published_at'] = now()->subDays(rand(0, 10));
            $i['created_at'] = now();
            $i['updated_at'] = now();
            DB::table('news')->insert($i);
        }
    }
}

