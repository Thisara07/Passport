<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class Admin extends Authenticatable
{
    use Notifiable, TwoFactorAuthenticatable;
    
    protected $table = 'admin';
    protected $primaryKey = 'Admin_ID';
    public $timestamps = true;
    
    protected $fillable = [
        'Email_Address',
        'Password',
        'Contact_Number',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];
    
    protected $hidden = [
        'Password',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];
    
    protected $casts = [
        'Email_Address' => 'string',
        'Password' => 'string',
        'Contact_Number' => 'string',
    ];
    
    public function getAuthPassword()
    {
        return $this->Password;
    }
}
