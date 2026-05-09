<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intop_service_catalogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_type_id')
                ->constrained('service_types')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('category', ['administrasi', 'publik'])
                ->comment('Administrasi Pemerintahan atau Layanan Publik');
            $table->string('service_name')
                ->comment('Contoh: Keuangan, Kepegawaian, Pajak dan Retribusi');
            $table->smallInteger('year');
            $table->timestamps();
        });
        //
    }

    public function down(): void
    {
        Schema::dropIfExists('intop_service_catalogs');
    }
};
