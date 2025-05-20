<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Map;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $maps = Map::paginate(10);
        return view('admin.maps.index', compact('maps'));
    }

    public function create()
    {
        return view('admin.maps.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'map' => 'required',
        ]);

        Map::create([
            'map' => $request->map,
        ]);

        return redirect()->route('maps.index')->with('message', 'Map added successfully');

    }

    public function show(Map $map)
    {
        //
    }

    public function edit(Map $map)
    {
        return view('admin.maps.edit', compact('map'));
    }


    public function update(Request $request, Map $map)
    {
        $request->validate([
            'map' => 'required',
        ]);


        $map->update([
            'map' => $request->map,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('message', 'Map updated successfully');
    }

    public function destroy(Map $map)
    {
        $map->delete();
        return redirect()->route('maps.index')->with('message', 'Map deleted successfully');
    }
}
