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
use App\Jobs\ChangePasswordUserJob;
use App\Jobs\RegistrationUserJob;
use App\Jobs\RespondVacancyResumeJob;
use App\Jobs\SendActivateAccount;
use App\Jobs\SendFeedbackMessage;
use App\Model\Code;
use App\Model\User;
use App\Model\UserContact;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthorController extends BaseController {

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

//        if(!Auth::check()){
            Auth::guard('web')->login($user);
//        }

        SendActivateAccount::dispatch($user->email)
            ->onQueue('emails');

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



























