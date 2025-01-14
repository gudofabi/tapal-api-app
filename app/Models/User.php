<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected static function boot()
    {
        parent::boot();

        // Generate a custom user_code on user creation
        static::creating(function ($user) {
            $user->profile_id = self::generateCustomUserCode();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'profile_id',
        'name',
        'email',
        'password',
        'role',
        'contact_no',
        'user_id',
        'email_verified_at'
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
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    public static function generateCustomUserCode()
    {
        // Get the current year in YY format
        $year = now()->format('y');

        // Generate a random 5-digit number
        $randomNumber = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

        // Format the user_code
        return sprintf('TPL-%s%s', $year, $randomNumber);
    }

    /**
     * Get the loan associated with the user.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }


    /**
     * Get the users
     * 
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
