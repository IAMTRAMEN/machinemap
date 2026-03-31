<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\Component;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        $machines = Machine::withCount('components')->get();
        return view('admin.machines.index', compact('machines'));
    }

    public function create()
    {
        $components = Component::where('active', true)->get();
        return view('admin.machines.create', compact('components'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:machines',
            'display_name' => 'required',
            'description' => 'required',
            'base_price' => 'required|numeric|min:0',
        ]);

        $machine = Machine::create($request->only([
            'name', 'display_name', 'description', 'base_price', 'specifications', 'image_url', 'active'
        ]));

        // Attach compatible components
        if ($request->has('components')) {
            $components = [];
            foreach ($request->components as $componentId) {
                $components[$componentId] = ['compatible' => true];
            }
            $machine->components()->sync($components);
        }

        return redirect()->route('admin.machines.index')
                         ->with('success', 'Machine created successfully.');
    }

    // ADD THIS MISSING METHOD
    public function show(Machine $machine)
    {
        $machine->load(['components.category']);
        return view('admin.machines.show', compact('machine'));
    }

    public function edit(Machine $machine)
    {
        $components = Component::where('active', true)->get();
        $machine->load('components');
        return view('admin.machines.edit', compact('machine', 'components'));
    }

    public function update(Request $request, Machine $machine)
    {
        $request->validate([
            'name' => 'required|unique:machines,name,' . $machine->id,
            'display_name' => 'required',
            'description' => 'required',
            'base_price' => 'required|numeric|min:0',
        ]);

        $machine->update($request->only([
            'name', 'display_name', 'description', 'base_price', 'specifications', 'image_url', 'active'
        ]));

        // Sync components
        if ($request->has('components')) {
            $components = [];
            foreach ($request->components as $componentId) {
                $components[$componentId] = ['compatible' => true];
            }
            $machine->components()->sync($components);
        }

        return redirect()->route('admin.machines.index')
                         ->with('success', 'Machine updated successfully.');
    }

    public function destroy(Machine $machine)
    {
        $machine->delete();
        return redirect()->route('admin.machines.index')
                         ->with('success', 'Machine deleted successfully.');
    }
}