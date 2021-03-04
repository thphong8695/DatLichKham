<?php

namespace App\Http\Controllers;

use App\Models\KhungGio;
use App\Models\BenhVienPK;
use Illuminate\Http\Request;
use App\Repositories\EloquentRepository;
use Illuminate\Validation\Rule;

class KhungGioController extends Controller
{
    protected $repository;
    function __construct(EloquentRepository $repository)
    {
        $this->middleware('auth');
        $this->middleware('permission:DlBv106x-edit', ['only' => ['index','edit','update','create','store','show']]);
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
        $khunggio = KhungGio::latest()->take(1000)->whereHas('BenhVienPK',function($q)
        {
            $q->where("status",1);
        })->get();
        if( empty($request->has( $request->all() )) )
        {
            
            $query = KhungGio::latest()->take(1000)->whereHas('BenhVienPK',function($q)
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
            $khunggio = $query->get();
            // $querystringArray = $request->only(['_token,q']);
            // $chuyenkhoa->appends($querystringArray);   
        }
        $benhvien = $this->repository->getListBenhVienSlug();
        return view('pages.khunggio.index', compact('khunggio','benhvien'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $benhvien = $this->repository->getListBenhVienId();

        return view('pages.khunggio.create',compact('benhvien'));
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
            'name' => ['required',Rule::unique('mysql.khunggios')->where(function ($query) use($request) {
                        return $query->where('name', $request->name)
                        ->where('benhvien_id', $request->benhvien_id);
                    }),
            ],
            'soluong' => 'required|integer|max:100',
            'benhvien_id' => 'required',

        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
            'integer' => ":attribute phải là số!",
            'max' => ":attribute không vượt quá :max!",
        ],
        [
            'name' => 'Tên khung giờ',
            'soluong' => 'Số lượng',
            'benhvien_id' => 'Bệnh viện',
        ]);
        $input = $request->all();
        
        KhungGio::create($input);

        return redirect()->route('khung-gio.index')
            ->with('success', 'Tạo khung giờ thành công.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KhungGio  $KhungGio
     * @return \Illuminate\Http\Response
     */
    public function show(KhungGio $KhungGio)
    {
        return view('pages.khunggio.show',compact('khunggio'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KhungGio  $KhungGio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $khunggio = KhungGio::find($id);
        $benhvien = $this->repository->getListBenhVienId();
        return view('pages.khunggio.edit',compact('khunggio','benhvien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KhungGio  $KhungGio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $khunggio = KhungGio::find($id);
        $request->validate([
            'name' => ['required',Rule::unique('mysql.khunggios')->where(function ($query) use($request) {
                        return $query->where('name', $request->name)
                        ->where('benhvien_id', $request->benhvien_id);
                    })->ignore($khunggio->id),
            ],
            'soluong' => 'required|integer|max:100',
            'benhvien_id' => 'required',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
            'integer' => ":attribute phải là số!",
            'max' => ":attribute không vượt quá :max!",
        ],
        [
            'name' => 'Tên khung giờ',
            'soluong' => 'Số lượng',
            'benhvien_id' => 'Bệnh viện',
        ]);
        $input = $request->all();
        
        $khunggio->update($request->all());

        return redirect()->route('khung-gio.index')
            ->with('success', 'Sửa khung giờ thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KhungGio  $KhungGio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $khunggio = KhungGio::find($id);
        if(!($khunggio->DatLichKham)->isEmpty() || !($khunggio->TuyChinhKhungGio)->isEmpty())
        {
            return redirect()->back()
            ->with('error', 'Dữ liệu trong khung giờ vẫn còn.');            
        }
        $khunggio->delete();

        return redirect()->route('khung-gio.index')
            ->with('success', 'Deleted successfully');
    }
}
