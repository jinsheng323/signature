<?php

namespace App\Http\Controllers\Api\V1\Frontend;

use App\Job;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\Admin\JobResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobApiController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('job_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new JobResource(Job::with(['contract', 'created_by'])->get());
    }

    public function store(StoreJobRequest $request)
    {
        $job = Job::create($request->all());

        return (new JobResource($job))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Job $job)
    {
        //abort_if(Gate::denies('job_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new JobResource($job->load(['contract', 'created_by']));
    }

    public function update(UpdateJobRequest $request, Job $job)
    {
        $job->update($request->all());

        return (new JobResource($job))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Job $job)
    {
        //abort_if(Gate::denies('job_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
