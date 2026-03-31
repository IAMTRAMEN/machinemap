<?php
// app/Http/Controllers/Admin/RelationshipController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationRelationship;
use App\Models\RelationshipType;
use App\Models\Organization;
use App\Models\RelationshipInteraction;
use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    public function index(Request $request)
    {
        $query = OrganizationRelationship::with(['fromOrganization', 'toOrganization', 'type']);
        
        if ($request->has('type')) {
            $query->whereHas('type', function($q) use ($request) {
                $q->where('category', $request->type);
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $relationships = $query->latest()->paginate(20);

        return view('admin.relationships.index', compact('relationships'));
    }

    public function create()
    {
        // TEMPORARY FIX: Remove ->active() scope
        $organizations = Organization::get(); // Remove ->active()
        $relationshipTypes = RelationshipType::where('active', true)->get();
        
        return view('admin.relationships.create', compact('organizations', 'relationshipTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_organization_id' => 'required|exists:organizations,id',
            'to_organization_id' => 'required|exists:organizations,id|different:from_organization_id',
            'relationship_type_id' => 'required|exists:relationship_types,id',
            'description' => 'nullable|string',
            'relationship_start' => 'required|date',
            'status' => 'required|in:active,inactive,pending,suspended'
        ]);

        $existing = OrganizationRelationship::where([
            'from_organization_id' => $validated['from_organization_id'],
            'to_organization_id' => $validated['to_organization_id'],
            'relationship_type_id' => $validated['relationship_type_id']
        ])->exists();

        if ($existing) {
            return back()->withErrors(['relationship' => 'This relationship already exists.']);
        }

        OrganizationRelationship::create($validated);

        return redirect()->route('admin.relationships.index')
            ->with('success', 'Relationship created successfully.');
    }

    public function show(OrganizationRelationship $relationship)
    {
        $relationship->load([
            'fromOrganization', 
            'toOrganization', 
            'type',
            'interactions.user'
        ]);

        return view('admin.relationships.show', compact('relationship'));
    }

    // Add the missing methods
    public function edit(OrganizationRelationship $relationship)
    {
        $organizations = Organization::active()->get();
        $relationshipTypes = RelationshipType::active()->get();
        
        return view('admin.relationships.edit', compact('relationship', 'organizations', 'relationshipTypes'));
    }

    public function update(Request $request, OrganizationRelationship $relationship)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending,suspended'
        ]);

        $relationship->update($validated);

        return redirect()->route('admin.relationships.show', $relationship)
            ->with('success', 'Relationship updated successfully.');
    }

    public function destroy(OrganizationRelationship $relationship)
    {
        $relationship->delete();
        return redirect()->route('admin.relationships.index')
            ->with('success', 'Relationship deleted successfully.');
    }

    public function createInteraction(OrganizationRelationship $relationship)
    {
        return view('admin.relationships.interactions.create', compact('relationship'));
    }

    public function storeInteraction(Request $request, OrganizationRelationship $relationship)
    {
        $validated = $request->validate([
            'interaction_type' => 'required|string',
            'subject' => 'required|string',
            'description' => 'required|string',
            'interaction_date' => 'required|date'
        ]);

        RelationshipInteraction::create([
            ...$validated,
            'user_id' => auth()->id(),
            'organization_relationship_id' => $relationship->id
        ]);

        return redirect()->route('admin.relationships.show', $relationship)
            ->with('success', 'Interaction logged successfully.');
    }

    public function providers()
    {
        $providers = Organization::whereHas('outgoingRelationships', function($query) {
            $query->whereHas('type', function($q) {
                $q->where('category', 'provider');
            });
        })->with(['outgoingRelationships.type'])->paginate(20);

        return view('admin.providers.index', compact('providers'));
    }

    public function partners()
    {
        $partners = Organization::whereHas('outgoingRelationships', function($query) {
            $query->whereHas('type', function($q) {
                $q->where('category', 'partner');
            });
        })->with(['outgoingRelationships.type'])->paginate(20);

        return view('admin.partners.index', compact('partners'));
    }
}