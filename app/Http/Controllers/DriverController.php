<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::orderBy('name')->get();
        return view('transport.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('transport.drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'license_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Driver::create($request->only('name', 'phone', 'license_number', 'status'));

        return redirect()->route('transport.drivers.index')->with('success', 'Driver created.');
    }

    public function edit(Driver $driver)
    {
        return view('transport.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'license_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $driver->update($request->only('name', 'phone', 'license_number', 'status'));

        return redirect()->route('transport.drivers.index')->with('success', 'Driver updated.');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('transport.drivers.index')->with('success', 'Driver deleted.');
    }
}
