<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cuentas')->insert([
            ['user' => 'admin', 'password' => '$2y$10$wg.i/NVJjAfpk/FiYCjGKeE0ANkXnCix5TFzQfGwLeVAyr4S/snXq', 'nombre' => 'Administrador', 'apellido' => 'Profe', 'perfil_id' => '1'],
        ]);
    }
}
