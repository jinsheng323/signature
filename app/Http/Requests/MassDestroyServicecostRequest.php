<?php

namespace App\Http\Requests;

use App\Servicecost;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyServicecostRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('servicecost_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:servicecosts,id',
        ];
    }
}
