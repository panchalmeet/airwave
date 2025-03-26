<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Generate UUID.
     *
     * @return uuid
     * @SuppressWarnings("StaticAccess")
     */
    public static function boot()
    {
        parent::boot();
        self::creating(
            function ($model) {
                $model->uuid = (string) Str::uuid();
            }
        );
    }
    
    /**
     * Get the user data.
     *
     * @param string $data user data
     *
     * @return \App\User
     */
    public function getUserData($data)
    {
        return $this->where($data)->first();
    }

    /**
     * Update the user data.
     *
     * @param int   $userId primary id
     * @param array $data   user data
     *
     * @return \App\User
     */
    public function updateUserData($userId, $data)
    {
        return $this->where('id', $userId)->update($data);
    }

    /**
     * Expired user's token
     *
     * @return never
     */
    public function revokeTokens()
    {
        $userTokens = $this->tokens;
        foreach ($userTokens as $token) {
            $token->revoke();
        }
    }

    /**
     * Belongs to relationship with roles
     *
     * @return never
     */
    public function role()
    {
        return $this->belongsTo(RoleMaster::class, 'role_id', 'id');
    }
}
