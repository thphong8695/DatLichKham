<?php

namespace App\Http\Controllers;

use App\Models\TuyChinhNgayOff;
use App\Models\BenhVienPK;
use Illuminate\Http\Request;
use App\Repositories\EloquentRepository;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
class TuyChinhNgayOffController extends Controller
{
    protected $repository;
    function __construct(EloquentRepository $repository)
    {
        $this->middleware('auth');
        $this->middleware('permission:DlBv106x-edit', ['only' => ['index','edit','update','create','store','show','changeStatus']]);
        $this->middleware('permission:DlBv106x-delete', ['only' => ['destroy']]);
        $this->repository = $repository;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tuychinh_off = TuyChinhNgayOff::latest()->take(1000)->whereHas('BenhVienPK',function($q)
        {
            $q->where("status",1);
        })->get();
        if( empty($request->has( $request->all() )) )
        {
            
            $query = TuyChinhNgayOff::latest()->take(1000)->whereHas('BenhVienPK',function($q)
            {
                $q->where("status",1);
            });
            $bv = $request->input('bv');
            if(isset($bv)) 
            {
                $query = $query->whereHas('BenhVienPK',function($q) use($bv)
                {
                    $q->where("slug",$bv);
                });
            }
            $tuychinh_off = $query->get();
            // $querystringArray = $request->only(['_token,q']);
            // $chuyenkhoa->appends($querystringArray);   
        }
        $benhvien = $this->repository->getListBenhVienSlug();
        return view('pages.tuychinh-ngayoff.index', compact('tuychinh_off','benhvien'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $benhvien = $this->repository->getListBenhVienId();
        return view('pages.tuychinh-ngayoff.create',compact('benhvien'));
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
            'ngayoff' => 'date_format:d-m-Y|required',
            'benhvien_id' => ['required',Rule::unique('mysql.tuychinh_ngayoffs')->where(function ($query) use($request) {
                        return $query->where('ngayoff', Carbon::parse($request->ngayoff)->format('Y-m-d'))
                        ->where('benhvien_id', $request->benhvien_id);
                    }),
            ],
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => "Ngày off đã tồn tại!",
            'integer' => ":attribute phải là số!",
            'date' => ":attribute phải đúng định dạng ngày!",
            'max' => ":attribute không vượt quá :max!",
        ],
        [
            'ngayoff' => 'Ngày off',
            'benhvien_id' => 'Bệnh viện',
        ]);
        $input = $request->all();
        $input['ngayoff'] = Carbon::parse($request->ngayoff)->format('Y-m-d');
        $input['status'] = 1;
        TuyChinhNgayOff::create($input);

        return redirect()->route('tuychinh-ngayoff.index')
            ->with('success', 'Tạo khung giờ thành công.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tuychinh_off  $tuychinh_off
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tuychinhngayoff = TuyChinhNgayOff::find($id);
        return view('pages.tuychinh-ngayoff.show',compact('tuychinhngayoff'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tuychinhngayoff  $tuychinhngayoff
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tuychinhngayoff = TuyChinhNgayOff::find($id);
        $benhvien = $this->repository->getListBenhVienId();
        return view('pages.tuychinh-ngayoff.edit',compact('tuychinhngayoff','benhvien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tuychinhngayoff  $tuychinhngayoff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tuychinhngayoff = TuyChinhNgayOff::find($id);
        $request->validate([
            'ngayoff' => 'date_format:d-m-Y|required',
            // 'status' => 'required',
            'benhvien_id' => ['required',Rule::unique('mysql.tuychinh_ngayoffs')->where(function ($query) use($request) {
                        return $query->where('ngayoff', Carbon::parse($request->ngayoff)->format('Y-m-d'))
                        ->where('benhvien_id', $request->benhvien_id);
                    })->ignore($tuychinhngayoff->id),
            ],
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => "Ngày off đã tồn tại!",
            'integer' => ":attribute phải là số!",
            'date' => ":attribute phải đúng định dạng ngày!",
            'max' => ":attribute không vượt quá :max!",
        ],
        [
            'ngayoff' => 'Ngày off',
            'benhvien_id' => 'Bệnh viện',
        ]);
        $input = $request->all();
        $input['ngayoff'] = Carbon::parse($request->ngayoff)->format('Y-m-d');
        $tuychinhngayoff->update($input);

        return redirect()->route('tuychinh-ngayoff.index')
            ->with('success', 'Sửa khung giờ thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tuychinhngayoff  $tuychinhngayoff
     * @return \Illuminate\Http\Response
     */
    public function destroy(TuyChinhNgayOff $tuychinhngayoff)
    {
        $tuychinhngayoff->delete();

        return redirect()->route('tuychinh-ngayoff.index')
            ->with('success', 'Deleted successfully');
    }
    public function changeStatus(Request $request)
    {
        $benhVien = TuyChinhNgayOff::find($request->id);
        $benhVien->status = $request->status;
        $benhVien->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
}
