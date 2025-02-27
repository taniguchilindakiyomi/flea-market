<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id')->toArray();
        $items = Item::pluck('id')->toArray();

        if (empty($users) || empty($items)) {
            return;
        }

        $comments = [];

        for ($i = 0; $i < 50; $i++) {
            $comments[] = [
                'user_id'    => $users[array_rand($users)],
                'item_id'    => $items[array_rand($items)],
                'comment'    => 'これはダミーコメントです！ ' . ($i + 1),
            ];
        }

        DB::table('comments')->insert($comments);
    }
}
