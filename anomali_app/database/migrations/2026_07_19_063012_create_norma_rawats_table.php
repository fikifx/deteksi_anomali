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
        Schema::create('norma_rawats', function (Blueprint $table) {
            $table->id();
            $table->string('sitecode')->nullable();
            $table->date('tdate')->nullable();
            $table->string('afdcode')->nullable();
            $table->string('location')->nullable();
            $table->integer('plantingdate')->nullable();
            $table->string('jobtype')->nullable();
            $table->string('jobtypedesc')->nullable();
            $table->string('type')->nullable();
            $table->string('jobgroupcode')->nullable();
            $table->string('jobcode')->nullable();
            $table->string('jobdesc')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('ump', 20, 4)->nullable();
            $table->decimal('hectplanted', 20, 4)->nullable();
            $table->decimal('mandays_hi', 20, 4)->nullable();
            $table->decimal('mandays_shi', 20, 4)->nullable();
            $table->decimal('hk_per_ha_hi', 20, 4)->nullable();
            $table->decimal('hk_per_ha_shi', 20, 4)->nullable();
            $table->decimal('produksi_hi', 20, 4)->nullable();
            $table->decimal('produksi_shi', 20, 4)->nullable();
            $table->decimal('cost_hi', 20, 4)->nullable();
            $table->decimal('cost_shi', 20, 4)->nullable();
            $table->decimal('premi_hi', 20, 4)->nullable();
            $table->decimal('premi_shi', 20, 4)->nullable();
            $table->decimal('addcost_hi', 20, 4)->nullable();
            $table->decimal('addcost_shi', 20, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('norma_rawats');
    }
};
