<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('type', ['general', 'school'])->default('general');
            
            // Relasi item
            $table->foreignId('ticket_id')->nullable()->constrained('tickets')->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            
            $table->date('visit_date');
            $table->integer('quantity'); // jumlah orang / jumlah siswa
            $table->integer('unit_price');
            $table->integer('total_price'); // Dihitung di server

            // Status:
            // general: unpaid -> paid / cancelled / expired
            // school: pending_approval -> approved / rejected -> unpaid -> paid
            $table->string('status')->default('unpaid');

            // Data Pemesan
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            // Khusus Paket Rombongan Sekolah
            $table->string('school_name')->nullable();
            $table->text('school_address')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_position')->nullable();
            $table->string('pic_phone')->nullable();
            $table->string('pic_email')->nullable();

            // Catatan
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
