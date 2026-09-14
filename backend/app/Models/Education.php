<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    /*
      Laravel biasanya menebak nama tabel dari nama model: Education -> educations.
      Tapi kata "education" tidak punya bentuk jamak, dan migration-nya
      membuat tabel bernama "education". Jadi nama tabelnya ditulis eksplisit
      supaya tidak salah tebak.
    */
    protected $table = 'education';

    protected $fillable = ['school', 'program', 'period', 'sort_order'];
}
