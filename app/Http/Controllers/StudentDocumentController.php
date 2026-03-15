<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    public function index(Request $request)
    {
        $studentId = $request->get('student_id');

        $students = Student::orderBy('first_name')->orderBy('last_name')->get();

        $documents = StudentDocument::with(['student'])
            ->when($studentId, fn ($q) => $q->where('student_id', $studentId))
            ->orderByDesc('id')
            ->get();

        return view('student-documents.index', compact('students', 'documents', 'studentId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:5120'],
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $file = $request->file('file');

        $path = $file->store("student-documents/{$student->id}", 'public');

        StudentDocument::create([
            'student_id' => $student->id,
            'title' => $validated['title'] ?? null,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size_bytes' => $file->getSize() ?: 0,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('student-documents.index', ['student_id' => $student->id])
            ->with('success', 'Document uploaded successfully.');
    }

    public function download(StudentDocument $studentDocument)
    {
        return Storage::disk('public')->download($studentDocument->file_path, $studentDocument->file_name);
    }

    public function destroy(StudentDocument $studentDocument)
    {
        Storage::disk('public')->delete($studentDocument->file_path);
        $studentDocument->delete();

        return redirect()->route('student-documents.index', ['student_id' => $studentDocument->student_id])
            ->with('success', 'Document deleted successfully.');
    }
}
