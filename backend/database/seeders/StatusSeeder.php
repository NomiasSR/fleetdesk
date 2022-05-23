<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('statuses')->insert(['descricao' => 'Aberto', 'observacao' => 'Status "Em aberto"', 
      'usuario_cadastro' => '1', 'created_at' => date('Y-m-d H:i:s')]);
    DB::table('statuses')->insert(['descricao' => 'Fechado', 'observacao' => 'Status "Fechado"', 
      'usuario_cadastro' => '1', 'created_at' => date('Y-m-d H:i:s')]);
    DB::table('statuses')->insert(['descricao' => 'Concluído', 'observacao' => 'Status "Concluído"', 
      'usuario_cadastro' => '1', 'created_at' => date('Y-m-d H:i:s')]);      
    DB::table('statuses')->insert(['descricao' => 'Pausado', 'observacao' => 'Status "Em pausa"', 
      'usuario_cadastro' => '1', 'created_at' => date('Y-m-d H:i:s')]);
    DB::table('statuses')->insert(['descricao' => 'Cancelado', 'observacao' => 'Status "Cancelado"', 
      'usuario_cadastro' => '1', 'created_at' => date('Y-m-d H:i:s')]);
    DB::table('statuses')->insert(['descricao' => 'Outros', 'observacao' => 'Status "Outros"', 
      'usuario_cadastro' => '1', 'created_at' => date('Y-m-d H:i:s')]);
  }
}
