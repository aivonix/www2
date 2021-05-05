<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = ['charity_id', 'user_id', 'created_at', 'stage'];
    public $timestamps = false;

    public function charity(){
        return $this->belongsTo(Charity::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
