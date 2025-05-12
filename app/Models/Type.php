<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
     protected $table = 'types';
     protected $primarykey = 'id';
     protected $fillable = ['name', 'brand_id'];

    //  public function dut(): BelongsTo
    // {
    //     return $this->belongsTo(Dut::class,'dut');
    // }

    public function dut(): HasMany
    {
        return $this->hasMany(Dut::class, 'type_id');
    }
    
    public function inspectionType(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }
}




     

    