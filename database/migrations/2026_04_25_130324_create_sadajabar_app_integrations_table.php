<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sadajabar_app_integrations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('month');
            $table->smallInteger('year');
            $table->integer('app_count')->default(0);
            $table->unsignedBigInteger('service_type_id');
            $table->unsignedBigInteger('sadajabar_institution_categories_id');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('sadajabar_app_integrations');
    }
};
