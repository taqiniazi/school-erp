<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentPromotionController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::orderBy('numeric_value')->orderBy('name')->get();

        return view('student-promotions.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_school_class_id' => ['required', 'exists:school_classes,id'],
            'from_section_id' => ['nullable', 'exists:sections,id'],
            'to_school_class_id' => ['required', 'exists:school_classes,id'],
            'to_section_id' => ['required', 'exists:sections,id'],
        ]);

        if (! empty($validated['from_section_id'])) {
            $fromSection = Section::findOrFail($validated['from_section_id']);
            if ((int) $fromSection->school_class_id !== (int) $validated['from_school_class_id']) {
                return redirect()->back()->with('error', 'From section does not belong to the selected class.');
            }
        }

        $toSection = Section::findOrFail($validated['to_section_id']);
        if ((int) $toSection->school_class_id !== (int) $validated['to_school_class_id']) {
            return redirect()->back()->with('error', 'To section does not belong to the selected class.');
        }

        $query = Student::where('school_class_id', $validated['from_school_class_id']);
        if (! empty($validated['from_section_id'])) {
            $query->where('section_id', $validated['from_section_id']);
        }

        $count = (int) $query->count();
        if ($count <= 0) {
            return redirect()->back()->with('error', 'No students found for the selected class/section.');
        }

        DB::transaction(function () use ($validated, $query) {
            $query->update([
                'school_class_id' => $validated['to_school_class_id'],
                'section_id' => $validated['to_section_id'],
            ]);
        });

        return redirect()->route('student-promotions.index')->with('success', "{$count} students promoted successfully.");
    }
}
