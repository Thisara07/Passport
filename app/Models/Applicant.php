<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class Applicant extends Authenticatable
{
    use Notifiable, TwoFactorAuthenticatable;
    
    protected $table = 'applicant';
    protected $primaryKey = 'Applicant_ID';
    public $timestamps = true;
    
    protected $fillable = [
        'Name',
        'Email',
        'Password',
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
        'Name' => 'string',
        'Email' => 'string',
        'Password' => 'string',
    ];
    
    // Relationships
    public function applications()
    {
        return $this->hasMany(Application::class, 'Applicant_ID');
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'Applicant_ID');
    }
    
    public function getAuthPassword()
    {
        return $this->Password;
    }
    
    public function getAuthIdentifierName()
    {
        return 'Applicant_ID';
    }
}
