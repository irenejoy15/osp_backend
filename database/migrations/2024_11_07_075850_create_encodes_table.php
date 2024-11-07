<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('encodes', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->integer('job');
            $table->string('stockCode');
            $table->string('stockDescription');
            $table->integer('targetInPcs');
            $table->string('line');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encodes');
    }
};
