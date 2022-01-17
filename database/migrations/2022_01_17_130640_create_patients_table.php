<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->date('date_of_birth');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('service_id');
            $table->longText('comments');
            $table->timestamps();

            $table->foreign('gender_id')
                ->references('id')
                ->on('genders');

            $table->foreign('service_id')
                ->references('id')
                ->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
