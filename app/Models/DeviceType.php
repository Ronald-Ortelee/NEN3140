<?php

namespace App\Models;
use App\Models\Category;
use App\Models\Dut;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class DeviceType extends Model
{
    protected $table = 'device_types';
    protected $primarykey = 'id';
    protected $fillable = [
        'name',
        'category_id'
    ];


    public function duts()
    {
        return $this->hasMany(Dut::class,'name');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function deviceType(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

}

