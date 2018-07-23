<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airs', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('userId');
          $table->integer('airConditionerId');
          $table->enum('serviceType', ['repair', 'wash']);
          $table->dateTime('datetimeRequired');
          $table->string('userName');
          $table->string('mobile');
          $table->text('place');
          $table->string('airConditionerImg');
          $table->string('airConditionerName');
          $table->string('problemImg');
          $table->text('problemText');
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
        Schema::dropIfExists('airs');
    }
}
