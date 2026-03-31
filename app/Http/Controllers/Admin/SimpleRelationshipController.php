<?php
// app/Http/Controllers/Admin/SimpleRelationshipController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimpleRelationship;
use Illuminate\Http\Request;

class SimpleRelationshipController extends Controller
{
    public function index(Request $request)
    {
        $query = SimpleRelationship::query();

        // Filter by relationship type
        if ($request->has('type') && in_array($request->type, ['customer', 'provider', 'partner', 'other'])) {
            $query->where('relationship_type', $request->type);
        }

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['active', 'inactive', 'pending'])) {
            $query->where('status', $request->status);
        }

        $relationships = $query->latest()->paginate(20);

        return view('admin.relationships.index', compact('relationships'));
    }

    public function create()
    {
        return view('admin.relationships.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'relationship_type' => 'required|in:customer,provider,partner,other',
            'status' => 'required|in:active,inactive,pending',
            'description' => 'nullable|string'
        ]);

        SimpleRelationship::create($validated);

        return redirect()->route('admin.relationships.index')
            ->with('success', 'Relationship created successfully.');
    }

    public function show(SimpleRelationship $simpleRelationship)
    {
        return view('admin.relationships.show', compact('simpleRelationship'));
    }

    public function edit(SimpleRelationship $simpleRelationship)
    {
        return view('admin.relationships.edit', compact('simpleRelationship'));
    }

    public function update(Request $request, SimpleRelationship $simpleRelationship)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'relationship_type' => 'required|in:customer,provider,partner,other',
            'status' => 'required|in:active,inactive,pending',
            'description' => 'nullable|string'
        ]);

        $simpleRelationship->update($validated);

        return redirect()->route('admin.simple-relationships.show', $simpleRelationship)
            ->with('success', 'Relationship updated successfully.');
    }

    public function destroy(SimpleRelationship $simpleRelationship)
    {
        $simpleRelationship->delete();

        return redirect()->route('admin.simple-relationships.index')
            ->with('success', 'Relationship deleted successfully.');
    }
}