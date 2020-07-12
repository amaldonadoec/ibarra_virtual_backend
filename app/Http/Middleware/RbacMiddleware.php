<?php

namespace App\Http\Middleware;

use App\Http\Models\Permission;
use Closure;
use Illuminate\Support\Facades\Auth;

class RbacMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guest()) {
            return redirect('/login');
        }
        $url = $request->route()->uri();
        $action = $request->method() . ' ' . $url;
        $exists = Permission::where('name', '=', $action)->first();
        $permission = $exists ? $exists : new Permission();
        $permission->name = $action;
        $permission->save();

        if (!$request->user()->can($action) && $request->user()->id != 1) {
            abort(403, 'No estas autorizado');
        }
        return $next($request);
    }
}
