<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
  protected $fillable = [
    'status',
  ];

  public function scopeIsPending($query)
  {
    return $query->where('status', '=', 'ACTIVE');
  }
}
