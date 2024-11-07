<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WipMaster;
use App\Http\Resources\WipMasterResource;

class ScoreBoardController extends Controller
{
    public function get_job($job){
        $job = WipMaster::where('Job',str_pad(trim($job), 15, '0', STR_PAD_LEFT))->first();
        if(empty($job)){
            $job_post = (object)array(
                'Job'=> 'empty',
                'StockCode' => 'empty',
                'StockDescription' => 'empty',
            );
            return response()->json([
                'job' => new WipMasterResource($job_post),
                'message' => 'JOB LOADED'
            ], 404);
        }
        else{
            return response()->json([
                'job' => new WipMasterResource($job),
                'message' => 'JOB LOADED'
            ], 200);
        }
        
    }
}
