<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str; 

class Roombooking extends Model
{
    use HasFactory;

    protected $table = 'roombookings';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'start_date_time',
        'end_date_time',
        'professor_id',
        'subject_id',
        'classroom_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
