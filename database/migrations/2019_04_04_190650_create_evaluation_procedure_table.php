<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationProcedureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_procedure', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('studies_program_code');
            $table->string('subject_code');
            $table->integer('semester');
            $table->integer('credits');
            $table->string('evaluation_type');
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
        Schema::dropIfExists('evaluation_procedure');
    }
}
