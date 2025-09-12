<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Marquer comme lu
     */
    public function markAsRead()
    {
        $this->update([
            'read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Marquer comme non lu
     */
    public function markAsUnread()
    {
        $this->update([
            'read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Scope pour les notifications non lues
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    /**
     * Scope pour les notifications lues
     */
    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    /**
     * Scope par type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Créer une notification
     */
    public static function createNotification($userId, $type, $title, $message, $data = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Créer une notification de message
     */
    public static function createMessageNotification($userId, $senderName, $messagePreview)
    {
        return self::createNotification(
            $userId,
            'message',
            'Nouveau message',
            "Vous avez reçu un message de {$senderName}",
            ['preview' => $messagePreview]
        );
    }

    /**
     * Créer une notification d'investissement
     */
    public static function createInvestmentNotification($userId, $propertyTitle, $amount)
    {
        return self::createNotification(
            $userId,
            'investment',
            'Nouvel investissement',
            "Vous avez investi {$amount} FCFA dans {$propertyTitle}",
            ['amount' => $amount, 'property' => $propertyTitle]
        );
    }

    /**
     * Créer une notification de propriété
     */
    public static function createPropertyNotification($userId, $title, $message, $propertyId = null)
    {
        return self::createNotification(
            $userId,
            'property',
            $title,
            $message,
            $propertyId ? ['property_id' => $propertyId] : null
        );
    }

    /**
     * Créer une notification système
     */
    public static function createSystemNotification($userId, $title, $message, $data = null)
    {
        return self::createNotification(
            $userId,
            'system',
            $title,
            $message,
            $data
        );
    }
}