<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['branch_code', 'branch_name'];

    public function users(){
        return $this->hasMany(User::class, 'branch');
    }
    public function customers(){
        return $this->hasMany(Customer::class, 'branch');
    }
    
    public function collection(){
        return $this->hasMany(Collection::class, 'branch');
    }
}
