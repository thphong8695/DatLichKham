<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TuyChinhKhungGio extends Model
{
    use HasFactory, LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'tuychinh_khunggios';
    protected $fillable = [
    	'ngaydat', 
    	'soluong', 
    	'status', 
    	'khunggio_id', 
    	'benhvien_id'
    ];
    protected static $logName = 'Tùy chỉnh khung giờ';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'ngaydat', 
        'soluong', 
        'status', 
        'KhungGio.name', 
        'BenhVienPK.name'
    ];
    protected $dates = ['ngaydat'];

    public function BenhVienPK()
    {
        return $this->belongsTo('App\Models\BenhVienPK','benhvien_id','id');
    }
    public function KhungGio()
    {
        return $this->belongsTo('App\Models\KhungGio','khunggio_id','id');
    }

}
