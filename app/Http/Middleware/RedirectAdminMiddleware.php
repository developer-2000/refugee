<?php

namespace App\Http\Middleware;

use App\Http\Traits\Admin\AdminTrait;
use Closure;
use Illuminate\Http\Request;

class RedirectAdminMiddleware {
    use AdminTrait;

    /**
     * Не пускает админа и перенаправляет
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($this->checkAccess('admin')) {
            return redirect()->route('admin.index');
        }
        return $next($request);
    }
}
