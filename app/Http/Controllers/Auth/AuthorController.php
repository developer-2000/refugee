<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\CheckEmailRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Model\Code;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthorController extends BaseController
{

    /**
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
//            'login' => $request->login,
            'email' => $request->email,
            'password' => Hash::make($request->password)]);

        $generate = uniqid();

        Code::create([ 'user_id' => $user->id, 'code' => $generate, ]);

        // Генерируем ссылку и отправляем письмо на указанный адрес
        $url = url('/').'/user/activate?id='.$user->id.'&code='.$generate;
        Mail::send('emails.registration', ['url' => $url], function($message) use ($request) {
            $message->to($request->email)->subject('Registration');
        });

        return $this->getResponse('На указынный Email, отправлено письмо для активации акаунта');
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

} // END
