<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrganizationController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Organization::class);

        return OrganizationResource::collection(Organization::all());
    }

    public function store(OrganizationRequest $request)
    {
        $this->authorize('create', Organization::class);

        return new OrganizationResource(Organization::create($request->validated()));
    }

    public function show(Organization $organization)
    {
        $this->authorize('view', $organization);

        return new OrganizationResource($organization);
    }

    public function update(OrganizationRequest $request, Organization $organization)
    {
        $this->authorize('update', $organization);

        $organization->update($request->validated());

        return new OrganizationResource($organization);
    }

    public function destroy(Organization $organization)
    {
        $this->authorize('delete', $organization);

        $organization->delete();

        return response()->json();
    }
}
