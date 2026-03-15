<?php

namespace App\Http\Controllers;

use App\Models\TransportRoute;
use Illuminate\Http\Request;

class TransportRouteController extends Controller
{
    public function index()
    {
        $routes = TransportRoute::orderBy('name')->get();
        return view('transport.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('transport.routes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_point' => ['nullable', 'string', 'max:255'],
            'end_point' => ['nullable', 'string', 'max:255'],
            'fare' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        TransportRoute::create($request->only('name', 'start_point', 'end_point', 'fare', 'status'));

        return redirect()->route('transport.routes.index')->with('success', 'Route created.');
    }

    public function edit(TransportRoute $transportRoute)
    {
        return view('transport.routes.edit', ['route' => $transportRoute]);
    }

    public function update(Request $request, TransportRoute $transportRoute)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_point' => ['nullable', 'string', 'max:255'],
            'end_point' => ['nullable', 'string', 'max:255'],
            'fare' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $transportRoute->update($request->only('name', 'start_point', 'end_point', 'fare', 'status'));

        return redirect()->route('transport.routes.index')->with('success', 'Route updated.');
    }

    public function destroy(TransportRoute $transportRoute)
    {
        $transportRoute->delete();
        return redirect()->route('transport.routes.index')->with('success', 'Route deleted.');
    }
}
