<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('identity_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->string('document_path')->nullable();
            $table->string('selfie_path')->nullable();
            $table->string('matricule')->nullable();
            $table->date('date_of_birth_document')->nullable();
            $table->date('date_of_birth_matricule')->nullable();
            $table->string('otp_phone')->nullable();
            $table->timestamp('otp_sent_at')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedTinyInteger('verification_score')->nullable();
            $table->boolean('review_required')->default(false);
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->json('metadata')->nullable();
            $table->ipAddress('created_at_ip')->nullable();
            $table->ipAddress('last_action_ip')->nullable();
            $table->timestamps();
        });

        Schema::create('identity_verification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identity_verification_id')->constrained()->cascadeOnDelete();
            $table->string('event');
            $table->json('details')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('must_verify_identity')->default(false);
            $table->boolean('is_identity_verified')->default(false);
            $table->date('date_of_birth_verified')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_restricted_18')->default(false);
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->foreignId('identity_verification_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('age_restriction_passed')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('identity_verification_id');
            $table->dropColumn('age_restriction_passed');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('is_restricted_18');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['must_verify_identity', 'is_identity_verified', 'date_of_birth_verified']);
        });

        Schema::dropIfExists('identity_verification_logs');
        Schema::dropIfExists('identity_verifications');
    }
};
