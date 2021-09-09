<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_subjects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('curriculum_id')->constrained('curricula')->cascadeOnDelete();
            $table->integer('year');
            $table->integer('term');
            $table->string('code');
            $table->string('title');
            $table->integer('lec_hours');
            $table->integer('lab_hours');
            $table->integer('lec_units');
            $table->integer('lab_units');
            $table->string('prereq')->nullable();
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
        Schema::dropIfExists('curriculum_subjects');
    }
}
