<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Institute extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = "institutes";
    protected $fillable = [
        'name',
        'email',
        'phone',
        'slug',
        'status',
        'description'
    ];

    public function fields() : \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Field::class);
    }
}
