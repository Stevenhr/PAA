<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TipoContratoTablaSeeder::class);
        $this->call(RubroTablaSeeder::class);
        $this->call(ModalidadTablaSeeder::class);
        $this->call(FuenteTablaSeeder::class);
    }
}
