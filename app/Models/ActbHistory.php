<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActbHistory extends Model
{   protected $connection = 'oracle';

    protected $guarded = [];
 
    protected $hidden = ['password', 'token',];
 
    protected $table = 'actb_history';

    
    use HasFactory;
}
