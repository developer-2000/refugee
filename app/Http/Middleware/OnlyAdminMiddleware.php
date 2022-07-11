<?php

namespace App\Http\Middleware;

use App\Http\Traits\Admin\AdminTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlyAdminMiddleware {
    use AdminTrait;

    /**
     * Пускает только админа
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->checkAccess('admin')) {
            Auth::logout();
            return redirect()->route('admin.index');
        }
        return $next($request);
    }
}
