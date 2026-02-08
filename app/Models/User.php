<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory,
        Notifiable,
        HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    //relationships
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'agent_id');
    }

    //helper methods
    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isAgent(): bool
    {
        return $this->role === UserRole::Agent;
    }
    public function isCustomer(): bool
    {
        return $this->role === UserRole::Customer;
    }

    // public function doSomething(): static
    // {
    //     // do something
    //     return $this;
    // }

    // public function doAnotherThing(): static
    // {
    //     // do another thing
    //     return $this;
    // }
}





// $admin = new User();
// $admin->name = "John Doe";
// $admin->email = "email@email.com";
// $admin->role = UserRole::Admin;
// $admin->password = "password123";
// $admin->save();


// if ($admin->isAdmin()) {
//     //do something
// } else {
//     //do something else
// }


// optional method chaining
// $admin->doSomething()->doAnotherThing();


// $agent = User::create([
//     'name' => 'John Doe',
//     'email' => 'agent@email.com',
//     'role' => UserRole::Agent,
//     'password' => 'password123',
// ]);


//oop, class, poperty, method, access modifire, constructor, object instance
