<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

  
    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function productWarehouse()
    {
        return $this->hasMany(ProductWarehouse::class);
    }

  
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

  
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}

