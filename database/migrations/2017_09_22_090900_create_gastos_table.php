<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('concepto', 30);
            $table->float('cantidad');
            $table->string('comentario')->nullable();
            $table->date('fecha');
            $table->enum('tipo', ['fijo', 'variable', 'fijo-variable']);
            $table->timestamps();
        });

        Schema::table('gastos', function(Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });                     
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gastos');
    }
}
