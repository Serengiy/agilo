<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            User::query()->create([
                'name' => 'admin',
                'email' => 'admin@mail.ru',
                'password' => 'password',
                'role' => 1,
            ]);
        }catch (\Throwable $e){
            if(User::query()->where('name', 'admin')){
                echo 'User already exists ';
            }
        }
        return self::FAILURE;
    }
}
