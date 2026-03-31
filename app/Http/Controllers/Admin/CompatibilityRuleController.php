<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompatibilityRule;
use App\Models\Component;
use Illuminate\Http\Request;

class CompatibilityRuleController extends Controller
{
    public function index()
    {
        $rules = CompatibilityRule::with(['triggerComponent', 'targetComponent'])->get();
        return view('admin.rules.index', compact('rules'));
    }

    public function create()
    {
        $components = Component::where('active', true)->get();
        return view('admin.rules.create', compact('components'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'trigger_component_id' => 'required|exists:components,id',
            'operator' => 'required|in:requires,incompatible_with,recommends',
            'target_component_id' => 'required|exists:components,id',
            'error_message' => 'required',
        ]);

        CompatibilityRule::create($request->only([
            'name', 'description', 'trigger_component_id', 'operator', 
            'target_component_id', 'auto_select', 'block_configuration', 
            'error_message', 'success_message', 'active'
        ]));

        return redirect()->route('admin.rules.index')
                         ->with('success', 'Compatibility rule created successfully.');
    }

    // ADD THIS MISSING METHOD
    public function show(CompatibilityRule $rule)
    {
        $rule->load(['triggerComponent.category', 'targetComponent.category']);
        return view('admin.rules.show', compact('rule'));
    }

    public function edit(CompatibilityRule $rule)
    {
        $components = Component::where('active', true)->get();
        return view('admin.rules.edit', compact('rule', 'components'));
    }

    public function update(Request $request, CompatibilityRule $rule)
    {
        $request->validate([
            'name' => 'required',
            'trigger_component_id' => 'required|exists:components,id',
            'operator' => 'required|in:requires,incompatible_with,recommends',
            'target_component_id' => 'required|exists:components,id',
            'error_message' => 'required',
        ]);

        $rule->update($request->only([
            'name', 'description', 'trigger_component_id', 'operator', 
            'target_component_id', 'auto_select', 'block_configuration', 
            'error_message', 'success_message', 'active'
        ]));

        return redirect()->route('admin.rules.index')
                         ->with('success', 'Compatibility rule updated successfully.');
    }

    public function destroy(CompatibilityRule $rule)
    {
        $rule->delete();
        return redirect()->route('admin.rules.index')
                         ->with('success', 'Compatibility rule deleted successfully.');
    }
}