<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'Document_ID';
    public $timestamps = true;
    
    protected $fillable = [
        'NIC_card',
        'Birth_Certificate',
        'Nationality',
        'Photo',
        'verification_status',
        'file_path'
    ];
    
    protected $casts = [
        'verification_status' => 'string',
    ];
    
    // Relationships
    public function application()
    {
        return $this->hasOne(Application::class, 'Document_ID');
    }
}
