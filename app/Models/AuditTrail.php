<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'date',
        'activity',
        'usertype',
    ];

    protected $table = 'audit_trails';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
