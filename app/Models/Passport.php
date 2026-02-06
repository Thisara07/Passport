<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    protected $table = 'passport';
    protected $primaryKey = 'Passport_ID';
    public $timestamps = true;
    
    protected $fillable = [
        'Officer_ID',
        'Application_ID',
        'Passport_Status',
        'Issue_Date'
    ];
    
    protected $casts = [
        'Issue_Date' => 'date',
        'Passport_Status' => 'string',
    ];
    
    // Relationships
    public function officer()
    {
        return $this->belongsTo(Officer::class, 'Officer_ID');
    }
    
    public function application()
    {
        return $this->belongsTo(Application::class, 'Application_ID');
    }
}
