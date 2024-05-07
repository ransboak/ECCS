<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Req extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'contact', 'operator_id', 'status'];

    public function operator(){
        return $this->belongsTo(User::class, 'operator_id');
    }
}
