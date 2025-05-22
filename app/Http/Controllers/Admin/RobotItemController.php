<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Robot;
use App\Models\RobotItem;
use Illuminate\Http\Request;

class RobotItemController extends Controller
{
    public function index(Robot $robot)
    {
        $robot_items = $robot->items()->paginate(10); // Əgər əlaqə "items" adlanırsa
        return view('admin.robot_items.index', compact('robot', 'robot_items'));
    }

    public function create(Robot $robot)
    {
        return view('admin.robot_items.create', compact('robot'));
    }

    public function store(Request $request, Robot $robot)
    {
        $request->validate([
            'az_title'=>'required',
            'en_title'=>'required',
            'ru_title'=>'required',
            'az_description'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);

        $robot->items()->create([
            'az' => [
                'title' => $request->az_title,
                'description' => $request->az_description,
            ],
            'en' => [
                'title' => $request->en_title,
                'description' => $request->en_description,
            ],
            'ru' => [
                'title' => $request->ru_title,
                'description' => $request->ru_description,
            ],
        ]);

        return redirect()->route('robots.robot_items.index', $robot)->with('message', 'RobotItem added successfully');
    }

    public function show(Robot $robot, RobotItem $robot_item)
    {
        // Optional
    }

    public function edit(Robot $robot, RobotItem $robot_item)
    {
        return view('admin.robot_items.edit', compact('robot', 'robot_item'));
    }

    public function update(Request $request, Robot $robot, RobotItem $robot_item)
    {
        $request->validate([
            'az_title'=>'required',
            'en_title'=>'required',
            'ru_title'=>'required',
            'az_description'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);

        $robot_item->update([
            'is_active' => $request->is_active,
            'az' => [
                'title' => $request->az_title,
                'description' => $request->az_description,
            ],
            'en' => [
                'title' => $request->en_title,
                'description' => $request->en_description,
            ],
            'ru' => [
                'title' => $request->ru_title,
                'description' => $request->ru_description,
            ],
        ]);

        return redirect()->back()->with('message', 'RobotItem updated successfully');
    }

    public function destroy(Robot $robot, RobotItem $robot_item)
    {
        $robot_item->delete();
        return redirect()->route('robots.robot_items.index', $robot)->with('message', 'RobotItem deleted successfully');
    }
}
