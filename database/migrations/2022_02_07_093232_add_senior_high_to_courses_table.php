<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeniorHighToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->boolean('senior_high')->after('code')->default(false);
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->string('custom_section_name')->nullable()->after('block');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('senior_high');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('custom_section_name');
        });
    }
}
