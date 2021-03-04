<?php

namespace App\Http\Controllers;

use App\Models\TuyChinhDatLich;
use App\Models\BenhVienPK;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Repositories\EloquentRepository;
class TuyChinhDatLichController extends Controller
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
    public function index()
    {
        $tuychinhdatlich = TuyChinhDatLich::latest()->take(1000)->whereHas('BenhVienPK',function($q)
        {
            $q->where("status",1);
        })->get();
        return view('pages.tuychinh-datlich.index', compact('tuychinhdatlich'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $benhvien = $this->repository->getListBenhVienId();

        return view('pages.tuychinh-datlich.create',compact('benhvien'));
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
            'benhvien_id' => 'required',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
        ],
        [
            'benhvien_id' => 'Bệnh viện',
        ]);
        $input = $request->all();
        
        TuyChinhDatLich::create($input);

        return redirect()->route('tuychinh-datlich.index')
            ->with('success', 'Tạo tùy chỉnh form đặt lịch thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TuyChinhDatLich  $tuyChinhDatLich
     * @return \Illuminate\Http\Response
     */
    public function show(TuyChinhDatLich $tuyChinhDatLich)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TuyChinhDatLich  $tuyChinhDatLich
     * @return \Illuminate\Http\Response
     */
    public function edit(TuyChinhDatLich $tuychinh_datlich)
    {
        $benhvien = $this->repository->getListBenhVienId();
        // dd($tuychinh_datlich);   
        return view('pages.tuychinh-datlich.edit',compact('tuychinh_datlich','benhvien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TuyChinhDatLich  $tuyChinhDatLich
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TuyChinhDatLich $tuychinh_datlich)
    {
        // $request->validate([
        //     'benhvien_id' => 'required',
        // ],
        // [
        //     'required' => ":attribute không được bỏ trống!",
        // ],
        // [
        //     'benhvien_id' => 'Bệnh viện',
        // ]);
        $input = $request->all();
        $input['namsinh'] = (isset($request->namsinh) ? 1 : 0); 
        $input['gioitinh'] = (isset($request->gioitinh) ? 1 : 0); 
        $input['sonha'] = (isset($request->sonha) ? 1 : 0); 
        $input['diachi'] = (isset($request->diachi) ? 1 : 0); 
        $input['mayte'] = (isset($request->mayte) ? 1 : 0); 
        $input['sobaohiem'] = (isset($request->sobaohiem) ? 1 : 0); 
        $input['ghichu'] = (isset($request->ghichu) ? 1 : 0); 
        $input['province_id'] = (isset($request->province_id) ? 1 : 0); 
        $input['vacxin_id'] = (isset($request->vacxin_id) ? 1 : 0); 
        $input['bacsi_id'] = (isset($request->bacsi_id) ? 1 : 0); 
        $input['chuyenkhoa_id'] = (isset($request->chuyenkhoa_id) ? 1 : 0);
        $input['sms_id'] = (isset($request->sms_id) ? 1 : 0); 
        // dd($input);
        $tuychinh_datlich->update($input);
        return redirect()->route('tuychinh-datlich.index')
            ->with('success', 'Sửa tùy chỉnh form đặt lịch thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TuyChinhDatLich  $tuyChinhDatLich
     * @return \Illuminate\Http\Response
     */
    public function destroy(TuyChinhDatLich $tuyChinhDatLich)
    {
        //
    }
}
