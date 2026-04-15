<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Validation\UnauthorizedException;

class EmailVerificationRequest extends FormRequest
{
    public function authorize()
    {
        if (! $this->user() || ! $this->user() instanceof MustVerifyEmail) {
            return false;
        }

        return ! $this->user()->hasVerifiedEmail();
    }

    public function rules()
    {
        return [];
    }

    public function fulfill()
    {
        if ($this->user()->hasVerifiedEmail()) {
            return;
        }

        $this->user()->markEmailAsVerified();
    }


}
