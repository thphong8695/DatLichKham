<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TuyChinhDatLich extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'tuychinh_datlichs';
    protected $fillable = [
    	'namsinh', 
    	'gioitinh', 
    	'sonha', 
    	'diachi', 
    	'mayte', 
    	'sobaohiem', 
    	'ghichu', 
    	'province_id', 
    	'vacxin_id', 
    	'bacsi_id', 
    	'chuyenkhoa_id',
    	'sms_id', 
    	'benhvien_id'
    ];
    protected static $logName = 'Tùy chỉnh form đặt lịch';
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['updated'];
    protected static $logAttributes = [
        'namsinh', 
    	'gioitinh', 
    	'sonha', 
    	'diachi', 
    	'mayte', 
    	'sobaohiem', 
    	'ghichu', 
    	'province_id', 
    	'vacxin_id', 
    	'bacsi_id', 
    	'chuyenkhoa_id',
    	'sms_id', 
        'BenhVienPK.name'
    ];
    public function BenhVienPK()
    {
        return $this->belongsTo('App\Models\BenhVienPK','benhvien_id','id');
    }
}
