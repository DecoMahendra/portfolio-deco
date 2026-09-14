<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
  Model = perwakilan satu tabel dalam bentuk kode.
  Profile mewakili tabel "profiles". Lewat model ini kita bisa membaca dan
  mengubah data tanpa menulis SQL: Profile::first(), $profile->save(), dst.
*/
class Profile extends Model
{
    /*
      $fillable = daftar kolom yang BOLEH diisi sekaligus lewat array,
      misalnya Profile::create([...]) atau $profile->update([...]).

      Kolom di luar daftar ini ditolak. Ini pengaman: kalau nanti ada form
      yang mengirim kolom tak terduga (misalnya "is_admin"), tidak ikut masuk.
    */
    protected $fillable = [
        'name',
        'role',
        'location',
        'availability',
        'tagline',
        'bio',
        'photo_alt',
    ];
}
