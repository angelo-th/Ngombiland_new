<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LimitGuestMessages
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            $count = Session::get('guest_messages_count', 0);

            if ($count >= 3) {
                return response()->json([
                    'error' => 'You have reached the maximum number of messages. Please register or login to continue.'
                ], 403);
            }

            Session::put('guest_messages_count', $count + 1);
        }

        return $next($request);
    }
}
