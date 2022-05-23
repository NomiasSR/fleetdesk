<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('taskses', function (Blueprint $table) {
      $table->id();
      $table->string('descricao', 400)->nullable(false)->unique();
      $table->string('observacao', 2000)->nullable(true);
      $table->bigInteger('usuario_cadastro')->nullable(false)->unsigned();
      $table->bigInteger('usuario_alteracao')->nullable(true)->unsigned();
      $table->timestamps();
      $table->bigInteger('id_status')->unsigned();
      $table->foreign('id_status')->references('id')->on('statuses')->onDelete('restrict');
      $table->foreign('usuario_cadastro')->references('id')->on('users')->onDelete('restrict');
      $table->foreign('usuario_alteracao')->references('id')->on('users')->onDelete('restrict');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('taskses');
  }
}
