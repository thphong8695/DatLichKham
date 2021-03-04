<?php

namespace App\Http\Controllers;

use App\Models\TinNhan;
use Illuminate\Http\Request;
use App\Models\MauTinNhan;
use App\Repositories\EloquentRepository;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use SoapClient;
class TinNhanController extends Controller
{
    protected $repository;
    function __construct(EloquentRepository $repository)
    {
        $this->middleware('auth');
        $this->middleware('permission:DlBv106x-edit', ['only' => ['index','edit','update','create','store','show','changeStatus','update_stt']]);
        $this->middleware('permission:DlBv106x-delete', ['only' => ['destroy']]);
        $this->repository = $repository;

    }
 
    public function index(Request $request)
    {
        $mautinnhan = MauTinNhan::latest()->take(1000)->whereHas('BenhVienPK',function($q)
        {
            $q->where("status",1);
        })->get();
        if( empty($request->has( $request->all() )) )
        {
            $query = MauTinNhan::latest()->take(1000)->whereHas('BenhVienPK',function($q)
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
            $mautinnhan = $query->get();
            // $querystringArray = $request->only(['_token,q']);
            // $chuyenkhoa->appends($querystringArray);   
        }
        $benhvien = $this->repository->getListBenhVienSlug();
        // $benhvien = BenhVienPK::all();
        return view('pages.mautinnhan.index', compact('mautinnhan','benhvien'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $benhvien = $this->repository->getListBenhVienId();
        return view('pages.mautinnhan.create',compact('benhvien'));
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
           
            'benhvien_id' => 'required|unique:mautinnhans,benhvien_id',
            'content' => 'required|max:500', 
            

        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'max' => ":attribute không được lớn hơn :max ký tự!",
            'unique'  => ":attribute Đã tồn tại!",
        ],
        [
            'content' => 'Nội dung',
            'benhvien_id' => 'Bệnh viện',
            
        ]);
        $input = $request->all();
        MauTinNhan::create($input);

        return redirect()->route('mau-tin-nhan.index')
            ->with('success', 'Tạo mẫu tin nhắn thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TinNhan  $tinNhan
     * @return \Illuminate\Http\Response
     */
    public function show(MauTinNhan $mauTinNhan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TinNhan  $tinNhan
     * @return \Illuminate\Http\Response
     */
    public function edit(MauTinNhan $mauTinNhan)
    {
        $benhvien = $this->repository->getListBenhVienId();
        return view('pages.mautinnhan.edit',compact('mauTinNhan','benhvien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TinNhan  $tinNhan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MauTinNhan $mauTinNhan)
    {
        $request->validate([
           
            'benhvien_id' => 'required|unique:mautinnhans,benhvien_id,'.$mauTinNhan->id,
            'content' => 'required|max:500', 
            

        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'max' => ":attribute không được lớn hơn :max ký tự!",
            'unique'  => ":attribute Đã tồn tại!",
        ],
        [
            'content' => 'Nội dung',
            'benhvien_id' => 'Bệnh viện',
            
        ]);
        $input = $request->all();
        $mauTinNhan->update($input);
        return redirect()->route('mau-tin-nhan.index')
            ->with('success', 'Sửa mẫu tin nhắn thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TinNhan  $tinNhan
     * @return \Illuminate\Http\Response
     */
    public function destroy(MauTinNhan $mauTinNhan)
    {
        $mauTinNhan->delete();
        return redirect()->route('mau-tin-nhan.index')
            ->with('success', 'Deleted mẫu tin nhắn successfully');
    }
    
}
