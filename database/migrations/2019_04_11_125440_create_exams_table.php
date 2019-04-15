<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('studies_program_code');
            $table->string('subject_code');
            $table->string('subject_name');
            $table->integer('teacher_id');
            $table->integer('student_id');
            $table->string('group');
            $table->integer('mark')->nullable();
            $table->string('comments')->nullable();
            $table->string('settlement_type');
            $table->string('studies_form');
            $table->date('date');
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
        Schema::dropIfExists('exams');
    }
}
