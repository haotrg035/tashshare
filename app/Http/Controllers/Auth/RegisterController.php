<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('register.ispost');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => ['bail','required', 'string', 'max:255','unique:users'],
            'user_email' => ['bail','required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['bail','required', 'string', 'min:8', 'confirmed'],
            'user_fullname' => ['bail','required','string','min:3']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'user_name' => $data['user_name'],
            'user_email' => $data['user_email'],
            'password' => Hash::make($data['password']),
            'user_fullname' => $data['user_fullname']
        ]);
    }

    public function createUser(Request $request)
    {
        $data = [
            'user_name' => $request->register_user_name,
            'user_email' => $request->register_user_email,
            'password' => $request->register_password,
            'password_confirmation' => $request->register_password_confirmation,
            'user_fullname' => $request->register_fullname
        ];
        $validation = $this->validator($data);
        if ($validation->fails()) {
            return redirect(route('auth.login'))->withErrors($validation);
        }
        Auth::login($this->create($data));
        return redirect(route('dashboard'));
    }

    public function validateAjax(Request $request)
    {
        $data = $request['data'];
        $validation = $this->validator($data);
        if ($validation->fails()) {
            return $validation->errors();
        }
        return ['validated' => 'success'];
    }

    public function validateUserName(Request $request)
    {
        $rules = array(
            'user_name' => 'bail|required|string|min:5|max:255|unique:users'
        );
        return $this->validatingBootstrap($request->all(),$rules);

    }

    public function validatePassword(Request $request)
    {
        $rules = array(
            'password' => 'bail|required|string|min:8|confirmed'
        );
        return $this->validatingBootstrap($request->all(),$rules);

    }

    public function validatePasswordConfirm(Request $request)
    {
        $rules = array(
            'password' => 'bail|required|string|min:8'
        );
        return $this->validatingBootstrap($request->all(),$rules);

    }

    public function validateEmail(Request $request)
    {
        $rules = array(
            'user_email' => 'bail|required|string|email|max:255|unique:users'
        );
        return $this->validatingBootstrap($request->all(),$rules);

    }
//
    protected function validatingBootstrap($data,$rules)
    {
        $validation = Validator::make($data,$rules,$this->messages(),$this->attributeNames());
        if ($validation->fails()) {
           return response()->json($validation->errors());
        }
        return ['success' => 'success'];
    }
    protected function attributeNames()
    {
        return array(
            'user_name' =>'Tên tài khoản',
            'user_email' =>'Email',
            'password' =>'Mật khẩu'
        );
    }

    protected function messages(){
        return array(
            'required' => ':attribute không được bỏ trống.',
            'min' => 'Vui lòng nhập nhiều hơn :min kí tự.',
            'max' => 'Vượt quá :max kí tự.',
            'unique' =>':attribute đã có người sử dụng.',
            'confirmed' =>':attribute nhập lại không trùng khớp',
            'email' => 'Phải nhập đúng định dạng email vd: example@mail.com'
        );
    }
}
