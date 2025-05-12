<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $table = 'locations';
    protected $primarykey = 'id';
    protected $fillable = ['name'];

    // public function dut(): BelongsTo
    // {
    //     return $this->belongsTo(Dut::class,'dut');
    // }

    public function dut(): HasMany
    {
        return $this->hasMany(Dut::class, 'location_id');
    }

    public function inspectionLocation(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }
}
