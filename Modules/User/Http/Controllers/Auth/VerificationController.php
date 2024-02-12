<?php

namespace Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Modules\User\Http\Requests\VerifyCodeRequest;
use Modules\User\Services\VerifyCodeService;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:20,1')->only('verify', 'resend');
    }

    /**
     * renders the email verify code page
     *
     * @param Request $request
     * @return Application|View|Factory|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     */
    public function show(Request $request): Application|View|Factory|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('User::Front.verify');
    }

    /**
     * checks if the entered verification code is
     * the same as the verification code send to the user
     *
     * @param VerifyCodeRequest $request
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    public function verify(VerifyCodeRequest $request): RedirectResponse
    {
        if (!VerifyCodeService::check(auth()->id(), $request->verify_code))
            return back()->withErrors(['verify_code' => __("invalid verification code !")]);


        auth()->user()->markEmailAsVerified();
        return redirect()->to($this->redirectTo);
    }

    /**
     * resends verification email if conditions met
     *
     * @param Request $request
     * @return Application|JsonResponse|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function resend(Request $request): Application|JsonResponse|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect($this->redirectPath());
        }

        if (VerifyCodeService::checkStatus($request->user()->id))
            return $request->wantsJson()
                ? new JsonResponse(["verify_code" => __("Sorry, you have already requested a verification code recently. Please wait a while before requesting another code")], Response::HTTP_FORBIDDEN)
                : redirect()->back()->withErrors(["verify_code" => __("Sorry, you have already requested a verification code recently. Please wait a while before requesting another code")]);

        $request->user()->sendEmailVerificationNotification();

        return $request->wantsJson()
            ? new JsonResponse([], 202)
            : back()->with('resent', true);
    }
}
