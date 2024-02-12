<?php

namespace Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Modules\User\Models\User;
use Modules\User\Rules\ValidMobile;
use Modules\User\Rules\ValidPassword;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        $this->redirectTo = route("verification.notice");
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make(
            $data,
            [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'mobile'   => ['nullable', 'string', 'min:9', 'max:14', 'unique:users', new ValidMobile()],
                'password' => ['required', 'string', 'confirmed', new ValidPassword()],
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return Builder|Model
     */
    protected function create(array $data)
    {
        return User::query()->create(
            [
                'name'     => $data['name'],
                'email'    => $data['email'],
                'mobile'   => $data['mobile'],
                'password' => Hash::make($data['password']),
            ]
        );
    }

    /**
     * renders the registration page
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function showRegistrationForm(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('User::Front.register');
    }
}
