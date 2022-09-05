<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('conversation_id')->constrained('conversation_id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('messages')->onDelete('cascade')->onUpdate('cascade');
            $table->text('body');
            $table->tinyInteger('seen')->default(0)->comment('0 => not seen, 1 => seen');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_edited')->default(0)->comment('0 => not edited, 1 => edited');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
