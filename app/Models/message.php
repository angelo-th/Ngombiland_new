<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'message',
        'read',
        'read_at',
    ];

    protected $casts = [
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Relations
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    // Méthodes
    public function markAsRead()
    {
        $this->update([
            'read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'read' => false,
            'read_at' => null,
        ]);
    }
}