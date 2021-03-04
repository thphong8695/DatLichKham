<?php

namespace App\Http\Controllers;

use App\Models\BenhVienPK;
use App\Models\TuyChinhDatLich;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class BenhVienPKController extends Controller
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
        $benhvien = BenhVienPK::latest()->take(1000)->get();

        return view('pages.benhvien.index', compact('benhvien'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        return view('pages.benhvien.create');
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
            'name' => 'required|unique:mysql.benhvien_pks,name',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
        ],
        [
            'name' => 'Tên bệnh viện'
        ]);
        $input = $request->all();
        $input['status'] = 1;
        $input['slug'] = SlugService::createSlug(BenhVienPK::class, 'slug', $input['name']);

        $benhvien = BenhVienPK::create($input);
        TuyChinhDatLich::create(['benhvien_id' => $benhvien->id]);
        return redirect()->route('benh-vien.index')
            ->with('success', 'Tạo bệnh viện - phòng khám thành công.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BenhVienPK  $benhVienPK
     * @return \Illuminate\Http\Response
     */
    public function show(BenhVienPK $benhVien)
    {
        return view('pages.benhvien.show',compact('benhVien'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BenhVienPK  $benhVienPK
     * @return \Illuminate\Http\Response
     */
    public function edit(BenhVienPK $benhVien)
    {
        return view('pages.benhvien.edit',compact('benhVien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BenhVienPK  $benhVienPK
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BenhVienPK $benhVien)
    {
        $request->validate([
            'name' => 'required|unique:mysql.benhvien_pks,name,'.$benhVien->id,
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
        ],
        [
            'name' => 'Tên bệnh viện'
        ]);
        $input = $request->all();
        
        $input['slug'] = SlugService::createSlug(BenhVienPK::class, 'slug', $input['name']);
        $benhVien->update($input);
        return redirect()->route('benh-vien.index')
            ->with('success', 'Sửa bệnh viện - phòng khám thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BenhVienPK  $benhVienPK
     * @return \Illuminate\Http\Response
     */
    public function destroy(BenhVienPK $benhVien)
    {
        if(!($benhVien->ChuyenKhoa)->isEmpty() || !($benhVien->DatLichKham)->isEmpty() || !($benhVien->KhungGio)->isEmpty() || !($benhVien->TuyChinhKhungGio)->isEmpty() || !($benhVien->TuyChinhNgayOff)->isEmpty())
        {
            return redirect()->back()
            ->with('error', 'Dữ liệu trong bệnh viện - phòng khám vẫn còn.');            
        }

        $benhVien->delete();
        return redirect()->route('benh-vien.index')
            ->with('success', 'Deleted successfully');

    }
    public function changeStatus(Request $request)
    {
        $benhVien = BenhVienPK::find($request->id);
        $benhVien->status = $request->status;
        $benhVien->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
}
