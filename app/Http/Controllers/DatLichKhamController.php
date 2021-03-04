<?php

namespace App\Http\Controllers;
use App\Http\Controllers\TinNhanController;
use App\Models\DatLichKham;
use App\Models\BenhVienPK;
use App\Models\KhungGio;
use App\Models\ChuyenKhoa;
use App\Models\BacSi;
use App\Models\TuyChinhKhungGio;
use App\Models\TuyChinhNgayOff;
use App\Models\VacXin;
use App\Models\User;
use App\Models\ThongBao;
use App\Models\TuyChinhDatLich;
use App\Models\TinNhan;
use App\Models\MauTinNhan;
use HoangPhi\VietnamMap\Models\Province;
use Illuminate\Http\Request;
use App\Http\Requests\DatLichKhamRequest;
use App\Repositories\EloquentRepository;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Auth;
use Spatie\Activitylog\Models\Activity;



class DatLichKhamController extends Controller
{
    protected $repository;
    function __construct(EloquentRepository $repository)
    {
        $this->middleware('auth');
        $this->middleware('permission:DlBv106x-list|DlBv106x-create|DlBv106x-edit|DlBv106x-delete', ['only' => ['index','store','show']]);
        $this->middleware('permission:DlBv106x-create', ['only' => ['create','store']]);
        $this->middleware('permission:DlBv106x-edit', ['only' => ['edit','update','editSms','updateSms']]);
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
        $chuyenkhoa =[];
        $khunggio = [];
        $datlichkham = DatLichKham::orderBy('id','DESC')->whereHas('BenhVienPK',function($q)
            {
                $q->where("status",1);
            })->paginate(20);
        if( empty($request->has( $request->all() )) )
        {
            
            $query = DatLichKham::orderBy('id','DESC')->whereHas('BenhVienPK',function($q)
            {
                $q->where("status",1);
            });
            $name = $request->name;
            if(isset($name))
            {
                $query = $query->where("name",'like','%'.$name.'%');
            }
            $ngaykham = Carbon::parse($request->ngaykham)->format('Y-m-d');
            if(isset($request->ngaykham))
            {
                $query = $query->where("ngaykham",$ngaykham);
            }
            $phone = $request->phone;
            if(isset($phone))
            {
                $query = $query->where("phone",'like','%'.$phone.'%');
            }
            $bv = $request->bv;
            if(isset($bv))
            {
                $query = $query->whereHas('BenhVienPK',function($q) use($bv)
                {
                    $q->where("slug",$bv);
                });
                $chuyenkhoa = ChuyenKhoa::whereHas('BenhVienPK',function($q) use($bv)
                {
                    $q->where("status",1)
                    ->where("slug",$bv);
                })->pluck('name','slug')->all();
                $khunggio = KhungGio::whereHas('BenhVienPK',function($q) use($bv)
                {
                    $q->where("status",1)
                    ->where("slug",$bv);
                })->get();
            }
            $ck = $request->ck;
            if(isset($ck))
            {
                $query = $query->whereHas('ChuyenKhoa',function($q) use($ck)
                {
                    $q->where("slug",$ck);
                });
            }
            $kg = $request->kg;
            if(isset($kg))
            {
                $query = $query->whereHas('KhungGio',function($q) use($kg)
                {
                    $q->where("id",$kg);
                });
            }

            $datlichkham = $query->paginate(20);
            $querystringArray = $request->only(['_token','name','ngaykham','phone','bv','ck','kg']);
            $datlichkham->appends($querystringArray);
        }
        $benhvien = $this->repository->getListBenhVienSlug();
        $thongbao = ThongBao::pluck('thongbao_datlich')->first();
        // dd($datlichkham->first()->TinNhan);
        return view('pages.datlichkham.index', compact('datlichkham','benhvien','chuyenkhoa','khunggio','thongbao'));
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
        $chuyenkhoa = ChuyenKhoa::all();
        $gioitinh = [
            '1' => 'Nam',
            '0' => 'Nữ',
        ];
        $ngayoff = TuyChinhNgayOff::pluck('ngayoff')->toJson();
        // dd($ngayoff);
        return view('pages.datlichkham.create',compact('benhvien','khunggio','chuyenkhoa','gioitinh','ngayoff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //DatLichKhamRequest
    public function store(DatLichKhamRequest $request)
    {
        $khunggio = KhungGio::where('id',$request->khunggio_id)->whereHas('BenhVienPK',function($q) use($request)
        {
            $q->where("status",1)
            ->where("id",$request->benhvien_id);
        })->first();
        $datlichkham_count = DatLichKham::whereDate('ngaykham',Carbon::parse($request->ngaykham)->format('Y-m-d'))->where('khunggio_id',$request->khunggio_id)->whereHas('BenhVienPK',function($q) use($request)
        {
            $q->where("status",1)
            ->where("id",$request->benhvien_id);
        })->count();

        $tuychinh_khunggio = TuyChinhKhungGio::whereDate('ngaydat',Carbon::parse($request->ngaykham)->format('Y-m-d'))->where('khunggio_id',$request->khunggio_id)->where("status",1)->whereHas('BenhVienPK',function($q) use($request)
        {
            $q->where("status",1)
            ->where("id",$request->benhvien_id);
        })->first();
        $tuychinh_ngayoff = TuyChinhNgayOff::whereDate('ngayoff',Carbon::parse($request->ngaykham)->format('Y-m-d'))->where("status",1)->whereHas('BenhVienPK',function($q) use($request)
        {
            $q->where("status",1)
            ->where("id",$request->benhvien_id);
        })->first();
        if($tuychinh_ngayoff)
        {
            return redirect()->back()->withInput()
            ->with('error', 'Ngày bạn chọn là ngày off.');
        }

        if( ( ($tuychinh_khunggio) && $datlichkham_count >= $tuychinh_khunggio->soluong ) || ( $khunggio && $datlichkham_count >= $khunggio->soluong ) )
        {
            return redirect()->back()->withInput()
            ->with('error', 'Lượt đặt đã quá số lần cho phép.');
        }
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        DatLichKham::create($input);

        return redirect()->route('dat-lich-kham.index')
            ->with('success', 'Đặt lịch khám thành công thành công.');
    }


    //create step by step
    public function createStep1(Request $request)
    {
        $register = $request->session()->get('register');

        $benhvien = $this->repository->getListBenhVienId();
        return view('pages.datlichkham.createStep1',compact('register','benhvien'));
    }

    public function PostcreateStep1(Request $request)
    {
        $validatedData = $request->validate([
            'benhvien_id' => 'required|integer',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'integer' => ":attribute phải là số!",
        ],
        [
            'benhvien_id' => 'Bệnh viện',
        ]);
        if(empty($request->session()->get('register'))){
            $register = new DatLichKham();
            $register->fill($validatedData);
            $request->session()->put('register', $register);
        }else{
            $register = $request->session()->get('register');
            $register->fill($validatedData);
            $request->session()->put('register', $register);
        }
        return redirect()->route('dat-lich-kham.createStep2');
    }

    public function createStep2(Request $request)
    {
        if(!session()->has('register'))
        {
            return redirect()->route('dat-lich-kham.createStep1');
        }
        $register = $request->session()->get('register');     
        $ngayoff = TuyChinhNgayOff::where('benhvien_id',$register->benhvien_id)->pluck('ngayoff')->toJson();
        $tenbenhvien = BenhVienPK::findOrFail($register->benhvien_id);
        // dd($ngayoff);
        return view('pages.datlichkham.createStep2',compact('register','ngayoff','tenbenhvien'));
    }

    public function PostcreateStep2(Request $request)
    {
        
        $validatedData = $request->validate([
            'ngaykham' => 'required|date',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'date' => ":attribute phải đúng định dạng ngày!",
        ],
        [
            'ngaykham' => 'Ngày khám',
        ]);
        $register = $request->session()->get('register');
        // dd($register->benhvien_id);
        
        if(empty($request->session()->get('register'))){
            $register = new DatLichKham();
            $register->fill($validatedData);
            $request->session()->put('register', $register);
        }else{
            $register = $request->session()->get('register');
            $register->fill($validatedData);
            $request->session()->put('register', $register);
        }
        $tuychinh_ngayoff = TuyChinhNgayOff::whereDate('ngayoff',Carbon::parse($register->ngaykham)->format('Y-m-d'))->where("status",1)->whereHas('BenhVienPK',function($q) use($register)
        {
            $q->where("status",1)
            ->where("id",$register->benhvien_id);
        })->first();
        if($tuychinh_ngayoff)
        {
            return redirect()->back()->withInput()
            ->with('error', 'Ngày bạn chọn là ngày off.');
        }
        return redirect()->route('dat-lich-kham.createStep3');
    }
    
    public function createStep3(Request $request)
    {  
        if(!session()->has('register'))
        {
            return redirect()->route('dat-lich-kham.createStep1');
        }
        $register = $request->session()->get('register');
        $vacxin = $request->session()->get('vacxin');
        $province = Province::all();
        $khunggio = KhungGio::where('benhvien_id',$register->benhvien_id)
        ->with(['DatLichKham' => function($query) use ($register) {
                    $query->where('ngaykham',$register->ngaykham);
                }])
        ->with(['TuyChinhKhungGio' => function($query) use ($register) {
                    $query->where('ngaydat',$register->ngaykham)
                    ->where('status', 1);
                }])
        ->get();
        $chuyenkhoa = ChuyenKhoa::where('benhvien_id',$register->benhvien_id)->get();
        $bacsi = BacSi::where('benhvien_id',$register->benhvien_id)->get();
        $gioitinh = [
            '1' => 'Nam',
            '0' => 'Nữ',
        ];
        $vacxin = VacXin::where('benhvien_id',$register->benhvien_id)
        ->where('status',1)
        ->orderBy('stt','ASC')
        ->pluck('name','id')->all();
        $tenbenhvien = BenhVienPK::findOrFail($register->benhvien_id);
        $tuychinhFormDL = TuyChinhDatLich::where('benhvien_id',$register->benhvien_id)->first();
        // dd($tuychinhFormDL);
        return view('pages.datlichkham.createStep3',compact('register','province','khunggio','chuyenkhoa','bacsi','gioitinh','vacxin','tenbenhvien','tuychinhFormDL'));
    }

    public function PostcreateStep3(Request $request)
    {
        $register = $request->session()->get('register');
        // dd($request->all());
        // dd($request);

        $validatedData = $request->validate([
            'khunggio_id' => 'required|integer',
            'name' => ['required','max:191',Rule::unique('mysql.datlichkhams')->where(function ($query) use($request,$register) {
                        return $query->where('ngaykham', Carbon::parse($register->ngaykham)->format('Y-m-d'))
                        ->where('name', $request->name)
                        ->where('khunggio_id', $request->khunggio_id)
                        ->where('chuyenkhoa_id', $request->chuyenkhoa_id)
                        ->where('benhvien_id', $register->benhvien_id);
                    }),
            ],
            'diachi'=> 'max:191',
            'namsinh' => 'min:0',
            'gioitinh' => 'max:6',
            'province_id' => 'integer',
            'bacsi_id' => 'min:0',
            'chuyenkhoa_id' => 'nullable',
            'vacxin_id' => 'min:0',
            'user_id' => 'integer',
            'phone' => 'required|max:191|digits_between:9,15',
            'sonha'=> 'max:191',
            
            'mayte'=> 'max:191',
            'sobaohiem'=> 'max:191',
            'ghichu'=> 'max:1000',
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại, vui lòng kiểm tra lại!",
            'integer' => ":attribute phải là số!",
            'date' => ":attribute phải đúng định dạng ngày!",
            'max' => ":attribute không vượt quá :max!",
            'min' => ":attribute không vượt quá :min!",
            'digits_between' => ":attribute phải trên :min số và nhỏ hơn :max số!",
        ],
        [
            'name' => 'Họ & Tên',
            'namsinh' => 'Năm sinh',
            'gioitinh' => 'Giới tính',
            'phone' => 'Số điện thoại',
            'sonha'=> 'Số nhà',
            'diachi'=> 'Địa chỉ',
            'mayte'=> 'Mã y tế',
            'ghichu'=> 'Ghi chú',
            'sobaohiem'=> 'Số bảo hiểm',
            'khunggio_id' => 'Khung giờ',
            'chuyenkhoa_id' => 'Chuyên khoa',
            'province_id' => 'Tỉnh thành',
            'bacsi_id' => 'Bác sĩ',
            'vacxin_id' => 'Vắc-xin(thuốc)',
            'user_id' => 'User'
        ]);
                //check
        $khunggio = KhungGio::where('id',$request->khunggio_id)->whereHas('BenhVienPK',function($q) use($register)
        {
            $q->where("status",1)
            ->where("id",$register->benhvien_id);
        })->first();
        $datlichkham_count = DatLichKham::whereDate('ngaykham',Carbon::parse($register->ngaykham)->format('Y-m-d'))->where('khunggio_id',$request->khunggio_id)->whereHas('BenhVienPK',function($q) use($register)
        {
            $q->where("status",1)
            ->where("id",$register->benhvien_id);
        })->count();

        $tuychinh_khunggio = TuyChinhKhungGio::whereDate('ngaydat',Carbon::parse($register->ngaykham)->format('Y-m-d'))->where('khunggio_id',$request->khunggio_id)->where("status",1)->whereHas('BenhVienPK',function($q) use($register)
        {
            $q->where("status",1)
            ->where("id",$register->benhvien_id);
        })->first();
        $tuychinh_ngayoff = TuyChinhNgayOff::whereDate('ngayoff',Carbon::parse($register->ngaykham)->format('Y-m-d'))->where("status",1)->whereHas('BenhVienPK',function($q) use($register)
        {
            $q->where("status",1)
            ->where("id",$register->benhvien_id);
        })->first();
        if($tuychinh_ngayoff)
        {
            return redirect()->back()->withInput()
            ->with('error', 'Ngày bạn chọn là ngày off.');
        }

        if( ( ($tuychinh_khunggio) && $datlichkham_count >= $tuychinh_khunggio->soluong ) || ( $khunggio && $datlichkham_count >= $khunggio->soluong ) )
        {
            return redirect()->back()->withInput()
            ->with('error', 'Lượt đặt đã quá số lần cho phép.');
        }

        if($request->vacxin_id != null)
        {
            $rq_vacxin = VacXin::whereIn('id',$request->vacxin_id)->where('status',1)->get();
            foreach ($rq_vacxin as $key => $value) 
            {
                if(($value->soluong != null) && ($value->soluong > 0) && ($value->soluong <= $value->DatLichKham->count()))
                {
                    return redirect()->back()->with('error_vacxin','Vắc-xin: '.$value->name.' đã quá số lượng đặt.')->withInput();
                }
            }
        }
        
        //save
        if(empty($request->session()->get('register'))){
            $register = new DatLichKham();
            $register->fill($validatedData);
            $request->session()->put('register', $register);
        }else{
            $register = $request->session()->get('register');
            
            $register->fill($validatedData);
            $request->session()->put('register', $register);
        }
        
        $vacxin = $request->session()->get('vacxin');
        $request->session()->put('vacxin', $request->vacxin_id);
        
        return redirect()->route('dat-lich-kham.createStep4');
        
        
    }
    public function createStep4(Request $request)
    {
        if(!session()->has('register'))
        {
            return redirect()->route('dat-lich-kham.createStep1');
        }
        $register = $request->session()->get('register');  
        // dd($request->session()->get('register'));
        // dd($request->session()->get('vacxin'));  
        $tenbenhvien = BenhVienPK::findOrFail($register->benhvien_id);
        $khunggio = KhungGio::findOrFail($register->khunggio_id);
        $chuyenkhoa = ChuyenKhoa::where('id',$register->chuyenkhoa_id)->first();
        // dd($chuyenkhoa);
        $bacsi = BacSi::where('id',$register->bacsi_id)->first();
        $province = Province::where('id',$register->province_id)->first();
        $vacxin = $request->session()->get('vacxin') ? VacXin::whereIn('id',$request->session()->get('vacxin'))->get() : [];
        $tuychinhFormDL = TuyChinhDatLich::where('benhvien_id',$register->benhvien_id)->first();
        $mautinnhan = MauTinNhan::where('benhvien_id',$register->benhvien_id)->first();
        //sms
        $stt_datlich = DatLichKham::whereDate('ngaykham',Carbon::parse($register->ngaykham)->format('Y-m-d'))->where('khunggio_id',$register->khunggio_id)->count();
        // dd($stt_datlich);
        $mang_replace = array('$khunggio','$ngaykham','$phone','$benhvien','$stt');
        $mang_str = array($khunggio->name,$register->ngaykham->format('d/m/Y'),$register->phone,$tenbenhvien->name,($stt_datlich + 1));
        $noidung_sms = $mautinnhan ? str_replace($mang_replace,$mang_str,$mautinnhan->content) : [];
        // dd($register);
        return view('pages.datlichkham.createStep4',compact('register','tenbenhvien','khunggio','chuyenkhoa','bacsi','province','vacxin','tuychinhFormDL','mautinnhan','noidung_sms'));
    }
    public function PostcreateStep4(Request $request)
    {
        $register = $request->session()->get('register');
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $register->created_at = $now->toDateTimeString();
        
        // save dat lich
        $register->save();
        $register->VacXin()->attach($request->session()->get('vacxin'));
        //send and save sms
        if($request->sms_id)
        {
            $toNumbers = $register->phone;
            $message = $request->sms_id;
            var_dump($this->repository->sendBulkSms($message,$toNumbers));
            TinNhan::create([
                'phone' => $toNumbers,
                'content' => $message,
                'benhvien_id' => $register->benhvien_id,
                'user_id' => Auth::user()->id,
                'datlichkham_id' => $register->id,
            ]);
        }
        
        

        $request->session()->forget(['register','vacxin']);
        return redirect()->route('dat-lich-kham.index')->with('success', 'Đặt lịch khám thành công.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DatLichKham  $datLichKham
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if ($request->ajax()) 
        {
            $datlichkham = DatLichKham::find($id);
            $tenbenhvien = BenhVienPK::where('id',$datlichkham->benhvien_id)->select('name')->first();
            $khunggio = KhungGio::where('id',$datlichkham->khunggio_id)->select('name')->first();
            $chuyenkhoa = ChuyenKhoa::where('id',$datlichkham->chuyenkhoa_id)->select('name')->first();
            $bacsi = BacSi::where('id',$datlichkham->bacsi_id)->select('name')->first();
            $province = Province::where('id',$datlichkham->province_id)->select('name')->first();
            $user = User::where('id',$datlichkham->user_id)->select('username')->first();
            $vacxin = $datlichkham->VacXin->pluck('name','name');
            $activitylog = Activity::forSubject($datlichkham)->select('log_name','description','causer_id','created_at')->with('user')->orderBy('id','DESC')->limit(10)->get();
            $tuychinhFormDL = TuyChinhDatLich::where('benhvien_id',$datlichkham->benhvien_id)->first();

            return response()->json(['datlichkham' => $datlichkham,'tenbenhvien' =>$tenbenhvien,'khunggio' => $khunggio,'chuyenkhoa' => $chuyenkhoa,'bacsi' => $bacsi,'province' => $province,'user' => $user,'vacxin' => $vacxin,'activitylog' => $activitylog,'tuychinhFormDL' => $tuychinhFormDL]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DatLichKham  $datLichKham
     * @return \Illuminate\Http\Response
     */
    public function edit(DatLichKham $datLichKham)
    {
        // $datlichkham = DatLichKham::findOrFail($id);
        $benhvien = $this->repository->getListBenhVienId();
        $khunggio = KhungGio::where('benhvien_id',$datLichKham->benhvien_id)
        ->with(['DatLichKham' => function($query) use ($datLichKham) {
                    $query->where('ngaykham',$datLichKham->ngaykham);
                }])
        ->with(['TuyChinhKhungGio' => function($query) use ($datLichKham) {
                    $query->where('ngaydat',$datLichKham->ngaykham)
                    ->where('status', 1);
                }])
        ->get();
        $chuyenkhoa = ChuyenKhoa::where('benhvien_id',$datLichKham->benhvien_id)->get();
        // dd($chuyenkhoa);
        $bacsi = BacSi::where('chuyenkhoa_id',$datLichKham->chuyenkhoa_id)->pluck('name','id')->all();
        $gioitinh = [
            '1' => 'Nam',
            '0' => 'Nữ',
        ];
        $ngayoff = TuyChinhNgayOff::pluck('ngayoff')->toJson();
        $province = Province::pluck('name','id')->all();
        $vacxin = VacXin::where('status',1)->where('benhvien_id',$datLichKham->benhvien_id)->pluck('name','id')->all();
        $datlichkham_vacxin = $datLichKham->VacXin->pluck('id','name')->all();
        return view('pages.datlichkham.edit',compact('datLichKham','benhvien','khunggio','chuyenkhoa','bacsi','gioitinh','ngayoff','province','vacxin','datlichkham_vacxin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DatLichKham  $datLichKham
     * @return \Illuminate\Http\Response
     */
    public function update(DatLichKhamRequest $request, DatLichKham $datLichKham)
    {
        // $datlichkham = DatLichKham::find($id);
        $input = $request->all();
        // dd($request->vacxin_id);
        $datLichKham->update($input);
        $datLichKham->VacXin()->sync($request->vacxin_id);
        return redirect()->route('dat-lich-kham.index')
            ->with('success', 'Sửa lịch khám thành công.');
    }
    public function editSms($id)
    {
        $tinNhan = TinNhan::findOrFail($id);
        return view('pages.datlichkham.editSms',compact('tinNhan'));
    }
    public function updateSms(Request $request, $id)
    {
        $request->validate([
            'phone' => 'required|digits_between:9,15',
            'content' => 'required|max:500', 
        ],
        [
            'required' => ":attribute không được bỏ trống!",
            'max' => ":attribute không được lớn hơn :max ký tự!",
            'digits_between' => ":attribute phải trên :min số và nhỏ hơn :max số!",
        ],
        [
            'content' => 'Nội dung',
            'phone' => 'SĐT',
            
        ]);
        $tinNhan = TinNhan::findOrFail($id);
        $input = $request->all();
        $toNumbers = $request->phone;
        $message = $request->content;
        var_dump($this->repository->sendBulkSms($message,$toNumbers));
        // dd($request->vacxin_id);
        $tinNhan->update($input);

        return redirect()->route('dat-lich-kham.index')
            ->with('success', 'Gửi lại SMS thành công.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DatLichKham  $datLichKham
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datlichkham = DatLichKham::find($id);
        $datlichkham->delete();

        return redirect()->route('dat-lich-kham.index')
            ->with('success', 'Deleted successfully');
    }
    public function showKhungGioInBenhVien(Request $request)
    {

        if ($request->ajax()) {
            $khunggio = KhungGio::where('benhvien_id',$request->benhvien_id)
            ->orwhereHas('BenhVienPK',function($q) use($request)
                {
                    $q->where("slug",$request->benhvien_id);
                })
            ->with(['DatLichKham' => function($query) use ($request) {
                    $query->whereDate('ngaykham',Carbon::parse($request->ngaykham)->format('Y-m-d'));
                }])
            ->with(['TuyChinhKhungGio' => function($query) use ($request) {
                    $query->whereDate('ngaydat',Carbon::parse($request->ngaykham)->format('Y-m-d'))
                    ->where('status', 1);
                }])
            ->select('id','name','soluong','benhvien_id')->get();
            return response()->json($khunggio);
        }
    }
    public function showVacXinInBenhVien(Request $request)
    {

        if ($request->ajax()) {
            $vacxin = VacXin::where('benhvien_id',$request->benhvien_id)->where('status', 1)
            ->select('id','name','benhvien_id')->get();
            return response()->json($vacxin);
        }
    }
}
