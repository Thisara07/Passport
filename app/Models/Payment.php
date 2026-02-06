<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'Payment_ID';
    public $timestamps = true;
    
    protected $fillable = [
        'Application_ID',
        'Amount',
        'Payment_Status',
        'Payment_Method',
        'Date'
    ];
    
    protected $casts = [
        'Amount' => 'decimal:2',
        'Date' => 'date',
        'Payment_Status' => 'string',
        'Payment_Method' => 'string',
    ];
    
    // Relationships
    public function application()
    {
        return $this->belongsTo(Application::class, 'Application_ID');
    }
}
