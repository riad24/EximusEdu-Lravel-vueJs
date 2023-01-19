<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Field extends Model
{
    use HasFactory;

    protected $table = "fields";
    protected $fillable = [
        'title',
        'field_type',
        'type',
        'institute_id',
        'slug',
        'status',

    ];


    public function institute() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

}
