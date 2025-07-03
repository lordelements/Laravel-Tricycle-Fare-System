<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\AuditTrail;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',
        'status',
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

    protected function AuditTrail()
    {
        return $this->hasMany(AuditTrail::class);
    }

    public function log($message, $usertype)
    {
        // $message = ucwords($message);
        // Ensure the user is authenticated
        if (!$this->id) {
            throw new \Exception('User must be authenticated to log activity.');
        }
        AuditTrail::query()->create([
            'user_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'usertype' => $usertype,
            'date' => Carbon::parse(now()->toDateTimeString()),
            'activity' => "{$this->name} performed an action: {$message}",
            'usertype' => $this->usertype,
        ]);
    }
    
    /**
     * Get the user type.
     *
     * @return string
     */
    public function getUserType(): string
    {
        return $this->usertype;
    }

    /**
     * Get the user's reports.
     *
     * @return string
     */
    public function Reports()
    {
        return $this->hasMany(Report::class);
    }
}
