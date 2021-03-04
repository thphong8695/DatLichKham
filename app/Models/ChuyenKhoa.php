<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;

class ChuyenKhoa extends Model
{
    use HasFactory;
    use Sluggable, LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'chuyenkhoas';
    protected $fillable = [
    	'name',
		'slug',
		'benhvien_id'
    ];
    protected static $logName = 'Chuyên khoa';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'name',
        'slug',
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
    public function DatLichKham()
    {
        return $this->hasMany('App\Models\DatLichKham','chuyenkhoa_id','id');
    }
    public function BacSi()
    {
        return $this->hasMany('App\Models\BacSi','chuyenkhoa_id','id');
    }
}
