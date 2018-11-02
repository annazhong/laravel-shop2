<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            //foreign user_id 和 users表里面的id绑定，当user表id删除时，相关的user_id关联数据也要被删除。
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('address');
            $table->unsignedInteger('zip');
            $table->string('contact_name');
            $table->string('last_used_at')->nullable();
            $table->string('contact_phone');
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
        Schema::dropIfExists('user_addresses');
    }
}
