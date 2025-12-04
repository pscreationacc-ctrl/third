<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedsyncModel extends Model
{
    protected $casts = [
    'tags' => 'array',
];
  protected $primaryKey = 'user_id'; // Tell Laravel the PK is user_id
}
