<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentTransport;
use App\Models\TransportRoute;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class StudentTransportController extends Controller
{
    public function index()
    {
        $assignments = StudentTransport::with(['student', 'route', 'vehicle'])->orderByDesc('created_at')->paginate(20);
        return view('transport.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $students = Student::orderBy('first_name')->get();
        $routes = TransportRoute::where('status', 'active')->orderBy('name')->get();
        $vehicles = Vehicle::where('status', 'active')->orderBy('registration_number')->get();
        return view('transport.assignments.create', compact('students', 'routes', 'vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'transport_route_id' => ['required', 'exists:transport_routes,id'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'pickup_point' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        StudentTransport::create($request->only('student_id', 'transport_route_id', 'vehicle_id', 'pickup_point', 'start_date', 'status'));

        return redirect()->route('transport.assignments.index')->with('success', 'Student transport assigned.');
    }

    public function destroy(StudentTransport $studentTransport)
    {
        $studentTransport->delete();
        return redirect()->route('transport.assignments.index')->with('success', 'Assignment removed.');
    }
}

