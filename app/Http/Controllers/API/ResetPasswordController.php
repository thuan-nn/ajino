<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendMailResetPassowrdRequest;
use App\Mail\ResetPassword as ResetPasswordMail;
use App\Models\Admin;
use App\Models\ResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * @param SendMailResetPassowrdRequest $request
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function sendMail(SendMailResetPassowrdRequest $request)
    {
        $email = Arr::get($request->validated(), 'email');

        $resetPassword = ResetPassword::query()
                                      ->updateOrCreate(
                                          ['email' => $email],
                                          [
                                              'token'      => Str::random(60),
                                              'expired_at' => Carbon::now()->addDay(),
                                          ]
                                      );
        Mail::to($email)->send(new ResetPasswordMail($resetPassword->token));

        return $this->httpCreated();
    }

    public function resetPassword(ResetPasswordRequest $request, $token)
    {
        $password = $request->validated();

        $resetPassword = ResetPassword::query()->where('token', $token)->firstOrFail();

        if (Carbon::now()->greaterThan(Carbon::parse($resetPassword->expired_at))) {
            $resetPassword->delete();

            return $this->httpBadRequest('The reset password mail is expired');
        }

        $admin = Admin::query()->where('email', $resetPassword->email)->firstOrFail();
        $admin->update($password);

        $resetPassword->delete();

        return $this->httpNoContent();
    }
}
