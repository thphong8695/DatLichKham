<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
class SuDungVacXin extends Model
{
    use HasFactory;
    use Sluggable, LogsActivity;
    protected $connection = 'mysql';
    protected $table = 'sudung_vacxins';
    protected $fillable = [
    	'name',
		'slug',
        'status'
    ];
    protected static $logName = 'Thời hạn sử dụng vắc xin';
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
    public function VacXin()
    {
        return $this->hasMany('App\Models\VacXin','sdvacxin_id','id');
    }
}
