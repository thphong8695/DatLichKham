<?php

namespace App\Exports;

use App\Models\DatLichKham;
use App\Models\BenhVienPK;
use App\Models\KhungGio;
use App\Models\ChuyenKhoa;
use App\Models\TuyChinhKhungGio;
use App\Models\TuyChinhNgayOff;
use App\Models\User;
use App\Models\VacXin;
use App\Models\ThongBao;
use App\Models\TuyChinhDatLich;
use Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class DatLichKhamExport implements ShouldAutoSize,WithEvents, FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function __construct(string $benhvien_id,string $khunggio_id,string $chuyenkhoa_id,string $from,string $to,string $chuyenkhoa,string $namsinh,string $gioitinh,string $sonha,string $diachi,string $mayte,string $sobaohiem,string $ghichu,string $province_id,string $vacxin_id,string $bacsi_id,string $user_id )
    {
        $this->benhvien_id = $benhvien_id;
        $this->khunggio_id = $khunggio_id;
        $this->chuyenkhoa_id =$chuyenkhoa_id;
        $this->from = $from;
        $this->to = $to;
        $this->chuyenkhoa = $chuyenkhoa;
        $this->namsinh = $namsinh;
        $this->gioitinh = $gioitinh;
        $this->sonha = $sonha;
        $this->diachi = $diachi;
        $this->mayte = $mayte;
        $this->sobaohiem = $sobaohiem;
        $this->ghichu = $ghichu;
        $this->province_id = $province_id;
        $this->vacxin_id = $vacxin_id;
        $this->bacsi_id = $bacsi_id;
        $this->user_id = $user_id;
    }
    public function view(): View
    {
        $query = DatLichKham::where('benhvien_id',$this->benhvien_id)->orderBy('id','DESC')->take(2000);
        if(($this->from != 0) && ($this->to != 0)) 
        {
            $query = $query->whereBetween('ngaykham', [$this->from,$this->to]);
        }
        if($this->khunggio_id != 0) 
        {
            $query = $query->where('khunggio_id', $this->khunggio_id);
        }
       	if($this->chuyenkhoa_id != 0) 
        {
            $query = $query->where('chuyenkhoa_id', $this->chuyenkhoa_id);
        }
        $datlichkham = $query->get();
        $tenbenhvien = BenhVienPK::where('id',$this->benhvien_id)->first()->name;
        
        return view('pages.excel.viewExport', [    
            'datlichkham' => $datlichkham,
         	'tenbenhvien' => $tenbenhvien,
            'from' => $this->from,
            'to' => $this->to,
            'chuyenkhoa' => $this->chuyenkhoa,
            'namsinh' => $this->namsinh,
            'gioitinh' => $this->gioitinh,
            'sonha' => $this->sonha,
            'diachi' => $this->diachi,
            'mayte' => $this->mayte,
            'sobaohiem' => $this->sobaohiem,
            'ghichu' => $this->ghichu,
            'province_id' => $this->province_id,
            'vacxin_id' => $this->vacxin_id,
            'bacsi_id' => $this->bacsi_id,
            'chuyenkhoa_id' => $this->chuyenkhoa_id,
            'user_id' => $this->user_id,

        ]);
    
       
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $query = DatLichKham::where('benhvien_id',$this->benhvien_id)->orderBy('id','DESC');
		        if(($this->from != 0) && ($this->to != 0)) 
		        {
		            $query = $query->whereBetween('ngaykham', [$this->from,$this->to]);
		        }
		        if($this->khunggio_id != 0) 
		        {
		            $query = $query->where('khunggio_id', $this->khunggio_id);
		        }
		       	if($this->chuyenkhoa_id != 0) 
		        {
		            $query = $query->where('chuyenkhoa_id', $this->chuyenkhoa_id);
		        }
		        $count = $query->count();
                
                $sum = 7 + intval($this->chuyenkhoa + $this->namsinh + $this->gioitinh + $this->sonha + $this->diachi + $this->mayte + $this->sobaohiem + $this->ghichu + $this->province_id + $this->vacxin_id + $this->bacsi_id + $this->user_id);
                $last = Coordinate::stringFromColumnIndex($sum);
                $c = $count + 3;
                $cellRange = 'A3:'.$last.'3';
                $cellRange3 = 'A1:V1';
                $cellRange2 = 'A1:'.$last.'1000';
                $event->sheet->getStyle('A1:'.$last.'' . $event->sheet->getHighestRow())
                ->getAlignment()->setWrapText(true); 
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle($cellRange3)->getFont()->setSize(17);
                $event->sheet->getStyle($cellRange)->applyFromArray(
                    array(
                        'fill' => array(
                          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => array('argb' => 'B0E0E6')
                        ),
                        'font' => array(
                            'name' => 'Times New Roman',
                            'bold' => true,
                        ),
                    )
                );
                $event->sheet->getStyle($cellRange3)->applyFromArray(
                    array(
                        'font' => array(
                            'name' => 'Times New Roman',
                            'bold' => true,
                        ),
                    )
                );
                $event->sheet->getStyle($cellRange2)->applyFromArray(
                    array(
                        'font' => array(
                            'name' => 'Times New Roman',
                        ),
                    )
                );
                $event->sheet->getStyle('A3:'.$last.''.$c.'')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle($cellRange)->getAlignment()->applyFromArray(
                array('horizontal' => 'center','vertical'=> 'center')
                );
                $event->sheet->getStyle($cellRange3)->getAlignment()->applyFromArray(
                array('horizontal' => 'center')
                );
                $event->sheet->getStyle($cellRange2)->getAlignment()->applyFromArray(
                array('horizontal' => 'center')
                );

            },
        ];

    }
}
