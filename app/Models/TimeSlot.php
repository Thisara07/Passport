<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $table = 'time_slots';
    protected $primaryKey = 'Slot_ID';
    public $timestamps = true;
    
    protected $fillable = [
        'Slot_Date',
        'Start_Time',
        'End_Time',
        'Office_Branch',
        'Max_Capacity',
        'Current_Bookings',
        'Status'
    ];
    
    protected $casts = [
        'Slot_Date' => 'date',
        'Start_Time' => 'datetime:H:i:s',
        'End_Time' => 'datetime:H:i:s',
        'Max_Capacity' => 'integer',
        'Current_Bookings' => 'integer',
        'Status' => 'string',
    ];
    
    // Relationships
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'Slot_ID');
    }
}
