<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TinNhan extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'tinnhans';
    protected $fillable = [
    	'phone', 
    	'content', 
    	'benhvien_id', 
    	'user_id', 
    	'datlichkham_id'
    ];
    protected static $logName = 'SMS';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'phone', 
    	'content', 
    	'datlichkham_id',
    	'User.username', 
        'BenhVienPK.name'
    ];
    public function BenhVienPK()
    {
        return $this->belongsTo('App\Models\BenhVienPK','benhvien_id','id');
    }
    public function DatLichKham()
    {
        return $this->belongsTo('App\Models\DatLichKham','datlichkham_id','id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
