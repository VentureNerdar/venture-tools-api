<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'user_role_id',
        'is_active',
        'biography',
        'last_login_at',
        'preferred_language_id',
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
            'email_verified_at' => 'immutable_datetime:d M Y H:i:s',
            'last_login_at' => 'immutable_datetime:d M Y H:i:s',
            'deleted_at' => 'immutable_datetime:d M Y H:i:s',
            'created_at' => 'immutable_datetime:d M Y H:i:s',
            // 'created_at'            => 'date:d M Y',
            // 'updated_at'            => 'immutable_datetime:d M Y',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'updated_at' => 'date',
        ];
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::get(fn ($value) => $value ? Carbon::parse($value)->format('d M Y H:i:s') : null);
    }

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    public function preferredLanguage()
    {
        return $this->belongsTo(SystemLanguage::class, 'preferred_language_id');
    }

    public function churches()
    {
        return $this->hasMany(Church::class);
    }
}
