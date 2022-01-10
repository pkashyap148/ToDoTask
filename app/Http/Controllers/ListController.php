<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use DB;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     die("here");
    // }

    

    public function index()
    {
        //$tasks = DB::selectRaw("select task_id,task_name,DATE_FORMAT('created', '%d/%m/%Y') from tasks where isActive='1'");
        //$tasks = tasks::all();
        //$tasks = DB::table('tasks')->select('task_id','task_name','DATE_FORMAT(created, "%d/%m/%Y")')->where('isActive','1')->get();
        $tasks = DB::table('tasks')
                     ->select(DB::raw('task_id,task_name,created,status'))
                     ->where('isActive', '=', '1')
                     ->get();
        return view('list.index')->with('tasks',$tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         $x = $request->get('task_name');
         //print_r(html_entity_decode($x));
         
         //return response()->json($x);
        $add = new Task;
        $add->task_name = $request->task_name;
        $add->save();
        $tasks = DB::table('tasks')
                     ->select(DB::raw('task_id,task_name,created,status'))
                     ->where('isActive', '=', '1')
                     ->get();
        return $tasks;
        //return response()->json(['success'=>'success']);
        //return view('list.index');
        //return $request->all();
        //return true;*/
    }

    public function delete(Request $del){
        $task_id = $del->get('task_id');
        $delete_task = DB::table('tasks')
                           ->where('task_id',$task_id)
                           ->update(['isActive'=>'0', 'isDelete'=>'1']);
        $tasks = DB::table('tasks')
                           ->select(DB::raw('task_id,task_name,created,status'))
                           ->where('isActive', '=', '1')
                           ->get();
        return $tasks;
        
    }

    public function editTask($id, $newTask){
        $update_task = DB::table('tasks')
            ->where('task_id', $id)
            ->update(['task_name' => $newTask]);
        $tasks = DB::table('tasks')
            ->select(DB::raw('task_id,task_name,created,status'))
            ->where('isActive', '=', '1')
            ->get();
        return $tasks;
    }

    public function status($id, $status){
        $status = DB::table('tasks')
            ->where('task_id', $id)
            ->update(['status' => $status]);
        $tasks = DB::table('tasks')
            ->select(DB::raw('task_id,task_name,created,status'))
            ->where('isActive', '=', '1')
            ->get();
        return $tasks;
    }

    public function priority($id, $priority){
        $prior_task = DB::table('tasks')
            ->where('task_id', $id)
            ->update(['prority' => $priority]);
        $tasks = DB::table('tasks')
            ->select(DB::raw('task_id,task_name,created,status,prority'))
            ->where('isActive', '=', '1')
            ->get();
        return $tasks;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
}
