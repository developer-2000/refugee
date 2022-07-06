<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SignInRequest;
use App\Http\Traits\AdminTrait;
use Illuminate\Support\Facades\Auth;


class AdminController extends AdminBaseController {
    use AdminTrait;

    /**
     * панель админки или авторизация
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function accessPanel() {
        if($this->checkAccess('admin')) {
            $response = [
                "logo_text"=>["uk"=>env("APP_NAME_UK"), "en"=>env("APP_NAME_EN")]
            ];
            return view('admin_panel.admin_panel', compact('response'));
        }

        return view('admin_panel.authorization');
    }

    /**
     * авторизация и проверка доступа к панели admin
     * @param  SignInRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(SignInRequest $request) {
        if (Auth::attempt([ 'email' => $request->email, 'password' => $request->password ], true)) {
            if($this->checkAccess('admin')) {
                return $this->getResponse();
            }
            Auth::logout();
        }

        return $this->getErrorResponse();
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('admin.index');
    }
















































}
