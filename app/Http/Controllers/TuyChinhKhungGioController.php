<?php

namespace App\Http\Controllers;

use App\Models\TuyChinhKhungGio;
use App\Models\KhungGio;
use App\Models\ChuyenKhoa;
use App\Models\User;
use App\Models\BenhVienPK;
use Illuminate\Http\Request;
use App\Repositories\EloquentRepository;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
class TuyChinhKhungGioController extends Controller
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
        $tuychinhkg = TuyChinhKhungGio::latest()->take(1000)->whereHas('BenhVienPK',function($q)
        {
            $q->where("status",1);
        })->get();
        
        if( empty($request->has( $request->all() )) )
        {
            
            $query = TuyChinhKhungGio::latest()->take(1000)->whereHas('BenhVienPK',function($q)
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
            $tuychinhkg = $query->get();
            // $querystringArray = $request->only(['_token,q']);
            // $chuyenkhoa->appends($querystringArray);   
        }
        $benhvien = $this->repository->getListBenhVienSlug();
        return view('pages.tuychinh-khunggio.index', compact('tuychinhkg','benhvien'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $benhvien = $this->repository->getListBenhVienId();
        $khunggio = KhungGio::all();
        return view('pages.tuychinh-khunggio.create',compact('benhvien','khunggio'));
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
            'ngaydat' => 'date_format:d-m-Y|required',
            'soluong' => 'required|integer|max:100',
            // 'status' => 'required',
            'benhvien_id' => ['required',Rule::unique('mysql.tuychinh_khunggios')->where(function ($query) use($request) {
                        return $query->where('ngaydat', Carbon::parse($request->ngaydat)->format('Y-m-d'))
                        ->where('benhvien_id', $request->benhvien_id)
                        ->where('khunggio_id', $request->khunggio_id);
                    }),
            ],
            'khunggio_id' => 'required',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => "Ngày tạo đã tồn tại!",
            'integer' => ":attribute phải là số!",
            'date' => ":attribute phải đúng định dạng ngày!",
            'max' => ":attribute không vượt quá :max!",
        ],
        [
            'ngaydat' => 'Ngày tạo',
            'soluong' => 'Số lượng',
            'status' => 'Trạng thái',
            'benhvien_id' => 'Bệnh viện',
            'khunggio_id' => 'Khung giờ',
        ]);
        $input = $request->all();
        $input['status'] = 1;
        TuyChinhKhungGio::create($input);

        return redirect()->route('tuychinh-khunggio.index')
            ->with('success', 'Tạo khung giờ thành công.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tuychinhkg  $tuychinhkg
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tuychinhkg = TuyChinhKhungGio::find($id);
        return view('pages.tuychinh-khunggio.show',compact('tuychinhkg'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tuychinhkg  $tuychinhkg
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tuychinhkg = TuyChinhKhungGio::find($id);
        // dd($tuychinhkg);
        $benhvien = $this->repository->getListBenhVienId();
        $khunggio = KhungGio::where('benhvien_id',$tuychinhkg->benhvien_id)->get();
        return view('pages.tuychinh-khunggio.edit',compact('tuychinhkg','benhvien','khunggio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tuychinhkg  $tuychinhkg
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $tuychinhkg = TuyChinhKhungGio::find($id);
        $request->validate([
            'ngaydat' => 'required',
            'soluong' => 'required|integer|max:100',
            // 'status' => 'required',
            'benhvien_id' => ['required',Rule::unique('mysql.tuychinh_khunggios')->where(function ($query) use($request) {
                        return $query->where('ngaydat', Carbon::parse($request->ngaydat)->format('Y-m-d'))
                        ->where('benhvien_id', $request->benhvien_id)
                        ->where('khunggio_id', $request->khunggio_id);
                    })->ignore($tuychinhkg->id),
            ],
            'khunggio_id' => 'required',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => "Ngày tạo đã tồn tại!",
            'integer' => ":attribute phải là số!",
            'date' => ":attribute phải đúng định dạng ngày!",
        ],
        [
            'ngaydat' => 'Ngày tạo',
            'soluong' => 'Số lượng',
            'status' => 'Trạng thái',
            'benhvien_id' => 'Bệnh viện',
            'khunggio_id' => 'Khung giờ',
        ]);
        $input = $request->all();
        
        $tuychinhkg->update($input);

        return redirect()->route('tuychinh-khunggio.index')
            ->with('success', 'Sửa khung giờ thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tuychinhkg  $tuychinhkg
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tuychinhkg = TuyChinhKhungGio::find($id);
        $tuychinhkg->delete();

        return redirect()->route('tuychinh-khunggio.index')
            ->with('success', 'Deleted successfully');
    }
    public function changeStatus(Request $request)
    {
        $benhVien = TuyChinhKhungGio::find($request->id);
        $benhVien->status = $request->status;
        $benhVien->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
    public function showKhungGioInBenhVien(Request $request)
    {
        if ($request->ajax()) {
            $khunggio = KhungGio::where('benhvien_id',$request->benhvien_id)->orwhereHas('BenhVienPK',function($q) use($request)
                {
                    $q->where("slug",$request->benhvien_id);
                })
            ->select('id','name','soluong','benhvien_id')->get();

            return response()->json($khunggio);
        }
    }
    public function showChuyenKhoaInBenhVien(Request $request)
    {
        if ($request->ajax()) {
            $chuyenkhoa = ChuyenKhoa::where('benhvien_id',$request->benhvien_id)->orwhereHas('BenhVienPK',function($q) use($request)
                {
                    $q->where("slug",$request->benhvien_id);
                })
            ->select('id','name','slug','benhvien_id')->get();

            return response()->json($chuyenkhoa);
        }
    }
}
