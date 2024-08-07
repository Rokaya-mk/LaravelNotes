<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable=['title','content','user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function getFormattedDate()
    {
        return $this->created_at->diffForhumans();
    }
}
