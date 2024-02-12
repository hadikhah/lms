<?php

namespace Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Modules\User\Http\Requests\ChangePasswordRequest;
use Modules\User\Services\UserService;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * renders password reset form
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function showResetForm(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('User::Front.passwords.reset');
    }

    /**
     *  updates user's password
     *
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     */
    public function reset(ChangePasswordRequest $request): RedirectResponse
    {
        UserService::changePassword(auth()->user(), $request->password);
        return redirect()->to($this->redirectTo);
    }

}
