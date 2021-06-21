<?php

namespace App\Http\Controllers\Admin;

use App\Contract;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContractRequest;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Status;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contract_s = Contract::all();

        return view('admin.contract_s.index', compact('contract_s'));
    }

    public function create()
    {
        abort_if(Gate::denies('contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $status_ = Status::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.contract_s.create', compact('status_'));
    }

    public function store(StoreContractRequest $request)
    {
        $contract = Contract::create($request->all());

        return redirect()->route('admin.contract-s.index');
    }

    public function edit(Contract $contract_)
    {
        abort_if(Gate::denies('contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status_ = Status::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $contract_->load('status','created_by');

        return view('admin.contract_s.edit', compact('contract_', 'status_'));
    }

    public function update(UpdateContractRequest $request, Contract $contract_)
    {
        $contract_->update($request->all());

        return redirect()->route('admin.contract-s.index');
    }

    public function show(Contract $contract_)
    {
        abort_if(Gate::denies('contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contract_->load('created_by');

        return view('admin.contract_s.show', compact('contract_'));
    }

    public function destroy(Contract $contract_)
    {
        abort_if(Gate::denies('contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contract_->delete();

        return back();
    }

    public function massDestroy(MassDestroyContractRequest $request)
    {
        Contract::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
