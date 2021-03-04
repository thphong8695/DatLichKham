<?php

namespace App\Http\Controllers;

use App\Models\ChuyenKhoa;
use App\Models\BenhVienPK;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Validation\Rule;
use App\Repositories\EloquentRepository;
class ChuyenKhoaController extends Controller
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
        $chuyenkhoa = ChuyenKhoa::latest()->take(1000)->whereHas('BenhVienPK',function($q)
        {
            $q->where("status",1);
        })->get();
        if( empty($request->has( $request->all() )) )
        {
            
            $query = ChuyenKhoa::latest()->take(1000)->whereHas('BenhVienPK',function($q)
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
            $chuyenkhoa = $query->get();
            // $querystringArray = $request->only(['_token,q']);
            // $chuyenkhoa->appends($querystringArray);   
        }
        $benhvien = $this->repository->getListBenhVienSlug();
        // $benhvien = BenhVienPK::all();
        return view('pages.chuyenkhoa.index', compact('chuyenkhoa','benhvien'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $benhvien = $this->repository->getListBenhVienId();

        return view('pages.chuyenkhoa.create',compact('benhvien'));
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
            'name' => ['required',Rule::unique('mysql.chuyenkhoas')->where(function ($query) use($request) {
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
            'name' => 'Tên chuyên khoa',
            'benhvien_id' => 'Bệnh viện',
        ]);
        $input = $request->all();
        
        $input['slug'] = SlugService::createSlug(ChuyenKhoa::class, 'slug', $input['name']);
        ChuyenKhoa::create($input);

        return redirect()->route('chuyen-khoa.index')
            ->with('success', 'Tạo chuyên khoa thành công.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChuyenKhoa  $ChuyenKhoa
     * @return \Illuminate\Http\Response
     */
    public function show(ChuyenKhoa $chuyenkhoa)
    {
        return view('pages.chuyenkhoa.show',compact('chuyenkhoa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChuyenKhoa  $ChuyenKhoa
     * @return \Illuminate\Http\Response
     */
    public function edit(ChuyenKhoa $chuyenKhoa)
    {
        $benhvien = $this->repository->getListBenhVienId();
        return view('pages.chuyenkhoa.edit',compact('chuyenKhoa','benhvien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChuyenKhoa  $ChuyenKhoa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChuyenKhoa $chuyenKhoa)
    {
        $request->validate([
            'name' => ['required',Rule::unique('mysql.chuyenkhoas')->where(function ($query) use($request) {
                        return $query->where('name', $request->name)
                        ->where('benhvien_id', $request->benhvien_id);
                    })->ignore($chuyenKhoa->id),
            ],
            'benhvien_id' => 'required',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
        ],
        [
            'name' => 'Tên chuyên khoa',
            'benhvien_id' => 'Bệnh viện',
        ]);
        $input = $request->all();
        
        $input['slug'] = SlugService::createSlug(ChuyenKhoa::class, 'slug', $input['name']);
        $chuyenKhoa->update($input);

        return redirect()->route('chuyen-khoa.index')
            ->with('success', 'Sửa chuyên khoa thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChuyenKhoa  $ChuyenKhoa
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChuyenKhoa $chuyenKhoa)
    {
        if(!($chuyenKhoa->DatLichKham)->isEmpty() || !($chuyenKhoa->BacSi)->isEmpty())
        {
            return redirect()->back()
            ->with('error', 'Dữ liệu trong chuyên khoa vẫn còn.');            
        }
       
        $chuyenKhoa->delete();

        return redirect()->route('chuyen-khoa.index')
            ->with('success', 'Deleted successfully');
    }
}
