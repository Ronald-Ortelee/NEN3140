<?php
namespace Database\Seeders\Models;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Command :
         * artisan seed:generate --model-mode --models=User
         *
         */

        
        $newData0 = \App\Models\User::create([
            'id' => 1,
            'name' => 'Ronald',
            'email' => 'kliko@squint.nl',
            'email_verified_at' => NULL,
            'password' => '$2y$12$x5UYr9N1Ch.t1DQq2eL.tOuUhAoYz6a3lJKT6xJ7U.Cdc5f5eMw8y',
            'two_factor_secret' => NULL,
            'two_factor_recovery_codes' => NULL,
            'two_factor_confirmed_at' => NULL,
            'remember_token' => '9rZp9bPR2GquAv8xQ9S23eHlxaZqYEw9TjlK5AZfKdnF6pCScEXXWBrJ0TFJ',
            'current_team_id' => NULL,
            'profile_photo_path' => NULL,
            'created_at' => '2025-02-24 18:49:40',
            'updated_at' => '2025-02-24 18:49:40',
        ]);
    }
}