<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->string('cover')->nullable();
        });
    }

  
    public function down()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn('cover');
        });
    }
};
