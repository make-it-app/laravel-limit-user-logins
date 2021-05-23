<?php

use Illuminate\Support\Facades\DB;

/**
 * helpers
 * @package MakeIT\LoginLimiter
 */
if ( !function_exists('login_limiter') )
{
    /**
     * Destroy other device sessions
     *
     * @return void
     */
    function login_limiter()
    {
        if ( config( 'login_limiter.enabled' ) ) {
            $pwd = request('password');
            if ( !empty($pwd) ) {
                auth()->logoutOtherDevices($pwd);
                if (config('session.driver') === 'database') {
                    DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                        ->where('user_id', request()->user()->getAuthIdentifier())
                        ->where('id', '!=', request()->session()->getId())
                        ->delete();
                }
            }
        }
    }
}
