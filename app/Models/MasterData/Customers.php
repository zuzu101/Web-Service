<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Region\Province;
use App\Models\Region\Regency;
use App\Models\Region\District;
use App\Models\Region\Village;

class Customers extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $guarded = ['id'];
    
    // Updated fillable fields to include IndoRegion fields
    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'address', // Keep old address for backward compatibility
        'province_id',
        'regency_id', 
        'district_id',
        'village_id',
        'street_address',
        'status'
    ];

    // Relationship - hasMany device repairs
    public function deviceRepairs()
    {
        return $this->hasMany(\App\Models\MasterData\DeviceRepair::class, 'customer_id');
    }

    // IndoRegion relationships
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }

    // Accessor for full address
    public function getFullAddressAttribute()
    {
        $addressParts = [];
        
        if ($this->street_address) {
            $addressParts[] = $this->street_address;
        }
        
        if ($this->village) {
            $addressParts[] = $this->village->name;
        }
        
        if ($this->district) {
            $addressParts[] = $this->district->name;
        }
        
        if ($this->regency) {
            $addressParts[] = $this->regency->name;
        }
        
        if ($this->province) {
            $addressParts[] = $this->province->name;
        }
        
        return implode(', ', $addressParts) ?: $this->address; // Fallback to old address
    }
}
