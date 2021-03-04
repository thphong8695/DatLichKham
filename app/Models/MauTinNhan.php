<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MauTinNhan extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'mautinnhans';
    protected $fillable = [
    	'content', 
    	'benhvien_id', 
    	
    ];
    protected static $logName = 'Mẫu SMS';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
    	'content', 
        'BenhVienPK.name'
    ];
    public function BenhVienPK()
    {
        return $this->belongsTo('App\Models\BenhVienPK','benhvien_id','id');
    }
}
