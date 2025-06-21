<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
  protected $fillable = [
    'owner',
    'title',
    'category',
    'location',
    'photo',
    'description',
    'updateplan',
    'videolink',
    'targetfunding',
    'deadline',
    'accounttype',
    'accountbank',
    'accountno',
    'accountholder',
    'address',
    ];

  public function owner(): BelongsTo
  {
    return $this->belongsTo(User::class, 'owner', 'id');
  }

  public function donations(): HasMany
  {
    return $this->HasMany(Donation::class);
  }

  public function scopeIsActive($query)
  {
    return $query->where('status', '=', 'ACTIVE');
  }

  public function scopeOwnedBy($query, int $userId)
  {
    return $userId == 0 ? $query : $query->where('owner', '=', $userId);
  }

  public function scopeOfCategory($query, $category)
  {
    return $category == 'ALL' ? $query : $query->where('category', '=', $category);
  }
  public function scopeWithStatus($query, $status)
  {
    return $status == 'ALL' ? $query : $query->where('status', '=', $status);
  }
}
