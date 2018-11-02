<?php

namespace App\Http\Middleware;

use Closure;

use App\Exceptions\InternalException;

class CheckIfEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!isset($request->user()->email_verified)) {
            throw new InternalException("不能访问");
        }

        if (!$request->user()->email_verified) {
            if ($request->expectsJson()) {
                return response()->json(['msg' => '请先验证邮箱'], 400);
            }
            return redirect(route('email_verify_notice'));
        }
        return $next($request);
    }
}
