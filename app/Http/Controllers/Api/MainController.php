<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainContentResource;
use App\Http\Resources\MainResource;
use App\Models\AppContent;
use App\Models\AppMain;
use App\Models\MagicalWord;
use App\Models\Main;
use App\Models\QuestionMain;
use App\Models\RobotIoMain;
use App\Models\RobotMain;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Js;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
class MainController extends Controller
{

    public function hero() : JsonResponse
    {
        $main = Main::query()->with('products')->firstOrFail();
        return response()->json(new MainResource($main));
    }

    public function app_main(): JsonResponse
    {
        $app_main = AppMain::query()->active()->first();
        return response()->json(new MainContentResource($app_main), ResponseAlias::HTTP_OK);
    }

    public function robot_main(): JsonResponse
    {
        $robot_main = RobotMain::query()->active()->first();
        return response()->json(new MainContentResource($robot_main), ResponseAlias::HTTP_OK);
    }

    public function robot_os_main(): JsonResponse
    {
        $robot_os_main = RobotIoMain::query()->active()->first();
        return response()->json(new MainContentResource($robot_os_main), ResponseAlias::HTTP_OK);
    }

    public function question_main(): JsonResponse
    {
        $question_main = QuestionMain::query()->active()->first();
        return response()->json(new MainContentResource($question_main), ResponseAlias::HTTP_OK);
    }

    public function app_content(): JsonResponse
    {
        $app_content = AppContent::query()->active()->first();
        return response()->json(new MainContentResource($app_content), ResponseAlias::HTTP_OK);
    }

    public function magical_word(): JsonResponse
    {
        $magical_word = MagicalWord::query()->active()->first();
        return response()->json(new MainContentResource($magical_word), ResponseAlias::HTTP_OK);
    }

}
