<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\ActivateAccountRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\CheckEmailRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SendCodeChangePasswordRequest;
use App\Http\Requests\Auth\ViewChangePasswordRequest;
use App\Jobs\ChangePasswordUserJob;
use App\Jobs\RegistrationUserJob;
use App\Jobs\SendActivateAccount;
use App\Model\Code;
use App\Model\User;
use App\Model\UserContact;
use App\Services\LanguageService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthorController extends BaseController {

    /**
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request) {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {

            // заблокированный user
            if (Auth::user()->punished !== 0){
                return $this->getErrorResponse(__("auth.account_is_blocked"), 404);
            }
            // не активированный user
            elseif(Auth::user()->email_verified_at === null){
                Auth::logout();
                return $this->getErrorResponse(__('auth.not_activation_account'), 404);
            }
            // активированый user
            else{
                return $this->getResponse();
            }

        }

        return $this->getErrorResponse(__('auth.data_not_correct'));
    }

    /** lotokvest@gmail.com
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        UserContact::create([
            'user_id'=>$user->id,
            'name'=>$request->first_name,
            'surname'=>$request->last_name,
        ]);
        $permission = \App\Model\Permission::where("name", "user")->first();
        \App\Model\UserPermission::create([
            "user_id"=>$user->id,
            "permission_id"=>$permission->id,
        ]);

        // Генерируем ссылку и отправляем письмо на указанный адрес
        $generate = uniqid();
        Code::create([ 'user_id' => $user->id, 'code' => $generate ]);
        $url = url(session('prefix_lang'))."/user/activate?id=".$user->id."&code=".$generate;

        RegistrationUserJob::dispatch([
            "url"=>$url,
            "email"=>$request->email,
            "title_subject"=>__('email.registration'),
        ])->onQueue('emails');

        return $this->getResponse(__('auth.message_change_password_email'));
    }

    /**
     * @param  CheckEmailRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmail(CheckEmailRequest $request) {
        $resp = true;
        if(User::where('email', $request->email)->first()){
            $resp = false;
        }
        return $this->getResponse($resp);
    }

    /**
     * @param  ActivateAccountRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function activateAccount(ActivateAccountRequest $request) {

        // существование code верификации
        if($collCode = Code::where('user_id',$request->id)
            ->where('code',$request->code)->first()
        ){
            // существование указанного user
            if($user = User::where("id", $request->id)->first()){
                // user не заблокирован
                if($user->punished === 0){
                    $user->email_verified_at = now();
                    $user->save();
                     $collCode->delete();
                    // авторизация user
                    Auth::guard('web')->login($user);
                    // отправка уведомления user
                    SendActivateAccount::dispatch($user->email)
                        ->onQueue('emails');
                }
                else{
                    return redirect(session('prefix_lang'))->withErrors(['message'=>__("auth.account_is_blocked")]);
                }
            }
            else{
                return redirect(session('prefix_lang'))->withErrors(['message'=>__("auth.data_not_correct")]);
            }
        }
        else{
            return redirect(session('prefix_lang'))->withErrors(['message'=>__("auth.account_already_activated")]);
        }

        return redirect(session('prefix_lang'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        return redirect(session('prefix_lang'));
    }

    /**
     * @param  SendCodeChangePasswordRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCodeForChangePassword(SendCodeChangePasswordRequest $request) {

        // существование указанного user
        if($user = User::where("email", $request->email)->first()){
            // user не заблокирован
            if($user->punished === 0){
                Auth::logout();
                // Генерируем ссылку и отправляем письмо на указанный адрес
                $generate = uniqid();
                Code::create([ 'code' => $generate, 'email' => $request->email ]);
                $url = url(session('prefix_lang'))."/user/view-change-password?code=".$generate;

                ChangePasswordUserJob::dispatch([
                    "url"=>$url,
                    "email"=>$request->email,
                    "title_subject"=>__('email.password_change'),
                ])->onQueue('emails');

                return $this->getResponse(__('auth.message_change_password_email'));
            }
            else{
                return $this->getErrorResponse(__("auth.account_is_blocked"));
            }
        }
        else{
            return $this->getErrorResponse(__("auth.data_not_correct"));
        }

    }

    /**
     * @param  ViewChangePasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function viewChangePassword(ViewChangePasswordRequest $request)
    {
        $db_code = Code::where('code',$request->code)->first();
        $lang = (new LanguageService())->getLanguageArray();

        if($user = User::where('email',$db_code->email)->first()){
            return redirect(session('prefix_lang'))->with('code_change_password', json_encode($request->code));
        }

        return redirect(session('prefix_lang'))->with('link_not_valid', __('auth.link_not_valid'));
    }

    /**
     * @param  ChangePasswordRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $db_code = Code::where('code',$request->code)->first();

        if($user = User::where('email',$db_code->email)->first()){
            Auth::logout();
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::guard('web')->login($user);
            $db_code->delete();
            return $this->getResponse();
        }

        return $this->getErrorResponse(__('auth.link_not_valid'));
    }

}



























