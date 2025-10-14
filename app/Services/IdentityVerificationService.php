<?php

namespace App\Services;

use App\Models\IdentityVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class IdentityVerificationService
{
    public function process(IdentityVerification $verification): void
    {
        $verification->refresh();

        $verification->addLog('processing_started', [
            'document_path' => (bool) $verification->document_path,
        ]);

        if (! $verification->document_path) {
            $verification->status = IdentityVerification::STATUS_NEEDS_REVIEW;
            $verification->review_required = true;
            $verification->mergeMetadata(['reason' => 'missing_document']);
            $verification->save();

            $verification->addLog('processing_incomplete', ['reason' => 'missing_document']);

            return;
        }

        if (! $verification->date_of_birth_document) {
            $verification->status = IdentityVerification::STATUS_NEEDS_REVIEW;
            $verification->review_required = true;
            $verification->mergeMetadata(['reason' => 'missing_date_of_birth']);
            $verification->save();

            $verification->addLog('processing_incomplete', ['reason' => 'missing_date_of_birth']);

            return;
        }

        $dobDocument = Carbon::parse($verification->date_of_birth_document);
        $dobMatricule = $verification->date_of_birth_matricule ? Carbon::parse($verification->date_of_birth_matricule) : null;

        if ($dobMatricule && ! $dobDocument->equalTo($dobMatricule)) {
            $verification->status = IdentityVerification::STATUS_NEEDS_REVIEW;
            $verification->review_required = true;
            $verification->mergeMetadata(['reason' => 'dob_mismatch']);
            $verification->save();

            $verification->addLog('processing_flagged', [
                'reason' => 'dob_mismatch',
                'document_dob' => $dobDocument->toDateString(),
                'matricule_dob' => $dobMatricule->toDateString(),
            ]);

            return;
        }

        $age = $dobDocument->age;

        $verification->mergeMetadata([
            'calculated_age' => $age,
        ]);

        if ($age < 18) {
            $verification->status = IdentityVerification::STATUS_REJECTED;
            $verification->review_required = true;
            $verification->save();

            $verification->addLog('processing_rejected', [
                'reason' => 'under_age',
                'age' => $age,
            ]);

            $verification->user->forceFill([
                'is_identity_verified' => false,
                'must_verify_identity' => true,
            ])->save();

            return;
        }

        $verification->status = IdentityVerification::STATUS_VERIFIED;
        $verification->review_required = false;
        $verification->verification_score = 80;
        $verification->save();

        $verification->user->forceFill([
            'is_identity_verified' => true,
            'must_verify_identity' => false,
            'date_of_birth_verified' => $dobDocument->toDateString(),
        ])->save();

        $verification->addLog('processing_verified', [
            'age' => $age,
            'score' => $verification->verification_score,
        ]);

        Log::info('Identity verification processed', [
            'verification_id' => $verification->id,
            'user_id' => $verification->user_id,
            'status' => $verification->status,
        ]);
    }
}
