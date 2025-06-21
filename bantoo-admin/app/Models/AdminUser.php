<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class AdminUser extends Authenticatable
{
  use HasFactory, Notifiable;

  // protected $table = 'admin_users';

  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function initials(): string
  {
    return Str::of($this->name)
      ->explode(' ')
      ->take(2)
      ->map(fn($word) => Str::substr($word, 0, 1))
      ->implode('');
  }
}
