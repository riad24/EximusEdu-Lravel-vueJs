<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    use HasFactory;

    protected $table = "students";
    protected $fillable = [
        'name',
        'class_name',
        'email',
        'phone',
        'status',
        'institute_id',
    ];

    public function institute() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

}
