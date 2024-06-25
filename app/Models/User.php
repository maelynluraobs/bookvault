<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable; // Import Authenticatable trait for authentication
use Laravel\Lumen\Auth\Authorizable; // Import Authorizable trait for authorization
use Illuminate\Database\Eloquent\Model; // Import Eloquent Model class
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract; // Import Authenticatable contract
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract; // Import Authorizable contract

// Import JWTSubject contract
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable; // Use Authenticatable and Authorizable traits

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Return the primary key of the user for JWT subject claim
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // Return an empty array as no custom claims are added to the JWT
    }
}
