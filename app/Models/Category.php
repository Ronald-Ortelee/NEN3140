<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dut;
use App\Models\DeviceType;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Category extends Model
{
	protected $casts = [
    'category' => 'string',
    'category_remark' => 'string',
    'example' => 'string',
];


    protected $table = 'categories';
    protected $primarykey = 'id';
    protected $fillable = [
        'category',
        'category_remark',
        'example',
        'inspection_interval'
    ];

    public function deviceTypes(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class);
    }


    // public function dutsInCategory() {
    //     return $this->hasManyThrough(Dut::class, DeviceType::class);
    // }







}
