<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str; 

class Classroom extends Model
{
    use HasFactory;

    protected $table = 'classrooms';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'class_number',
        'person_class',
        'academic_building',
        'url'
    ];

    // Gerar UUID ao criar
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
