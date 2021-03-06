<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->unique();
            $table->text('detail')->nullable();
            $table->date('start_date')->default(now()->toDateString());
            $table->integer('stage_id')->unsigned();
            $table->date('end_date')->nullable();
            $table->date('completed')->nullable();

//            $table->foreign('stage_id')
//                ->references('id')
//                ->on('stages')
//                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
