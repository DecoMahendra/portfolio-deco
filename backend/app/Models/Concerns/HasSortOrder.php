<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/*
  Trait = potongan kode yang bisa "ditempel" ke banyak class dengan `use`.
  Yang ini mengurus kolom sort_order supaya selalu unik dan rapat (0,1,2,...),
  seperti menyisipkan ke dalam daftar:

    - simpan di posisi N  : yang tadinya di N ke bawah bergeser satu ke bawah
    - pindah posisi       : dikeluarkan dari posisi lama, disisipkan di posisi baru
    - hapus               : yang di bawahnya naik satu, tidak ada celah

  Di database sort_order mulai dari 0. Di form dan tampilan dipakai "posisi"
  yang mulai dari 1 supaya lebih wajar dibaca. Konversinya (+1 / -1) hanya
  terjadi di sini dan di view — controller tidak perlu tahu.

  Method yang dipanggil controller: createAtPosition, updateAtPosition,
  deleteAndCloseGap. Semuanya mengharapkan kunci 'position' di $attributes.
*/
trait HasSortOrder
{
    /*
      "Saudara" = baris-baris yang berbagi satu urutan.
      Bawaan: seluruh tabel. Skill menimpanya supaya hanya di dalam kelompoknya.
    */
    protected function sortSiblings(): Builder
    {
        return static::query();
    }

    public static function createAtPosition(array $attributes): static
    {
        $position = Arr::pull($attributes, 'position');
        $model = new static($attributes);

        // Posisi paling bawah yang mungkin = jumlah saudara + 1 (ditaruh di akhir).
        $index = min($position, $model->sortSiblings()->count() + 1) - 1;

        $model->sortSiblings()->where('sort_order', '>=', $index)->increment('sort_order');
        $model->sort_order = $index;
        $model->save();

        return $model;
    }

    public function updateAtPosition(array $attributes): void
    {
        $position = Arr::pull($attributes, 'position');
        $this->fill($attributes);

        $index = min($position, $this->sortSiblings()->count()) - 1;

        if ($index !== $this->sort_order) {
            // 1. Keluarkan dari posisi lama: yang di bawahnya naik satu.
            $this->sortSiblings()->whereKeyNot($this->getKey())
                ->where('sort_order', '>', $this->sort_order)->decrement('sort_order');

            // 2. Sisipkan di posisi baru: yang di posisi itu ke bawah turun satu.
            $this->sortSiblings()->whereKeyNot($this->getKey())
                ->where('sort_order', '>=', $index)->increment('sort_order');

            $this->sort_order = $index;
        }

        $this->save();
    }

    public function deleteAndCloseGap(): void
    {
        $this->delete();

        $this->sortSiblings()->where('sort_order', '>', $this->sort_order)->decrement('sort_order');
    }
}
