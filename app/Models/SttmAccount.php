<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SttmAccount extends Model
{
    protected $connection = 'oracle';

    protected $guarded = [];
 
    protected $hidden = ['password', 'token',];
 
    protected $table = 'sttm_cust_personal';

    
    use HasFactory;
}
