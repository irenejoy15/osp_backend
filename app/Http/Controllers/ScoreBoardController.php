<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WipMaster;
use App\Http\Resources\WipMasterResource;
use App\Http\Resources\ActualResource;

use App\Models\Encode;
use App\Models\ActualTarget;
use Uuid;
use Carbon\Carbon;
class ScoreBoardController extends Controller
{   
    public function current(){
        $date = Carbon::now()->format('Y-m-d');
        $jobs = Encode::whereDate('date',$date)->get('job');
        return response()->json([
            'curentJobs'=>$jobs,
            'currentDate' => $date,
        ], 200);
    }

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
                'message' => 'JOB IS EMPTY'
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

    public function encode_target(Request $request){
        $id = Uuid::generate(4);
        $encodeId = $request->input('id');
        $targetActual = $request->input('targetActual');
        $lineActual = $request->input('lineActual');
        $dateActual = $request->input('dateActual');
        $timeDropDown = $request->input('timeDropDown');

        $data = array(
            'id'=>$id,
            'encodeId'=>$encodeId,
            'targetActual'=>$targetActual,
            'lineActual'=>$lineActual,
            'dateActual'=>$dateActual,
            'timeDropDown'=>$timeDropDown
        );

        ActualTarget::create($data);

        return response()->json([
            'actual'=>$data,
            'message' => 'ACTUAL SUCCESSFULLY CREATED'
        ], 200);
    }

    public function get_encode($id){
        $encode = Encode::where('id',$id)->first();
        return response()->json([
            'job'=>$encode,
            'message' => 'DATA SUCCESSFULLY LOADED'
        ], 200);
    }

    public function get_encode_date($job,$date){
        $encode_row = Encode::where('job',$job)->whereDate('date',$date)->first();
        if(!empty($encode_row)):
            return response()->json([
                'job'=>$encode_row,
                'message' => 'DATA SUCCESSFULLY CREATED'
            ], 200);
        else:
            return response()->json([
                'job'=>'',
                'message' => 'DATA SUCCESSFULLY CREATED'
            ], 500);
        endif;
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

    public function actual_targets(Request $request){
        $pageSize = $request->get('pagesize');
        $currentPage = $request->get('page');
        $date = $request->get('date');
        $actual_query = ActualTarget::query();
        
        if($pageSize && $currentPage):
            $skip = $pageSize * ($currentPage-1);
        endif;

        if(empty($date)||$date == 'null'):
            $actual_targets = $actual_query->skip($skip)->limit($pageSize)->orderBy('created_at','DESC')->orderBy('id','ASC')->get();
            $count =  ActualTarget::count();
        else:
         
            $actual_targets = $actual_query->whereDate('dateActual',$date)->skip($skip)->limit($pageSize)->orderBy('created_at','DESC')->orderBy('id','ASC')->get();
            $count =  ActualTarget::whereDate('dateActual', $date)->count();
        endif;

        return response()->json([
            'actualJobs' => ActualResource::collection($actual_targets),
            'message' => 'LIST LOADED',
            'maxPosts'=>$count
        ], 200);
    }

    public function edit_target($id){
        $query = ActualTarget::where('id',$id)->first();
        return response()->json([
            'actualJob'=>new ActualResource($query),
            'message' => 'DATA SUCCESSFULLY CREATED'
        ], 200);
    }

    public function update_target(Request $request){
        $id = $request->input('id');
        $targetActual = $request->input('targetActual');
        $lineActual = $request->input('lineActual');
        $timeDropDown = $request->input('timeDropDown');

        $data = array(
            'targetActual'=>$targetActual,
            'lineActual'=>$lineActual,
            'timeDropDown'=>$timeDropDown
        );

        ActualTarget::where('id',$id)->update($data);

        return response()->json([
            'actual'=>$data,
            'message' => 'ACTUAL SUCCESSFULLY CREATED'
        ], 200);
    }

    public function target_delete($id){
        ActualTarget::where('id',$id)->delete();
        return response()->json([
            'message' => 'DATA SUCCESSFULLY DELETED'
        ], 200);
    }

    public function today_combine_line(){
        $date = Carbon::now()->format('Y-m-d');

        $actual_line_a = Encode::whereDate('date',$date)->where('line','a')->sum('targetinPcs');
        $actual_line_b = Encode::whereDate('date',$date)->where('line','b')->sum('targetinPcs');

        $actual_target_a = ActualTarget::whereDate('dateActual',$date)->where('lineActual','a')->sum('targetActual');
        $actual_target_b = ActualTarget::whereDate('dateActual',$date)->where('lineActual','b')->sum('targetActual');

        $gap_a = $actual_target_a - $actual_line_a;
        $gap_b = $actual_target_b - $actual_line_b;
        $jobs_a = Encode::select('job','stockCode')->where('line','a')->whereDate('date',$date)->get();

        $jobs_b = Encode::select('job','stockCode')->where('line','b')->whereDate('date',$date)->get();

        return response()->json([
            'actualLineA' => $actual_line_a,
            'actualLineB' => $actual_line_b,
            'actualTargetA'=>$actual_target_a,
            'actualTargetB'=>$actual_target_b,
            'gapA'=>$gap_a,
            'gapB'=>$gap_b,
            'monitorJobsA'=>$jobs_a,
            'monitorJobsB'=>$jobs_b
        ], 200);
    }

    public function today_line_a(){
        $date = Carbon::now()->format('Y-m-d');

        $actual_line_a = Encode::whereDate('date',$date)->where('line','a')->sum('targetinPcs');
        
        $actual_target_a = ActualTarget::whereDate('dateActual',$date)->where('lineActual','a')->sum('targetActual');
        

        $gap_a = $actual_target_a - $actual_line_a;
      
        $jobs_a = Encode::select('job','stockCode')->where('line','a')->whereDate('date',$date)->get();

        return response()->json([
            'actualLineA' => $actual_line_a,
            'actualTargetA'=>$actual_target_a,
            'gapA'=>$gap_a,
            'monitorJobsA'=>$jobs_a,
        ], 200);
    }

    public function today_line_b(){
        $date = Carbon::now()->format('Y-m-d');

        $actual_line_b = Encode::whereDate('date',$date)->where('line','b')->sum('targetinPcs');

        $actual_target_b = ActualTarget::whereDate('dateActual',$date)->where('lineActual','b')->sum('targetActual');

        $gap_b = $actual_target_b - $actual_line_b;
        
        $jobs_b = Encode::select('job','stockCode')->where('line','b')->whereDate('date',$date)->get();

        return response()->json([
            'actualLineB' => $actual_line_b,
            'actualTargetB'=>$actual_target_b,
            'gapB'=>$gap_b,
            'monitorJobsB'=>$jobs_b
        ], 200);
    }

}
