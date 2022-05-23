<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TasksSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('taskses')->insert(
      ['descricao' => 'Tarefa1', 'observacao' => 'Tarefa 1 de teste', 
       'id_status' => 1, 'usuario_cadastro' => '2', 
       'created_at' => date('Y-m-d H:i:s')
    ]);

    DB::table('taskses')->insert(
      ['descricao' => 'Tarefa2', 'observacao' => 'Tarefa 2 de teste', 
       'id_status' => 1, 'usuario_cadastro' => '2', 
       'created_at' => date('Y-m-d H:i:s')
    ]);    

    DB::table('taskses')->insert(
      ['descricao' => 'Tarefa3', 'observacao' => 'Tarefa 3 de teste', 
       'id_status' => 2, 'usuario_cadastro' => '2', 
       'created_at' => date('Y-m-d H:i:s')
    ]);    

    DB::table('taskses')->insert(
      ['descricao' => 'Tarefa4', 'observacao' => 'Tarefa 4 de teste', 
       'id_status' => 2, 'usuario_cadastro' => '2', 
       'created_at' => date('Y-m-d H:i:s')
    ]);

    DB::table('taskses')->insert(
      ['descricao' => 'Tarefa5', 'observacao' => 'Tarefa 5 de teste', 
       'id_status' => 3, 'usuario_cadastro' => '2', 
       'created_at' => date('Y-m-d H:i:s')
    ]);  
  }
}
