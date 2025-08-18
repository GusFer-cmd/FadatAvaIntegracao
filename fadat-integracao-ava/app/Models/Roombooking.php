<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str; 
use App\Models\Classroom;
use App\Models\Professors;
use App\Models\Course;
use App\Models\Subject;

class Roombooking extends Model
{
    use HasFactory;

    protected $table = 'roombookings';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'day_of_week',
        'start_time',
        'end_time',
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

     public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professors::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
