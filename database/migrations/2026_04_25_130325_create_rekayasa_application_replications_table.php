<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rekayasa_application_replications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_type_id');
            $table->unsignedBigInteger('rekayasa_institution_category_id');
            $table->smallInteger('year');
            $table->tinyInteger('month');
            $table->bigInteger('total_replications')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('rekayasa_application_replications');
    }
};
