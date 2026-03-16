<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\TransportRoute;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with(['driver', 'route'])->orderBy('registration_number')->get();

        return view('transport.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $drivers = Driver::orderBy('name')->get();
        $routes = TransportRoute::orderBy('name')->get();

        return view('transport.vehicles.create', compact('drivers', 'routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_number' => ['required', 'string', 'max:255', 'unique:vehicles,registration_number'],
            'model' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:0'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'transport_route_id' => ['nullable', 'exists:transport_routes,id'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Vehicle::create($request->only('registration_number', 'model', 'capacity', 'driver_id', 'transport_route_id', 'status'));

        return redirect()->route('transport.vehicles.index')->with('success', 'Vehicle created.');
    }

    public function edit(Vehicle $vehicle)
    {
        $drivers = Driver::orderBy('name')->get();
        $routes = TransportRoute::orderBy('name')->get();

        return view('transport.vehicles.edit', compact('vehicle', 'drivers', 'routes'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'registration_number' => ['required', 'string', 'max:255', 'unique:vehicles,registration_number,'.$vehicle->id],
            'model' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:0'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'transport_route_id' => ['nullable', 'exists:transport_routes,id'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $vehicle->update($request->only('registration_number', 'model', 'capacity', 'driver_id', 'transport_route_id', 'status'));

        return redirect()->route('transport.vehicles.index')->with('success', 'Vehicle updated.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('transport.vehicles.index')->with('success', 'Vehicle deleted.');
    }
}
