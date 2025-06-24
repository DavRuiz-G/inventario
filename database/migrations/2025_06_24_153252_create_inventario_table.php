<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioTable extends Migration
{
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id')->unique();
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });

        // Si ya tienes productos, inicializa el inventario con la cantidad_inicial
        \DB::table('productos')->get()->each(function ($producto) {
            \DB::table('inventario')->insert([
                'producto_id' => $producto->id,
                'stock' => $producto->cantidad_inicial,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventario');
    }
}