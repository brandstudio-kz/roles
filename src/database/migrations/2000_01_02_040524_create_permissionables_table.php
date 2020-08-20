<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionablesTable extends Migration
{

    public function up()
    {
        Schema::create('permissionables', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('permissionable_id');
            $table->string('permissionable_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissionables');
    }
}
