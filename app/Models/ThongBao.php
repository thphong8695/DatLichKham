<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class ThongBao extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'thongbaos';
    protected $fillable = [
    	'thongbao_datlich',
		'thongbao_vacxin',
    ];
    protected static $logName = 'Tùy chỉnh thông báo';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'thongbao_datlich',
        'thongbao_vacxin',
    ];
  
}
