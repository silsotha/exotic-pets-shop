<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'employee_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Связь с сотрудником
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Вспомогательные методы проверки роли
    public function isAdmin():    bool { return $this->role === 'администратор'; }
    public function isVet():      bool { return $this->role === 'ветврач'; }
    public function isSeller():   bool { return $this->role === 'продавец'; }
}