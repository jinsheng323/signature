<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contract;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Http\Resources\Admin\ContractResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContractResource(Contract::with(['created_by'])->get());
    }

    public function store(StoreContractRequest $request)
    {
        $contract_ = Contract::create($request->all());

        return (new ContractResource($contract_))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Contracts $contract_)
    {
        abort_if(Gate::denies('contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContractResource($contract_->load(['created_by']));
    }

    public function update(UpdateContractRequest $request, Contract $contract_)
    {
        $contract_->update($request->all());

        return (new ContractResource($contract_))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Contract $contract_)
    {
        abort_if(Gate::denies('contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contract_->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
