<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StudentField extends Model
{
    use HasFactory;

    protected $table = "student_fields";
    protected $fillable = [
        'field_name',
        'field_value',
        'field_id',
        'student_id',
        'institute_id',
    ];

    public function institute() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
    public function field() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

}
