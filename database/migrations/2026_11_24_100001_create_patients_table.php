<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 80);
            $table->string('prenom', 80);
            $table->string('cin', 20)->unique();
            $table->date('date_naissance');
            $table->enum('sexe', ['M', 'F']);
            $table->string('telephone', 20);
            $table->string('email')->nullable();
            $table->string('adresse')->nullable();
            $table->text('antecedents')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
