<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id(); // bigint unsigned, auto_increment
            $table->string('key'); // varchar(255), NOT NULL
            $table->text('value')->nullable(); // text, NULL
            $table->string('icon')->nullable(); // varchar(255), NULL
            $table->string('status')->default('1'); // varchar(255), NOT NULL, default 1
            $table->string('type')->default('detail')->nullable(); // varchar(255), default 'detail'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade'); // bigint unsigned, foreign key
            $table->timestamps(); // created_at and updated_at
        });
    }
    public function down()
    {
        Schema::dropIfExists('details');
    }
}