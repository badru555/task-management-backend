<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskCommentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('task_comments')->insert([
            [
                'task_id' => 2,
                'user_id' => 3,
                'comment' => 'Saya berhasil mereproduksi bug login secara lokal dan sedang mencari solusi.',
                'created_at' => now(),
            ],
            [
                'task_id' => 2,
                'user_id' => 1,
                'comment' => 'Tolong prioritaskan ini — berdampak ke produksi.',
                'created_at' => now(),
            ],
            [
                'task_id' => 8,
                'user_id' => 3,
                'comment' => 'Pull request refactor sudah siap untuk direview.',
                'created_at' => now(),
            ],
            [
                'task_id' => 5,
                'user_id' => 3,
                'comment' => 'Unit test untuk modul pembayaran sudah ditambahkan.',
                'created_at' => now(),
            ],
            [
                'task_id' => 7,
                'user_id' => 5,
                'comment' => 'Survei sudah dikirim — tingkat open rate awal 12%.',
                'created_at' => now(),
            ],
            [
                'task_id' => 9,
                'user_id' => 4,
                'comment' => 'Terblokir karena update dependency merusak test.',
                'created_at' => now(),
            ],
            [
                'task_id' => 12,
                'user_id' => 3,
                'comment' => 'Sandbox key untuk gateway baru sudah ditambahkan.',
                'created_at' => now(),
            ],
            [
                'task_id' => 1,
                'user_id' => 1,
                'comment' => 'Checklist onboarding sudah dibuat.',
                'created_at' => now(),
            ],
            [
                'task_id' => 3,
                'user_id' => 4,
                'comment' => 'Wireframe sudah diunggah ke Figma.',
                'created_at' => now(),
            ],
            [
                'task_id' => 15,
                'user_id' => 2,
                'comment' => 'Laporan SAST sudah dilampirkan di tiket.',
                'created_at' => now(),
            ],
        ]);
    }
}
