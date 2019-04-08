<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyPlansFullTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_plans_full_time', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('studies_program_code');
            $table->string('studies_program_name');
            $table->string('studies_form');
            $table->string('subject_name');
            $table->string('subject_code')->nullable();
            $table->string('subject_status');
            $table->integer('credits_sem1')->nullable();
            $table->string('evaluation_type_sem1')->nullable();
            $table->integer('credits_sem2')->nullable();
            $table->string('evaluation_type_sem2')->nullable();
            $table->integer('credits_sem3')->nullable();
            $table->string('evaluation_type_sem3')->nullable();
            $table->integer('credits_sem4')->nullable();
            $table->string('evaluation_type_sem4')->nullable();
            $table->integer('credits_sem5')->nullable();
            $table->string('evaluation_type_sem5')->nullable();
            $table->integer('credits_sem6')->nullable();
            $table->string('evaluation_type_sem6')->nullable();
            $table->integer('ECTS_credits');
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
        Schema::dropIfExists('study_plans_full_time');
    }
}
