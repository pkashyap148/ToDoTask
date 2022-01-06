<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements("task_id");
            $table->string("task_name");
            $table->enum('isActive',[0,1])->default(1);
            $table->enum('isDelete',[0,1])->default(0);
            $table->timestamp("created")->useCurrent();
            $table->timestamp("updated")->useCurrent()->useCurrentOnUpdate();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
