<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class VacXin extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'vacxins';
    protected $fillable = [
    	'name', 
    	'nguabenh', 
    	'giatien', 
    	'mienphi', 
    	'soluong', 
    	'ngayapdung', 
    	'stt', 
    	'ghichu', 
        'status',
    	'sdvacxin_id', 
    	'benhvien_id'
    ];
    protected $dates = ['ngayapdung'];
    protected static $logName = 'Vắc-xin - Thuốc';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'name', 
    	'nguabenh', 
    	'giatien', 
    	'mienphi', 
    	'soluong', 
    	'ngayapdung', 
    	'stt', 
    	'ghichu', 
        'status',
    	'SuDungVacXin.name', 
        'BenhVienPK.name'
    ];
  
    public function BenhVienPK()
    {
        return $this->belongsTo('App\Models\BenhVienPK','benhvien_id','id');
    }
    public function SuDungVacXin()
    {
        return $this->belongsTo('App\Models\SuDungVacXin','sdvacxin_id','id');
    }
    public function DatLichKham()
    {
        return $this->belongsToMany('App\Models\DatLichKham','datlichkham_has_vacxins','vacxin_id','datlichkham_id');
    }
}
