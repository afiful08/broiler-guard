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
        Schema::create('config_heaters', function (Blueprint $table) {
            $table->string('device_id');
            $table->foreign('device_id')->references('id')->on('devices');
            $table->enum('mode',['MANUAL','AUTOMATIC'])->default('MANUAL');
            $table->boolean('status')->default(0);
            $table->float('max_temp')->nullable();
            $table->float('min_temp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_heaters');
    }
};
