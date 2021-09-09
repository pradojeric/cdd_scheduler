<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('curriculum_id')->constrained('curricula')->cascadeOnDelete();
            $table->integer('year');
            $table->integer('term');
            $table->string('code');
            $table->string('title');
            $table->integer('lec_hours')->default(0);
            $table->integer('lab_hours')->default(0);
            $table->integer('lec_units')->default(0);
            $table->integer('lab_units')->default(0);
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
        Schema::dropIfExists('subjects');
    }
}
