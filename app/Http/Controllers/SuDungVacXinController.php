<?php

namespace App\Http\Controllers;

use App\Models\SuDungVacXin;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class SuDungVacXinController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:DlBv106x-edit', ['only' => ['index','edit','update','create','store','show','changeStatus']]);
        $this->middleware('permission:DlBv106x-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sudungvacxin = SuDungVacXin::latest()->take(1000)->get();

        return view('pages.sudungvacxin.index', compact('sudungvacxin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.sudungvacxin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:mysql.sudung_vacxins,name',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
        ],
        [
            'name' => 'Tên thời hạn sử dụng vắc xin'
        ]);
        $input = $request->all();
        $input['status'] = 1;
        $input['slug'] = SlugService::createSlug(SuDungVacXin::class, 'slug', $input['name']);
        SuDungVacXin::create($input);

        return redirect()->route('su-dung-vac-xin.index')
            ->with('success', 'Tạo thời hạn sử dụng vắc xin thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuDungVacXin  $suDungVacXin
     * @return \Illuminate\Http\Response
     */
    public function show(SuDungVacXin $suDungVacXin)
    {
        return view('pages.sudungvacxin.show',compact('suDungVacXin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuDungVacXin  $suDungVacXin
     * @return \Illuminate\Http\Response
     */
    public function edit(SuDungVacXin $suDungVacXin)
    {
        return view('pages.sudungvacxin.edit',compact('suDungVacXin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SuDungVacXin  $suDungVacXin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SuDungVacXin $suDungVacXin)
    {
        $request->validate([
            'name' => 'required|unique:mysql.sudung_vacxins,name,'.$suDungVacXin->id,
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
        ],
        [
            'name' => 'Tên thời hạn sử dụng vắc xin'
        ]);
        $input = $request->all();
        
        $input['slug'] = SlugService::createSlug(SuDungVacXin::class, 'slug', $input['name']);
        $suDungVacXin->update($input);

        return redirect()->route('su-dung-vac-xin.index')
            ->with('success', 'Sữa thời hạn sử dụng vắc xin thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuDungVacXin  $suDungVacXin
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuDungVacXin $suDungVacXin)
    {
        if(!($suDungVacXin->VacXin)->isEmpty() )
        {
            return redirect()->back()
            ->with('error', 'Dữ liệu trong thời hạn sử dụng vắc xin vẫn còn.');            
        }

        $suDungVacXin->delete();
        return redirect()->route('su-dung-vac-xin.index')
            ->with('success', 'Deleted successfully');
    }
    public function changeStatus(Request $request)
    {
        $sudungvacxin = SuDungVacXin::find($request->id);
        $sudungvacxin->status = $request->status;
        $sudungvacxin->save();
  
        return response()->json(['success'=>'Status! change successfully.']);
    }
}
