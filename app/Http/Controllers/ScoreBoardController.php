<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WipMaster;
use App\Http\Resources\WipMasterResource;
use App\Models\Encode;
use Uuid;
use Carbon\Carbon;
class ScoreBoardController extends Controller
{
    public function targets(Request $request){
        $pageSize = $request->get('pagesize');
        $currentPage = $request->get('page');
        $date = $request->get('date');
        $encode_query = Encode::query();
        
        if($pageSize && $currentPage):
            $skip = $pageSize * ($currentPage-1);
        endif;

        if(empty($date)||$date == 'null'):
            $encodes = $encode_query->skip($skip)->limit($pageSize)->get();
            $count =  Encode::count();
        else:
         
            $encodes = $encode_query->whereDate('date',$date)->skip($skip)->limit($pageSize)->get();
            $count =  Encode::whereDate('date', $date)->count();
        endif;

        return response()->json([
            'jobs' => $encodes,
            'message' => 'LIST LOADED',
            'maxPosts'=>$count
        ], 200);
    }

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

    public function encode(Request $request){
        $id = Uuid::generate(4);
        $job_number = $request->input('job_number');
        $stockCode = $request->input('stockCode');
        $stockDescription = $request->input('stockDescription');
        $targetInPcs = $request->input('targetInPcs');
        $line = $request->input('line');
        $date = $request->input('date');

        $data = array(
            'id'=>$id,
            'job'=>$job_number,
            'stockCode'=>$stockCode,
            'stockDescription'=>$stockDescription,
            'targetInPcs'=>$targetInPcs,
            'line'=>$line,
            'date'=>$date
        );
        Encode::create($data);
        return response()->json([
            'job'=>$data,
            'message' => 'DATA SUCCESSFULLY CREATED'
        ], 200);
    }

    public function get_encode($id){
        $encode = Encode::where('id',$id)->first();
        return response()->json([
            'job'=>$encode,
            'message' => 'DATA SUCCESSFULLY CREATED'
        ], 200);
    }

    public function encode_update(Request $request){
        $id= $request->input('id');
        $targetInPcs = $request->input('targetInPcs');
        $line = $request->input('line');
        $date = $request->input('date');
        
        $data = array(
            'targetInPcs'=>$targetInPcs,
            'line'=>$line,
            'date'=>$date
        );
        Encode::where('id',$id)->update($data);
        return response()->json([
            'job'=>$data,
            'message' => 'DATA SUCCESSFULLY UPDATED'
        ], 200);
    }

    public function encode_delete($id){
        Encode::where('id',$id)->delete();
        return response()->json([
            'message' => 'DATA SUCCESSFULLY DELETED'
        ], 200);
    }
}
