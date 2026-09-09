<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $timeout = (int) config('session.lifetime', 30) * 60; // Timeout in seconds (e.g. 30 minutes = 1800s)
            $lastActivity = $request->session()->get('last_activity_time');

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                $user = Auth::user();

                if ($user) {
                    ActivityLogger::log(
                        action: 'logout',
                        description: "Pengguna {$user->name} ({$user->email}) otomatis logout karena tidak ada aktivitas selama 30 menit.",
                        subject: $user,
                        module: 'Autentikasi',
                        properties: [
                            'ip' => $request->ip(),
                            'user_agent' => $request->userAgent(),
                            'reason' => 'inactivity_timeout_30m'
                        ],
                        user: $user
                    );
                }

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'message' => 'Sesi Anda telah berakhir karena tidak ada aktivitas selama 30 menit.',
                        'redirect' => route('login')
                    ], 401);
                }

                return redirect()->route('login')->with('warning', 'Sesi Anda telah berakhir karena tidak ada aktivitas selama 30 menit. Silakan login kembali.');
            }

            // Update last activity time on active request
            $request->session()->put('last_activity_time', time());
        }

        return $next($request);
    }
}
