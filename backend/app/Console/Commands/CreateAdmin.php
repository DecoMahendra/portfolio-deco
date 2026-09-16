<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

/*
  Perintah terminal: php artisan admin:create

  Satu-satunya cara membuat akun admin. Tidak ada halaman "daftar" di
  website, jadi orang luar tidak bisa membuat akun sendiri. Password
  ditanyakan langsung di terminal — tidak pernah ditulis di file mana pun.
*/
class CreateAdmin extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Membuat akun admin untuk masuk ke dashboard';

    public function handle(): int
    {
        $data = [
            'name' => $this->ask('Nama'),
            'email' => $this->ask('Email'),
            'password' => $this->secret('Password (minimal 8 karakter)'),
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        // Model User punya cast 'password' => 'hashed', jadi otomatis di-hash.
        User::create($data);

        $this->info("Akun admin {$data['email']} berhasil dibuat.");

        return self::SUCCESS;
    }
}
