<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'type', 'package_id', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
