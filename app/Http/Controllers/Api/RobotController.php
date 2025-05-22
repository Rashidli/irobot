<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RobotAdvantageResource;
use App\Http\Resources\RobotResource;
use App\Models\Robot;
use App\Models\RobotAdvantage;
use Illuminate\Http\Request;

class RobotController extends Controller
{
    public function index()
    {
        $robots = Robot::query()->with('items')->active()->get();
        return response()->json(RobotResource::collection($robots));
    }

    public function robotAdvantages()
    {
        $robot_advantages = RobotAdvantage::query()->active()->get();
        return response()->json(RobotAdvantageResource::collection($robot_advantages));
    }
}
