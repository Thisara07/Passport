<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Officer extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'officer';
    protected $primaryKey = 'Officer_ID';
    public $timestamps = true;
    
    protected $fillable = [
        'Full_Name',
        'Role',
        'Email_Address',
        'Password',
        'Contact_Number'
    ];
    
    protected $hidden = [
        'Password',
    ];
    
    protected $casts = [
        'Full_Name' => 'string',
        'Role' => 'string',
        'Email_Address' => 'string',
        'Password' => 'string',
        'Contact_Number' => 'string',
    ];
    
    // Relationships
    public function passports()
    {
        return $this->hasMany(Passport::class, 'Officer_ID');
    }
    
    public function getAuthPassword()
    {
        return $this->Password;
    }
}
