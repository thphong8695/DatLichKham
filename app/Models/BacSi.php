<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BacSi extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'bacsis';
    protected $fillable = [
    	'name',
        'chuyenkhoa_id',
		'benhvien_id'
    ];
    protected static $logName = 'Bác sĩ';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'name',
        'ChuyenKhoa.name',
        'BenhVienPK.name'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function BenhVienPK()
    {
        return $this->belongsTo('App\Models\BenhVienPK','benhvien_id','id');
    }
    public function ChuyenKhoa()
    {
        return $this->belongsTo('App\Models\ChuyenKhoa','chuyenkhoa_id','id');
    }
    public function DatLichKham()
    {
        return $this->hasMany('App\Models\DatLichKham','bacsi_id','id');
    }
}
