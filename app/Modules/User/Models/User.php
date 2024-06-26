<?php

namespace App\Modules\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Modules\Fault\Models\Fault;
use App\Modules\User\Enums\UserStatusEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, FilamentUser
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'second_name',
        'last_name',
        'email',
        'phone',
        'status',
        'password',
        'is_admin',
        'group',
        'auth_code',
        'auth_code_expires_at',
        'auth_code_confirmed',
        'hash_password_recovery'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'email_verified_at',
        'auth_code_expires_at',
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->is_admin;
        }

        return true;
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->auth_code = rand(100000, 999999);
        $this->auth_code_expires_at = now()->addMinutes(10);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->auth_code = null;
        $this->auth_code_expires_at = null;
        $this->auth_code_confirmed = false;
        $this->save();
    }

    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(Fault::class, 'favourites');
    }

}
