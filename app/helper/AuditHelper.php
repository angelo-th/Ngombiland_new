namespace App\Helpers;

use App\Models\AuditLog;

class Audit
{
    public static function log($userId, $action, $details = null, $ip = null)
    {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
            'ip_address' => $ip ?? request()->ip(),
        ]);
    }
}
