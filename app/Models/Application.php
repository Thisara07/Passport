<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'application';
    protected $primaryKey = 'Application_ID';
    public $timestamps = true;
    
    protected $fillable = [
        'Applicant_ID',
        'Document_ID',
        'Full_Name',
        'Gender',
        'Date_of_Birth',
        'Phone_Number',
        'NIC',
        'Address',
        'Street',
        'City',
        'Province',
        'Status',
        'Remarks'
    ];
    
    protected $casts = [
        'Date_of_Birth' => 'date',
        'Status' => 'string',
        'Remarks' => 'string',
    ];
    
    // Relationships
    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'Applicant_ID');
    }
    
    public function document()
    {
        return $this->belongsTo(Document::class, 'Document_ID');
    }
    
    public function passport()
    {
        return $this->hasOne(Passport::class, 'Application_ID');
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class, 'Application_ID');
    }
}
