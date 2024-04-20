<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // cek apakah ada auhtorization header pd request yg diminta
        $authHeader = $request->header('Authorization'); // Bearer token
        if(!$authHeader){
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        }

        // cek token
        $token = explode(' ', $authHeader)[1];
        $user = User::where('token', $token)->first();
        if(!$user){
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        }

        // middleware passed
        Auth::login($user);

        return $next($request);
    }
}
