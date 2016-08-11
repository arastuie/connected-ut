<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotOwner {

    /**
     * Handle an incoming request.
     *
     *  Redirects if not the owner of an item tries to access it.
     * The item has to have a user_id on its DB table which is the owner's user's id
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $wildcard: Wildcard of the route to access the item
     * @return mixed
     */
	public function handle($request, Closure $next, $wildcard)
	{
        $user = $request->user();

        $item = $request->route($wildcard);

        if($item != null && $user && $item->user_id === Auth::id())
        {
            return $next($request);
        }

        return redirect('/');
	}
}
