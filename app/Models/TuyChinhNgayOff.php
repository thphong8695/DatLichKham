<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TuyChinhNgayOff extends Model
{
    use HasFactory, LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'tuychinh_ngayoffs';
    protected $fillable = [
    	'ngayoff', 
    	'status', 
    	'benhvien_id'
    ];
    protected static $logName = 'TÙy chỉnh ngày off';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'ngayoff', 
        'status', 
        'BenhVienPK.name'
    ];
    // protected $dates = ['ngayoff'];
    // protected $casts = [
    //     'ngayoff'  => 'date:Y-m-d',
    // ];
    public function BenhVienPK()
    {
        return $this->belongsTo('App\Models\BenhVienPK','benhvien_id','id');
    }
}
