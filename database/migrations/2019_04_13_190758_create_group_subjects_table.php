<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('studies_program_code');
            $table->string('studies_form');
            $table->string('group');
            $table->string('subject_code')->nullable();
            $table->string('subject_name');
            $table->string('subject_status');
            $table->integer('credits');
            $table->string('evaluation_type');
            $table->integer('semester');
            $table->integer('teacher_id')->nullable();
            $table->string('teacher_name')->nullable();
            $table->string('teacher_last_name')->nullable();
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
        Schema::dropIfExists('group_subjects');
    }
}
