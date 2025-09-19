<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\usr_roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(User::count()=='0'){
            User::firstOrCreate(['email'=>'admin@mail.com'],[
                'id'=>'1',
                'email'=>'admin@mail.com',
                'nombre'=>'Enrique',
                'apellido'=>'Scheinvar',
                'usrname'=>'Admin',
                'nace'=>'1977-07-22',
                'password'=>Hash::make('admin'),
            ]);
            User::firstOrCreate(['email'=>'escheinvar@gmail.com'],[
                'id'=>'2',
                'email'=>'escheinvar@gmail.com',
                'nombre'=>'Enrique',
                'apellido'=>'Scheinvar',
                'usrname'=>'escheinvar',
                'nace'=>'1977-07-22',
                'password'=>Hash::make('admin'),
            ]);
        }
    }
}
