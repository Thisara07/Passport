<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'Appointment_ID';
    public $timestamps = true;
    
    protected $fillable = [
        'Applicant_ID',
        'Slot_ID',
        'Appointment_Date',
        'Appointment_Time',
        'NIC_Number',
        'Office_Branch',
        'Status',
        'Cancel_Reason'
    ];
    
    protected $casts = [
        'Appointment_Date' => 'date',
        'Appointment_Time' => 'datetime:H:i:s',
        'Status' => 'string',
    ];
    
    // Relationships
    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'Applicant_ID');
    }
    
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class, 'Slot_ID');
    }
}
