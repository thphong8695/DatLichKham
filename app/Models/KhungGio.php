<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class KhungGio extends Model
{

    use HasFactory, LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'khunggios';
    protected $fillable = [
    	'name',
		'soluong',
		'benhvien_id'
    ];
    protected static $logName = 'Khung giờ';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'name',
        'soluong',
        'BenhVienPK.name'
    ];

    public function BenhVienPK()
    {
        return $this->belongsTo('App\Models\BenhVienPK','benhvien_id','id');
    }
    public function DatLichKham()
    {
        return $this->hasMany('App\Models\DatLichKham','khunggio_id','id');
    }
    public function TuyChinhKhungGio()
    {
        return $this->hasMany('App\Models\TuyChinhKhungGio','khunggio_id','id');
    }
}
