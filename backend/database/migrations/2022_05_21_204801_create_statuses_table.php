<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('statuses', function (Blueprint $table) {
      $table->id();
      $table->string('descricao', 30)->nullable(false)->unique();
      $table->string('observacao', 100)->nullable(true);
      $table->bigInteger('usuario_cadastro')->nullable(false)->unsigned();
      $table->bigInteger('usuario_alteracao')->nullable(true)->unsigned();
      $table->timestamps();
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
    Schema::dropIfExists('statuses');
  }
}
