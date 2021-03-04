<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DatLichKham extends Model
{
    use HasFactory, LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'datlichkhams';
    protected $fillable = [
    	'name',
    	'namsinh',
    	'gioitinh',
    	'phone',
    	'sonha',
    	'diachi',
    	'mayte',
    	'sobaohiem',
    	'ghichu',
    	'ngaykham',
    	'khunggio_id',
    	'benhvien_id',
    	'chuyenkhoa_id',
        'province_id',
        'bacsi_id',
    	'user_id',
    ];
    protected $dates = ['ngaykham'];
    // protected $dateFormat = 'Y-m-d H:i:s';
    protected $casts = [
        'ngaykham' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected static $logName = 'Đặt lịch khám';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'name',
        'namsinh',
        'gioitinh',
        'phone',
        'sonha',
        'diachi',
        'mayte',
        'sobaohiem',
        'ghichu',
        'ngaykham',
        'KhungGio.name',
        'BenhVienPK.name',
        'ChuyenKhoa.name',
        'BacSi.name',
        'Province.name',
        'user.username',
        'created_at'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function BenhVienPK()
    {
        return $this->belongsTo('App\Models\BenhVienPK','benhvien_id','id');
    }
    public function KhungGio()
    {
        return $this->belongsTo('App\Models\KhungGio','khunggio_id','id');
    }
    public function ChuyenKhoa()
    {
        return $this->belongsTo('App\Models\ChuyenKhoa','chuyenkhoa_id','id');
    }
    public function BacSi()
    {
        return $this->belongsTo('App\Models\BacSi','bacsi_id','id');
    }
    public function Province()
    {
        return $this->belongsTo('HoangPhi\VietnamMap\Models\Province','province_id','id');
    }
    public function VacXin()
    {
        return $this->belongsToMany('App\Models\VacXin','datlichkham_has_vacxins','datlichkham_id','vacxin_id');
    }

    public function TinNhan()
    {
        return $this->hasOne('App\Models\TinNhan','datlichkham_id','id');
    }

    public function scopeStatus($query)
    {
        return $query->where('status',1);
    }
    
    public function getStatusBenhVien()
    {
        return $query->whereHas('BenhVienPK',function($q)
        {
            $q->where("status",1);
        });
    }
}
