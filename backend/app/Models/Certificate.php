<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasSortOrder;

    protected $fillable = ['name', 'organizer', 'year', 'sort_order'];
}
