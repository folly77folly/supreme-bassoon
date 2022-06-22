<?php

namespace App\Http\Controllers;

use Throwable;
use App\Service\ApiResponseService;
use Illuminate\Support\Facades\Log;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    Public static $uncaughtErrorMessage = 'Something went wrong';

    public function __construct(ApiResponseService $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    public function logError(Throwable $th, $functionName){
        Log::critical($th->getMessage());
        Log::critical($th->getFile());
        Log::critical($th->getLine());
        Log::critical($functionName);
        Bugsnag::notifyException($th);
    }
}
