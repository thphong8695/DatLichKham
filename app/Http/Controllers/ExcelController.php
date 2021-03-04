<?php

namespace App\Http\Controllers;

use App\Models\DatLichKham;
use App\Models\BenhVienPK;
use App\Models\KhungGio;
use App\Models\ChuyenKhoa;
use App\Models\TuyChinhKhungGio;
use App\Models\TuyChinhNgayOff;
use App\Models\User;
use HoangPhi\VietnamMap\Models\Province;
use Illuminate\Http\Request;
use App\Http\Requests\DatLichKhamRequest;
use App\Repositories\EloquentRepository;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DatLichKhamExport;

class ExcelController extends Controller
{
    protected $repository;
    function __construct(EloquentRepository $repository)
    {
        $this->middleware('auth');
        $this->middleware('permission:DlBv106x-edit', ['only' => ['index','export']]);
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $chuyenkhoa =ChuyenKhoa::all();
        $khunggio = KhungGio::all();
        $benhvien = $this->repository->getListBenhVienId();
      
        return view('pages.excel.index', compact('benhvien','chuyenkhoa','khunggio'));
    }
    public function export(Request $request)
    {
        var_dump(libxml_use_internal_errors(true));
        ob_end_clean(); // this
        ob_start(); 
        $this->validate(request(), [
            'benhvien_id' => 'required',
        ],
        [
            'required' => ':attribute không được bỏ trống.',
        ],
        [
            'benhvien_id' => 'Bệnh viện'
        ]);
        $benhvien_id = $request->benhvien_id;
        $khunggio_id = (isset($request->khunggio_id) ? $request->khunggio_id : 0);
        $chuyenkhoa_id = (isset($request->chuyenkhoa_id) ? $request->chuyenkhoa_id : 0);
        $from = (isset($request->from) ? Carbon::parse($request->from)->format('Y-m-d') : 0);
        $to = (isset($request->to) ? Carbon::parse($request->to)->format('Y-m-d') : 0);
        if( ($from != 0 && $to == 0) || ($from == 0 && $to != 0))
        {
            return redirect()->back()->with('error','Ngày bắt đầu và ngày kết thúc không được trống 1 trong 2!')->withInput();
        }
        $chuyenkhoa = (isset($request->chuyenkhoa) ? 0 : 1);
        $namsinh = (isset($request->namsinh) ? 0 : 1); 
        $gioitinh = (isset($request->gioitinh) ? 0 : 1); 
        $sonha = (isset($request->sonha) ? 0 : 1); 
        $diachi = (isset($request->diachi) ? 0 : 1); 
        $mayte = (isset($request->mayte) ? 0 : 1); 
        $sobaohiem = (isset($request->sobaohiem) ? 0 : 1); 
        $ghichu = (isset($request->ghichu) ? 0 : 1); 
        $province_id = (isset($request->province_id) ? 0 : 1); 
        $vacxin_id = (isset($request->vacxin_id) ? 0 : 1); 
        $bacsi_id = (isset($request->bacsi_id) ? 0 : 1); 
        $user_id = (isset($request->user_id) ? 0 : 1);

        $tenbenhvien = BenhVienPK::where('id',$benhvien_id)->first();
        try{
            return Excel::download(new DatLichKhamExport($benhvien_id,$khunggio_id,$chuyenkhoa_id,$from,$to, $chuyenkhoa, $namsinh, $gioitinh, $sonha, $diachi, $mayte, $sobaohiem, $ghichu, $province_id, $vacxin_id, $bacsi_id, $user_id), 'Danh sách đặt lịch khám: '.$tenbenhvien->name.'.xlsx');
        }
        catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

    }
    
}
