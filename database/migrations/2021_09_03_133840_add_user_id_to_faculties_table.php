<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable();
            $table->string('first_name')->after('name');
            $table->string('last_name')->after('name');
            $table->string('middle_name')->after('name');
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faculties', function (Blueprint $table) {
            //
            $table->dropColumn('user_id');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->string('name');
        });
    }
}
