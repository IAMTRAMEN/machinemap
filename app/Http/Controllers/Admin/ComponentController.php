<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Models\Category;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function index()
    {
        $components = Component::with('category')->get();
        return view('admin.components.index', compact('components'));
    }

    public function create(Request $request)
    {
         $categories = Category::ordered()->get();
    $selectedCategory = $request->get('category_id');
    
    return view('admin.components.create', compact('categories', 'selectedCategory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:components',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'installation_time' => 'required|integer|min:0',
        ]);

        Component::create($request->only([
            'name', 'code', 'description', 'category_id', 'price', 'installation_time', 'active'
        ]));

        return redirect()->route('admin.components.index')
                         ->with('success', 'Component created successfully.');
    }

    // ADD THIS MISSING METHOD
    public function show(Component $component)
    {
        $component->load(['category', 'machines', 'triggerRules.triggerComponent', 'targetRules.targetComponent']);
        return view('admin.components.show', compact('component'));
    }

    public function edit(Component $component)
    {
        $categories = Category::all();
        return view('admin.components.edit', compact('component', 'categories'));
    }

    public function update(Request $request, Component $component)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:components,code,' . $component->id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'installation_time' => 'required|integer|min:0',
        ]);

        $component->update($request->only([
            'name', 'code', 'description', 'category_id', 'price', 'installation_time', 'active'
        ]));

        return redirect()->route('admin.components.index')
                         ->with('success', 'Component updated successfully.');
    }

    public function destroy(Component $component)
    {
        $component->delete();
        return redirect()->route('admin.components.index')
                         ->with('success', 'Component deleted successfully.');
    }
}