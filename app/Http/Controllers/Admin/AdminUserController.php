<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Users\IndexUserAdminRequest;
use App\Http\Requests\Admin\Users\SetPunishedAdminRequest;
use App\Model\User as Model;


class AdminUserController extends AdminBaseController {

    protected $model;

    public function __construct() {
        parent::__construct();
        $this->model = clone app(Model::class);
    }

    public function index(IndexUserAdminRequest $request){
        $config = config('admin.page');

        // 1 фильтр выборки
        $users = $this->initialDataForSampling($request);
        $users = $users
            ->with('contact.avatar','contact.position','permission')
            ->paginate($config["paginate"]);

        $response = [
            "contact_information"=>config('site.contacts.contact_information'),
            "users"=>$users,
        ];
        return view('admin_panel.admin_panel', compact('response'));
    }

    public function setPunished(SetPunishedAdminRequest $request){
        $this->model->where("id",$request->user_id)
            ->update(['punished' => $request->punished]);

        return $this->getResponse();
    }

    public function initialDataForSampling($request){
        $this->model = $this->user($request);

        return $this->model;
    }

    /**
     * указаный юзер
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function user($request){
        if (isset($request->user_id)) {
            $this->model = $this->model->where('id', $request->user_id);
        }

        return $this->model;
    }

}
