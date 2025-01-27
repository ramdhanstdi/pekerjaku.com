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
        Schema::create('pekerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->integer('age')->nullable(); //umur
            $table->text('experience')->nullable(); //pengalaman
            $table->string('education')->nullable(); //pendidikan
            $table->string('tall')->nullable(); //tinggi
            $table->string('heavy')->nullable(); // berat
            $table->date('date_of_birth')->nullable(); // tanggal lahir
            $table->string('tribe_of_origin')->nullable(); // suku asal
            $table->string('police_letter')->nullable(); // surat polisi
            $table->string('doctors_letter')->nullable(); // surat dotker
            $table->string('marital_status')->nullable(); // status perkawinan
            $table->string('salary')->nullable(); // gaji
            $table->string('admin_fees')->nullable(); // biaya admin
            $table->string('warranty_period')->nullable(); // masa garansi
            $table->string('stay_at')->nullable(); // menginap
            $table->string('have_children')->nullable(); // punya anak
            $table->string('religion')->nullable(); // agama
            $table->string('current_location')->nullable(); //lokasi saat ini
            $table->string('fear_of_dogs')->nullable(); // takut anjing
            $table->string('work_experience_abroad')->nullable(); // pengalaman kerja di luar negri
            $table->string('english')->nullable(); // bahasa inggris
            $table->text('skills')->nullable(); // keterampilan
            $table->text('willing_to_work_in')->nullable(); // bersedia bekerja di
            $table->string('employee_status')->nullable(); // status bekerja
            $table->text('skill')->nullable(); // keahlian
            $table->text('description')->nullable(); // keahlian
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pekerjas');
    }
};
