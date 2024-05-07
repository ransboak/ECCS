<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'contact', 'manager_id', 'branch'];

    public function collections(){
        return $this->hasMany(Collection::class, 'customer_id');
    }
    public function manager(){
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function branchcode(){
        return $this->belongsTo(Branch::class, 'branch');
    }
    // public function collectionstoday(){
    //     return $this->hasMany(Collection::class, 'customer_id')->whereDate('created_at', Carbon::today());
    // }
}
