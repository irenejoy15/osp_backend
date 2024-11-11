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
        Schema::create('actual_targets', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('encodeId')->index();
            $table->integer('targetActual');
            $table->string('lineActual');
            $table->date('dateActual');
            $table->string('timeDropDown');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actual_targets');
    }
};
