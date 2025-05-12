<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DeviceType;
use App\Models\User;
use App\Models\Dut;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\hasOneThrough;
use App\Enums\PassFail;
use App\Enums\Lekstroom;
use App\Enums\InspectionResult;

class Inspection extends Model
{
	protected $table = 'inspections';
	protected $primarykey = 'id';
	protected $fillable = [
		'id',
		'user_id',
		'dut_id',
		'date_of_inspection',
		'visual_inspection',
		'visual_inspection_result',
		'isolation_resistance',
		'isolation_resistance_result',
		'earth_conductor_resistance',
		'earth_conductor_resistance_result',
		'leakage_current',
		'leakage_current_type',
		'leakage_current_result',
		'functional_test_result',
		'inspection_result',
		'remarks'
	];

	protected $casts = [
		'pass_fail' =>  PassFail::class,
		'lekstroom_type' =>  Lekstroom::class,
		'inspection_result' =>  InspectionResult::class,
	];


	public function InspectionDutId(): BelongsTo
	{
		return $this->belongsTo(Dut::class,'dut_id');
	}


	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	
	public function inspectionLocation()
	{
		return $this->hasOneThrough(
			Location::class,
			Dut::class,
			'id',
			'id', 
			'dut_id',
			'location_id',
		);
	}

	public function inspectionType()
	{
		return $this->hasOneThrough(
			Type::class,
			Dut::class,
			'id',
			'id', 
			'dut_id',
			'type_id',
		);
	}


	public function inspectionDeviceType()
	{
		return $this->hasOneThrough(
			DeviceType::class,
			Dut::class,
			'id',
			'id', 
			'dut_id',
			'devicetype_id',
		);
	}

}



