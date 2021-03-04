<?php

namespace App\Http\Controllers;

use App\Models\BacSi;
use App\Models\BenhVienPK;
use App\Models\ChuyenKhoa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Repositories\EloquentRepository;

class BacSiController extends Controller
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
        $bacsi = BacSi::latest()->take(1000)->whereHas('BenhVienPK',function($q)
        {
            $q->where("status",1);
        })->get();
        if( empty($request->has( $request->all() )) )
        {
            
            $query = BacSi::latest()->take(1000)->whereHas('BenhVienPK',function($q)
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
            $bacsi = $query->get();
            // $querystringArray = $request->only(['_token,q']);
            // $BacSi->appends($querystringArray);   
        }
        $benhvien = $this->repository->getListBenhVienSlug();
        // $benhvien = BenhVienPK::all();
        return view('pages.bacsi.index', compact('bacsi','benhvien'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $benhvien = $this->repository->getListBenhVienId();

        return view('pages.bacsi.create',compact('benhvien'));
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
            'name' => ['required',Rule::unique('mysql.bacsis')->where(function ($query) use($request) {
                        return $query->where('name', $request->name)
                        ->where('benhvien_id', $request->benhvien_id);
                    }),
            ],
            'benhvien_id' => 'required',

        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
        ],
        [
            'name' => 'Tên bác sĩ',
            'benhvien_id' => 'Bệnh viện',
        ]);
        $input = $request->all();
        
        BacSi::create($input);

        return redirect()->route('bac-si.index')
            ->with('success', 'Tạo bác sĩ thành công.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BacSi  $BacSi
     * @return \Illuminate\Http\Response
     */
    public function show(BacSi $bacSi)
    {
        return view('pages.bacsi.show',compact('bacSi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BacSi  $BacSi
     * @return \Illuminate\Http\Response
     */
    public function edit(BacSi $bacSi)
    {
        $benhvien = $this->repository->getListBenhVienId();
        $chuyenkhoa = ChuyenKhoa::where('benhvien_id',$bacSi->benhvien_id)->pluck('name','id')->all();
        return view('pages.bacsi.edit',compact('bacSi','benhvien','chuyenkhoa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BacSi  $BacSi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BacSi $bacSi)
    {
        $request->validate([
            'name' => ['required',Rule::unique('mysql.bacsis')->where(function ($query) use($request) {
                        return $query->where('name', $request->name)
                        ->where('benhvien_id', $request->benhvien_id);
                    })->ignore($bacSi->id),
            ],
            'benhvien_id' => 'required',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
        ],
        [
            'name' => 'Tên bác sĩ',
            'benhvien_id' => 'Bệnh viện',
        ]);
        $input = $request->all();
        
        $bacSi->update($input);

        return redirect()->route('bac-si.index')
            ->with('success', 'Sửa bác sĩ thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BacSi  $BacSi
     * @return \Illuminate\Http\Response
     */
    public function destroy(BacSi $bacSi)
    {
        if(!($bacSi->DatLichKham)->isEmpty())
        {
            return redirect()->back()
            ->with('error', 'Dữ liệu trong bác sĩ vẫn còn.');            
        }
        $bacSi->delete();

        return redirect()->route('bac-si.index')
            ->with('success', 'Deleted successfully');
    }
    public function showBacSiInBenhVien(Request $request)
    {
        if ($request->ajax()) {
            $bacsi = BacSi::where('benhvien_id',$request->benhvien_id)->orwhereHas('BenhVienPK',function($q) use($request)
                {
                    $q->where("slug",$request->benhvien_id);
                })
            ->select('id','name','chuyenkhoa_id','benhvien_id')->get();

            return response()->json($bacsi);
        }
    }
    public function showBacSiInChuyenKhoa(Request $request)
    {
        if ($request->ajax()) {
            $bacsi = BacSi::where('chuyenkhoa_id',$request->chuyenkhoa_id)->select('id','name','chuyenkhoa_id','benhvien_id')->get();

            return response()->json($bacsi);
        }
    }
}
