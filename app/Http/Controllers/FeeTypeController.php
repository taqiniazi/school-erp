<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feeTypes = FeeType::all();

        return view('fees.types.index', compact('feeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fees.types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fee_types',
            'description' => 'nullable|string|max:255',
        ]);

        FeeType::create($request->all());

        return redirect()->route('fee-types.index')->with('success', 'Fee Type created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeType $feeType)
    {
        return view('fees.types.edit', compact('feeType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeeType $feeType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fee_types,name,'.$feeType->id,
            'description' => 'nullable|string|max:255',
        ]);

        $feeType->update($request->all());

        return redirect()->route('fee-types.index')->with('success', 'Fee Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeeType $feeType)
    {
        $feeType->delete();

        return redirect()->route('fee-types.index')->with('success', 'Fee Type deleted successfully.');
    }
}
