<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request) : JsonResponse
    {

        $section = Section::query()
            ->when($request->type, fn($query) => $query->where('type', $request->type))
            ->firstOrFail();

        return response()->json(new SectionResource($section));

    }
}
