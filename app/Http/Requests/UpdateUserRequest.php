<?php

namespace App\Http\Requests;

use App\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'username'    => [
                'required',
            ],
            'firstname'     => [
                'required',
            ],
            'lastname'     => [
                'required',
            ],
            'address'     => [
                'required',
            ],
            'city'     => [
                'required',
            ],
            'state'     => [
                'required',
            ],
            'zip'     => [
                'required',
            ],
            'status_id'     => [
                'required',
            ],

            'email'   => [
                'required',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles'   => [
                'required',
                'array',
            ],
        ];
    }
}
