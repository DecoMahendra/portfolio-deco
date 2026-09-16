<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasSortOrder;

    protected $fillable = ['role', 'company', 'period', 'description', 'sort_order'];
}
