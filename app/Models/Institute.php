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

    public function getImageAttribute() : string
    {
        if (!empty($this->getFirstMediaUrl('institute'))) {
            return asset($this->getFirstMediaUrl('institute'));
        }
        return asset('images/no-image-available.png');
    }

    public function getImagesAttribute() : array
    {
        $response = [];
        if (!empty($this->getFirstMediaUrl('institute'))) {
            $images = $this->getMedia('institute');
            foreach ($images as $image) {
                $response[] = $image['original_url'];
            }
        }
        return $response;
    }
}
