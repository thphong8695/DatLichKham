<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
class BenhVienPK extends Model
{
    use HasFactory;
    use Sluggable, LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'benhvien_pks';
    protected $fillable = [
    	'name',
		'slug',
        'status'
    ];
    protected static $logName = 'Bệnh viện - phòng khám';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'name',
        'slug',
        'status'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function ChuyenKhoa()
    {
        return $this->hasMany('App\Models\ChuyenKhoa','benhvien_id','id');
    }
    public function DatLichKham()
    {
        return $this->hasMany('App\Models\DatLichKham','benhvien_id','id');
    }
    public function KhungGio()
    {
        return $this->hasMany('App\Models\KhungGio','benhvien_id','id');
    }
    public function TuyChinhKhungGio()
    {
        return $this->hasMany('App\Models\TuyChinhKhungGio','benhvien_id','id');
    }
    public function TuyChinhNgayOff()
    {
        return $this->hasMany('App\Models\TuyChinhNgayOff','benhvien_id','id');
    }
}
