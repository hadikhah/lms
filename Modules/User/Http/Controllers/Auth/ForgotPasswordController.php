<?php

namespace Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\User\Http\Requests\ResetPasswordVerifyCodeRequest;
use Modules\User\Http\Requests\SendResetPasswordVerifyCodeRequest;
use Modules\User\Repositories\UserRepo;
use Modules\User\Services\VerifyCodeService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Psr\SimpleCache\InvalidArgumentException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function showVerifyCodeRequestForm(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('User::Front.passwords.email');
    }

    /**
     * @param SendResetPasswordVerifyCodeRequest $request
     * @param UserRepo $userRepo
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     * @throws InvalidArgumentException
     */
    public function sendVerifyCodeEmail(SendResetPasswordVerifyCodeRequest $request, UserRepo $userRepo): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $user = $userRepo->findByEmail($request->email);

        if (!$user)
            return redirect()->back()->withErrors(["email" => __("user not found")]);

        if (VerifyCodeService::checkStatus($user->id))
            return redirect()->back()->withErrors(["email" => __("Sorry, you have already requested a verification code recently. Please wait a while before requesting another code")]);

        VerifyCodeService::delete($user->id);

        $user->sendResetPasswordRequestNotification();


        return redirect()->route("password.verifyCodeForm")->with("email", $request->email);

    }

    /**
     * checks if email exists and renders the verification code
     *
     * @param Request $request
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     */
    public function showVerifyCodeForm(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $email = $request->session()->get("email");

        if (!$email)
            return redirect()->back()->withErrors(["email" => __("email not found")]);

        return view('User::Front.passwords.enter-verify-code-form', compact("email"));
    }

    public function checkVerifyCode(ResetPasswordVerifyCodeRequest $request)
    {
        $user = resolve(UserRepo::class)->findByEmail($request->email);

        if ($user == null || !VerifyCodeService::check($user->id, $request->verify_code)) {
            return back()->withErrors(['verify_code' => __("invalid verification code !")])
                         ->with("email", $request->email);
        }

        auth()->loginUsingId($user->id);

        return redirect()->route('password.showResetForm');

    }
}
