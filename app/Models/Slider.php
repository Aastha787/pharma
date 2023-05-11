<?php

namespace App\Models;

//use App\Models\Slider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 */
class Slider extends Model
{
    use HasFactory;
    protected $table = 'sliders';
   protected $fillable = [
        'title',
        'description',
        'image'
    ];
}
