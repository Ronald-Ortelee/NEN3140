<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SafetyClass extends Model
{
    protected $table = 'safety_classes';
    protected $primarykey = 'id';
    protected $fillable = ['name'];

    // public function dut(): BelongsTo
    // {
    //     return $this->belongsTo(Dut::class,'dut');
    // }


        public function dut(): HasMany
    {
        return $this->hasMany(Dut::class, 'safety_class_id');
    }
}
