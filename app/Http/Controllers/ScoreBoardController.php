<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WipMaster;
use App\Http\Resources\WipMasterResource;

class ScoreBoardController extends Controller
{
    public function get_job($job){
        $job = WipMaster::where('Job',str_pad(trim($job), 15, '0', STR_PAD_LEFT))->first();
        
        return response()->json([
            'job' => new WipMasterResource($job),
            'message' => 'JOB LOADED'
        ], 200);
    }
}
