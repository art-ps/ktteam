<?php
declare(strict_types=1);

namespace TaskTracker\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->dropIfExists('tasks');
        Capsule::schema()->dropIfExists('users');

        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
  
        Capsule::schema()->create('tasks', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('status')->default('planned');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Capsule::schema()->drop('users');
        Capsule::schema()->drop('tasks');
    }
}
