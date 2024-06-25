<?php

use Illuminate\Database\Migrations\Migration; // Import the Migration class
use Illuminate\Database\Schema\Blueprint; // Import the Blueprint class for schema creation
use Illuminate\Support\Facades\Schema; // Import the Schema facade for interacting with the database schema

class CreateUsersTable extends Migration
{
    // Method to define the actions to be performed when migrating up
    public function up()
    {
        // Create the 'users' table with specified columns and constraints
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Column for user's name
            $table->string('email')->unique(); // Column for user's email (unique constraint)
            $table->string('password'); // Column for user's password (hashed)
            $table->timestamps(); // Timestamps for created_at and updated_at columns
        });
    }

    // Method to define the actions to be performed when rolling back the migration
    public function down()
    {
        // Drop (delete) the 'users' table if it exists
        Schema::dropIfExists('users');
    }
}
