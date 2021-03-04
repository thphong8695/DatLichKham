<?php

namespace App\Http\Controllers;

use App\Models\VacXin;
use App\Models\SuDungVacXin;
use Illuminate\Http\Request;
use App\Models\BenhVienPK;
use App\Models\ThongBao;
use Illuminate\Validation\Rule;
use App\Repositories\EloquentRepository;
class VacXinController extends Controller
{
    protected $repository;
    function __construct(EloquentRepository $repository)
    {
        $this->middleware('auth');
        $this->middleware('permission:DlBv106x-edit', ['only' => ['index','edit','update','create','store','show','changeStatus','update_stt']]);
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
        $vacxin = VacXin::latest()->take(1000)->whereHas('BenhVienPK',function($q)
        {
            $q->where("status",1);
        })->get();
        if( empty($request->has( $request->all() )) )
        {
            
            $query = VacXin::latest()->take(1000)->whereHas('BenhVienPK',function($q)
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
            $vacxin = $query->get();
            // $querystringArray = $request->only(['_token,q']);
            // $chuyenkhoa->appends($querystringArray);   
        }
        $benhvien = $this->repository->getListBenhVienSlug();
        // $benhvien = BenhVienPK::all();
        return view('pages.vacxin.index', compact('vacxin','benhvien'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $benhvien = $this->repository->getListBenhVienId();
        $sdvacxin = SuDungVacXin::where('status',1)->pluck('name','id')->all();
        return view('pages.vacxin.create',compact('benhvien','sdvacxin'));
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
            'name' => ['max:100','required',Rule::unique('mysql.vacxins')->where(function ($query) use($request) {
                        return $query->where('name', $request->name)
                        ->where('benhvien_id', $request->benhvien_id);
                    }),
            ],
            'benhvien_id' => 'required',
            'nguabenh' => 'required', 
            'giatien' => 'max:191', 
            'ngayapdung' => 'date', 
            'sdvacxin_id' => 'required', 

        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
            'integer' => ":attribute phải là số!",
            'date' => ":attribute phải đúng định dạng ngày!",
            'max' => ":attribute không vượt quá :max!",
        ],
        [
            'name' => 'Tên vắc-xin(thuốc)',
            'benhvien_id' => 'Bệnh viện',
            'nguabenh' => 'Ngừa bệnh', 
            'giatien' => 'Giá tiền', 
            'ngayapdung' => 'Ngày áp dụng', 
            'sdvacxin_id' => 'Loại sử dụng', 
        ]);
        $input = $request->all();
        $input['status'] = 1;
        VacXin::create($input);

        return redirect()->route('vac-xin.index')
            ->with('success', 'Tạo vắc xin thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VacXin  $vacXin
     * @return \Illuminate\Http\Response
     */
    public function show(VacXin $vacXin)
    {
        return view('pages.vacxin.show',compact('vacXin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VacXin  $vacXin
     * @return \Illuminate\Http\Response
     */
    public function edit(VacXin $vacXin)
    {
        $benhvien = $this->repository->getListBenhVienId();
        $sdvacxin = SuDungVacXin::where('status',1)->pluck('name','id')->all();
        return view('pages.vacxin.edit',compact('vacXin','benhvien','sdvacxin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VacXin  $vacXin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VacXin $vacXin)
    {
        $request->validate([
            'name' => ['max:100','required',Rule::unique('mysql.vacxins')->where(function ($query) use($request) {
                        return $query->where('name', $request->name)
                        ->where('benhvien_id', $request->benhvien_id);
                    })->ignore($vacXin->id),
            ],
            'benhvien_id' => 'required',
            'nguabenh' => 'required', 
            'giatien' => 'max:191', 
            'ngayapdung' => 'date', 
            'sdvacxin_id' => 'required', 

        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại!",
            'integer' => ":attribute phải là số!",
            'date' => ":attribute phải đúng định dạng ngày!",
            'max' => ":attribute không vượt quá :max!",
        ],
        [
            'name' => 'Tên vắc-xin(thuốc)',
            'benhvien_id' => 'Bệnh viện',
            'nguabenh' => 'Ngừa bệnh', 
            'giatien' => 'Giá tiền', 
            'ngayapdung' => 'Ngày áp dụng', 
            'sdvacxin_id' => 'Loại sử dụng', 
        ]);
        $input = $request->all();
        $input['mienphi'] = (isset($request->mienphi) ? 1 : 0);
        $vacXin->update($input);
        return redirect()->route('vac-xin.index')
            ->with('success', 'Sửa vắc xin thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VacXin  $vacXin
     * @return \Illuminate\Http\Response
     */
    public function destroy(VacXin $vacXin)
    {
        if(!($vacXin->DatLichKham)->isEmpty())
        {
            return redirect()->back()
            ->with('error', 'Dữ liệu trong vắc xin vẫn còn.');            
        }
       
        $vacXin->delete();

        return redirect()->route('vac-xin.index')
            ->with('success', 'Deleted vắc-xin successfully');
    }
    public function changeStatus(Request $request)
    {
        $vacXin = VacXin::find($request->id);
        $vacXin->status = $request->status;
        $vacXin->save();
  
        return response()->json(['success'=>'Status vắc-xin change successfully.']);
    }
    public function chitiet(Request $request)
    {
        $vacxin = [];
        if( empty($request->has( $request->all() )) )
        {
            
            $query = VacXin::orderBy('stt','ASC')->where("status",1)->take(1000)->whereHas('BenhVienPK',function($q)
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
            $vacxin = $query->get();
            // $querystringArray = $request->only(['_token,q']);
            // $chuyenkhoa->appends($querystringArray);   
        }
        $benhvien = $this->repository->getListBenhVienSlug();
        // $benhvien = BenhVienPK::all();
        $thongbao = ThongBao::pluck('thongbao_vacxin')->first();
        return view('pages.vacxin.chitiet', compact('vacxin','benhvien','thongbao'));
    }
    public function update_stt(Request $request)
    {
        //dd($request->stt[7]);
        $this->validate($request, [
            'stt.*' => 'integer',  
        ],
        [
            'integer' => ':attribute Không đúng định dạng số',
        ],
        [
            'stt.*' => 'STT',
        ]
        );
        $vacxin = VacXin::whereIn('id', $request->id)->get();
        foreach ($vacxin as $key => $value) {
            $find_id =  VacXin::find($value->id);
            $find_id->stt = $request->stt[$key];
            $find_id->save();
        }
        return redirect()->back()->with('success','Chỉnh sửa thành công.');
    }
}
