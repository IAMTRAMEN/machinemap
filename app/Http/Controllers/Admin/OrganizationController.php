<?php
// app/Http/Controllers/Admin/OrganizationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationType;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::with('type')
            ->latest()
            ->paginate(20);

        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        $organizationTypes = OrganizationType::active()->get();
        return view('admin.organizations.create', compact('organizationTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organization_type_id' => 'required|exists:organization_types,id',
            'code' => 'nullable|string|unique:organizations,code',
            'legal_name' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended',
            'custom_fields' => 'nullable|array'
        ]);

        Organization::create($validated);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization created successfully.');
    }

    public function show(Organization $organization)
    {
        $organization->load([
            'type',
            'outgoingRelationships.type',
            'incomingRelationships.type',
            'contacts'
        ]);

        return view('admin.organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        $organizationTypes = OrganizationType::active()->get();
        return view('admin.organizations.edit', compact('organization', 'organizationTypes'));
    }

    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organization_type_id' => 'required|exists:organization_types,id',
            'code' => 'nullable|string|unique:organizations,code,' . $organization->id,
            'legal_name' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended',
            'custom_fields' => 'nullable|array'
        ]);

        $organization->update($validated);

        return redirect()->route('admin.organizations.show', $organization)
            ->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization deleted successfully.');
    }
}