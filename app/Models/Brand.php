<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $table = 'brands';
    protected $primarykey = 'id';
    protected $fillable = ['name'];

    public function dut(): HasMany
    {
        return $this->hasMany(Dut::class, 'brand_id');
    }

}