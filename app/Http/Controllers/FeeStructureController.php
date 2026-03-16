<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\FeeType;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feeStructures = FeeStructure::with(['schoolClass', 'feeType'])
            ->orderBy('school_class_id')
            ->orderBy('fee_type_id')
            ->get();

        return view('fees.structures.index', compact('feeStructures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::orderBy('numeric_value')->get();
        $feeTypes = FeeType::all();

        return view('fees.structures.create', compact('classes', 'feeTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
            'academic_year' => 'nullable|string',
            'frequency' => 'required|integer|in:0,1,2,3',
        ]);

        // Check for duplicate
        $exists = FeeStructure::where('school_class_id', $request->school_class_id)
            ->where('fee_type_id', $request->fee_type_id)
            ->where('academic_year', $request->academic_year)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['error' => 'Fee structure for this class, fee type and year already exists.']);
        }

        FeeStructure::create($request->all());

        return redirect()->route('fee-structures.index')->with('success', 'Fee Structure added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeStructure $feeStructure)
    {
        $classes = SchoolClass::orderBy('numeric_value')->get();
        $feeTypes = FeeType::all();

        return view('fees.structures.edit', compact('feeStructure', 'classes', 'feeTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeeStructure $feeStructure)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
            'academic_year' => 'nullable|string',
            'frequency' => 'required|integer|in:0,1,2,3',
        ]);

        // Check for duplicate (excluding current)
        $exists = FeeStructure::where('school_class_id', $request->school_class_id)
            ->where('fee_type_id', $request->fee_type_id)
            ->where('academic_year', $request->academic_year)
            ->where('id', '!=', $feeStructure->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['error' => 'Fee structure already exists.']);
        }

        $feeStructure->update($request->all());

        return redirect()->route('fee-structures.index')->with('success', 'Fee Structure updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->delete();

        return redirect()->route('fee-structures.index')->with('success', 'Fee Structure deleted successfully.');
    }
}
