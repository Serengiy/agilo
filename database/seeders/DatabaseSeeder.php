<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Password;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(9)
            ->has(Project::factory(rand(3,5))
                ->has(Password::factory(rand(2,5)))
                ->afterCreating(function (Project $project){
                    $users = User::inRandomOrder()->limit(rand(2,5))->get();
                    $project->users()->attach($users);
                })
            )
            ->create();
    }
}
