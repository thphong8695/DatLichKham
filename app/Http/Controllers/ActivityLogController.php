<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\DatLichKham;
class ActivityLogController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:DlBv106x-edit', ['only' => ['index','edit','update','create','store','show']]);
        $this->middleware('permission:DlBv106x-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $datlichkham = DatLichKham::all()->last();
        // $logs = Activity::forSubject($datlichkham)->get();
        $logs = Activity::orderBy('id','DESC')->paginate(20);
        // foreach(array_diff($logs->last()->changes()['old'],$logs->last()->changes()['attributes']) as $key => $value)
        // {
        //     dd($value);
        // } 
        // dd($logs->last()->changes());
        if( empty($request->has( $request->all() )) )
        {
            
            $query = Activity::orderBy('id','DESC');
            $description = $request->description;
            if(isset($description))
            {
                $query = $query->where("description",'like','%'.$description.'%');
            }
            $description = $request->description;
            if(isset($description))
            {
                $query = $query->where("description",'like','%'.$description.'%');
            }
            $subject_type = $request->subject_type;
            if(isset($subject_type))
            {
                $query = $query->where("subject_type",'like','%'.$subject_type.'%');
            }
            $logs = $query->paginate(20);
            $querystringArray = $request->only(['_token','description','subject_type']);
            $logs->appends($querystringArray);
        }
        // dd($logs);
        return view('pages.activity-log.index',compact('logs'));
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
        //
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
