<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\ActivateAccountRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ViewChangePasswordRequest;
use App\Http\Requests\Auth\SendCodeChangePasswordRequest;
use App\Http\Requests\Auth\CheckEmailRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Model\Code;
use App\Model\User;
use App\Model\UserContact;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthorController extends BaseController
{

    /**
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request) {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            if(Auth::user()->email_verified_at !== null){
                return $this->getResponse();
            }
            else{
                Auth::logout();
                return $this->getErrorResponse(__('auth.not_activation_account'), 404);
            }
        }

        return $this->getErrorResponse(__('auth.data_not_correct'));
    }

    /**
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)]);

        UserContact::create([
            'user_id'=>$user->id,
            'name'=>$request->first_name,
            'surname'=>$request->last_name,
        ]);

        $this->sendCodeEmail($request, 'id='.$user->id.'&', $user->id, 'Registration');

        return $this->getResponse(__('auth.message_change_password_email'));
    }

    /**
     * @param  CheckEmailRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmail(CheckEmailRequest $request)
    {
        $resp = 0;
        if(User::where('email', $request->email)->first()){
            $resp = 1;
        }
        return $this->getResponse($resp);
    }

    /**
     * @param  ActivateAccountRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function activateAccount(ActivateAccountRequest $request)
    {
        Code::where('user_id',$request->id)
            ->where('code',$request->code)
            ->delete();
        User::where('id',$request->id)
            ->update(['email_verified_at'=>now()]);

        $user = User::find($request->id);

        if(!Auth::check()){
            Auth::guard('web')->login($user);
        }

        $lang = (new LanguageService())->getLanguageArray();

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
    public function sendCodeForChangePassword(SendCodeChangePasswordRequest $request)
    {
        Auth::logout();

        $this->sendCodeEmail($request, '', null, 'Change Password', $request->email);

        return $this->getResponse(__('auth.message_change_password_email'));
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


    // Private
    /**
     * Email присылаетса в случае смены пароля
     * @param $request
     * @param $string_user_id
     * @param $user_id
     * @param $title_subject
     * @param  null  $email
     */
    private function sendCodeEmail($request, $string_user_id, $user_id, $title_subject, $email = null)
    {
        $alias = is_null($email) ? 'activate' : 'view-change-password';
        $generate = uniqid();
        Code::create([ 'user_id' => $user_id, 'code' => $generate, 'email' => $email ]);

        // Генерируем ссылку и отправляем письмо на указанный адрес
        $url = url(session('prefix_lang'))."/user/".$alias."?".$string_user_id."code=".$generate;
        Mail::send('emails.registration', ['url' => $url], function($message) use ($request, $title_subject) {
            $message->to($request->email)->subject($title_subject);
        });
    }

}



























