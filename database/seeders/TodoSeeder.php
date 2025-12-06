<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (! $user) {
            return;
        }

        $samples = [
            ['title' => 'Buy groceries', 'description' => 'Milk, eggs, bread, coffee', 'is_completed' => false],
            ['title' => 'Read a book', 'description' => 'Finish 20 pages of current book', 'is_completed' => true],
            ['title' => 'Plan weekend', 'description' => 'Pick a restaurant and a movie', 'is_completed' => false],
        ];

        foreach ($samples as $data) {
            Todo::firstOrCreate(
                ['user_id' => $user->id, 'title' => $data['title']],
                [
                    'description' => $data['description'],
                    'is_completed' => $data['is_completed'],
                ]
            );
        }
    }
}
