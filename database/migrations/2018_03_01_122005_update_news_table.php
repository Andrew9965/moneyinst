<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('subject');
            $table->dropColumn('description');
            $table->integer('category_id')->after('id');
            $table->string('slug')->after('category_id');
            $table->string('title')->after('slug');
            $table->longText('content')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('slug');
            $table->dropColumn('title');
        });
    }
}
