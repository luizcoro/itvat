<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pt_BR');

        for($i = 0; $i < 100; ++$i)
        {
            App\User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => bcrypt('123123'),
                'nascimento' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'telefone' => $faker->phone,
                'tipo' => $faker->numberBetween($min = 0, $max = 1)
            ]);
        }
    }
}
