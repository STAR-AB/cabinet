<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('dentiste_id')->constrained('users');
            $table->foreignId('soin_id')->constrained('soins');
            $table->date('date_rdv');
            $table->time('heure_rdv');
            $table->enum('statut', ['planifie', 'confirme', 'termine', 'annule'])
                  ->default('planifie');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Un dentiste ne peut pas avoir deux rendez-vous au même créneau
            $table->unique(['dentiste_id', 'date_rdv', 'heure_rdv']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
