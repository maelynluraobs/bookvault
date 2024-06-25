<?php

namespace Database\Seeders; // Define the namespace for the seeder

use App\Models\User; // Import the User model
use Illuminate\Database\Seeder; // Import the base Seeder class
use Illuminate\Support\Facades\Hash; // Import the Hash facade for password hashing

class UsersTableSeeder extends Seeder
{
    // The run method is executed when the seeder is run
    public function run()
    {
        // Create a new user with predefined details
        User::create([
            'name' => 'angelklingmaerhea', // User's name
            'email' => 'admins@gmail.com', // User's email
            'password' => Hash::make('password'), // User's password, hashed for security
        ]);
    }
}
