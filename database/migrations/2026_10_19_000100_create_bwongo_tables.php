<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kind'); // both, phq9, gad7
            $table->unsignedTinyInteger('phq9_score')->nullable();
            $table->unsignedTinyInteger('gad7_score')->nullable();
            $table->unsignedTinyInteger('phq9_item9')->default(0);
            $table->unsignedTinyInteger('difficulty')->nullable();
            $table->string('phq9_band')->nullable();
            $table->string('gad7_band')->nullable();
            $table->boolean('referral_suggested')->default(false);
            $table->json('answers');
            $table->timestamps();
        });

        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('ticket')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('screening_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('student_number')->nullable();
            $table->string('contact');
            $table->string('contact_method');
            $table->string('preferred_time')->nullable();
            $table->text('note')->nullable();
            $table->boolean('consent');
            $table->string('urgency'); // urgent, high, routine
            $table->string('status')->default('new'); // new, contacted, scheduled, closed
            $table->text('counselor_notes')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('status_changed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->timestamp('last_student_message_at')->nullable();
            $table->timestamp('last_office_message_at')->nullable();
            $table->timestamp('office_read_at')->nullable();
            $table->timestamp('student_read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->string('sender'); // student, office
            $table->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('body');
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('screenings');
    }
};
