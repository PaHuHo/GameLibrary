<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameModel extends Model
{
    use HasFactory;
    protected $table="games";
    protected $fillable = [
        'name',
        'description',
        'image',
        'rating',
        'status',
        'is_delete',
    ];
    public function categories()
    {
        return $this->belongsToMany(CategoryModel::class,'category_game','game_id','category_id');
    }
}
