<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Result extends Model
{
    protected $table = 'results';
    protected $primarykey = 'id';
    protected $fillable = ['id','name'];


    public function result_class_visual_inspection_result(): HasMany
    {
        return $this->hasMany(Dut::class, 'visual_inspection_result_id');
    }

    public function result_class_isolation_resistance_result(): HasMany
    {
        return $this->hasMany(Dut::class, 'isolation_resistance_result_id');
    }

    public function result_class_earth_conductor_resistance_result(): HasMany
    {
        return $this->hasMany(Dut::class, 'earth_conductor_resistance_result_id');
    }

    public function result_class_real_leakage_current_result(): HasMany
    {
        return $this->hasMany(Dut::class, 'real_leakage_current_result_id');
    }

    public function result_class_replacement_leakage_current_result(): HasMany
    {
        return $this->hasMany(Dut::class, 'replacement_leakage_current_result_id');
    }




}
