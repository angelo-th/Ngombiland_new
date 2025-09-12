<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Envoyer une notification à un utilisateur
     */
    public static function send($userId, $type, $title, $message, $data = null)
    {
        try {
            $notification = Notification::createNotification($userId, $type, $title, $message, $data);
            
            // Ici on pourrait ajouter d'autres canaux (email, SMS, push, etc.)
            self::broadcastNotification($notification);
            
            return $notification;
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de notification', [
                'user_id' => $userId,
                'type' => $type,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Envoyer une notification de message
     */
    public static function sendMessageNotification($receiverId, $senderName, $messagePreview)
    {
        return self::send(
            $receiverId,
            'message',
            'Nouveau message',
            "Vous avez reçu un message de {$senderName}",
            ['preview' => $messagePreview]
        );
    }

    /**
     * Envoyer une notification d'investissement
     */
    public static function sendInvestmentNotification($userId, $propertyTitle, $amount)
    {
        return self::send(
            $userId,
            'investment',
            'Nouvel investissement',
            "Vous avez investi " . number_format($amount, 0, ',', ' ') . " FCFA dans {$propertyTitle}",
            ['amount' => $amount, 'property' => $propertyTitle]
        );
    }

    /**
     * Envoyer une notification de propriété
     */
    public static function sendPropertyNotification($userId, $title, $message, $propertyId = null)
    {
        return self::send(
            $userId,
            'property',
            $title,
            $message,
            $propertyId ? ['property_id' => $propertyId] : null
        );
    }

    /**
     * Envoyer une notification système
     */
    public static function sendSystemNotification($userId, $title, $message, $data = null)
    {
        return self::send(
            $userId,
            'system',
            $title,
            $message,
            $data
        );
    }

    /**
     * Envoyer une notification à tous les utilisateurs
     */
    public static function broadcastToAll($type, $title, $message, $data = null)
    {
        $userIds = User::pluck('id');
        
        foreach ($userIds as $userId) {
            self::send($userId, $type, $title, $message, $data);
        }
    }

    /**
     * Envoyer une notification aux administrateurs
     */
    public static function sendToAdmins($type, $title, $message, $data = null)
    {
        $adminIds = User::where('role', 'admin')->pluck('id');
        
        foreach ($adminIds as $adminId) {
            self::send($adminId, $type, $title, $message, $data);
        }
    }

    /**
     * Diffuser une notification en temps réel (pour Livewire)
     */
    private static function broadcastNotification($notification)
    {
        // Ici on pourrait utiliser Pusher, Laravel Echo, ou d'autres services
        // Pour l'instant, on utilise Livewire pour la mise à jour en temps réel
        event(new \App\Events\NotificationSent($notification));
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public static function markAllAsRead($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('read', false)
            ->update([
                'read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Supprimer les anciennes notifications
     */
    public static function cleanupOldNotifications($days = 30)
    {
        return Notification::where('created_at', '<', now()->subDays($days))
            ->where('read', true)
            ->delete();
    }

    /**
     * Obtenir les statistiques des notifications
     */
    public static function getStats($userId = null)
    {
        $query = $userId ? Notification::where('user_id', $userId) : Notification::query();
        
        return [
            'total' => $query->count(),
            'unread' => $query->where('read', false)->count(),
            'read' => $query->where('read', true)->count(),
            'by_type' => $query->selectRaw('type, count(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type')
                ->toArray(),
        ];
    }
}
