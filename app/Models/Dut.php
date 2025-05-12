<?php

namespace App\Models;
use App\Models\Category;
use App\Models\Inspection;
use App\Models\DeviceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Dut extends Model
{
	protected $table = 'duts';
	protected $primarykey = 'id';
	protected $fillable = [
		'id',
		'user_id',
		'type_id',
		'safety_class_id',
		'devicetype_id',
		'location_id',
		'brand_id',
		'date_in_use',
		'status',
		'date_out_of_use'
	];

	protected $casts = [
		'date_of_inspection' => 'date',
	];

	public function DutSafetyClassId(): BelongsTo
	{
		return $this->belongsTo(SafetyClass::class, 'safety_class_id');
	}

	public function DutDeviceTypeId(): BelongsTo
	{
		return $this->belongsTo(DeviceType::class, 'devicetype_id');
	}

	public function DutLocationId(): BelongsTo
	{
		return $this->belongsTo(Location::class, 'location_id');
	}

	public function DutBrandId(): BelongsTo
	{
		return $this->belongsTo(Brand::class, 'brand_id');
	}

	public function DutTypeId(): BelongsTo
	{
		return $this->belongsTo(Type::class, 'type_id');
	}

	public function DutUserId(): BelongsTo
	{
		return $this->belongsTo(User::class,'user_id');
	}

	public function inspections()
	{
		return $this->hasMany(Inspection::class, 'dut_id');
	}


	public function deviceType()
	{
		return $this->belongsTo(DeviceType::class);
	}


	public function DutsInCategory()
	{
		return $this->hasOneThrough(
			Category::class,
			DeviceType::class,
			'id',
			'id', 
			'devicetype_id',
			'category_id',
		);
	}

	public function inspectionLocation()
	{
		return $this->hasMany(Inspection::class,'dut_id');
	}


	public function location()
	{
		return $this->belongsTo(Location::class);
	}


	public function type()
	{
		return $this->belongsTo(Type::class);
	}


	public function brand()
	{
		return $this->belongsTo(Brand::class);
	}

	public function soort()
	{
		return $this->belongsTo(DeviceType::class);
	}

}
