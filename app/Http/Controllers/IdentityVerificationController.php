<?php

namespace App\Http\Controllers;

use App\Models\IdentityVerification;
use App\Services\IdentityVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IdentityVerificationController extends Controller
{
    protected IdentityVerificationService $identityVerificationService;

    public function __construct(IdentityVerificationService $identityVerificationService)
    {
        $this->middleware('auth');
        $this->identityVerificationService = $identityVerificationService;
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $verification = $user->identityVerification()->first();

        return view('identity.verification', [
            'user' => $user,
            'verification' => $verification,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $existingVerification = $user->identityVerification()->first();

        $documentRule = $existingVerification && $existingVerification->document_path ? 'nullable' : 'required';

        $validated = $request->validate([
            'document_type' => ['required', 'string', 'max:50'],
            'document_number' => ['nullable', 'string', 'max:100'],
            'document' => [$documentRule, 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'matricule' => ['required', 'string', 'max:150'],
            'date_of_birth' => ['required', 'date', 'before:-18 years'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ]);

        $verification = DB::transaction(function () use ($existingVerification, $validated, $request, $user) {
            $verification = $existingVerification ?? new IdentityVerification();
            $documentPath = $verification->document_path;

            if ($request->hasFile('document')) {
                if ($documentPath && Storage::disk('local')->exists($documentPath)) {
                    Storage::disk('local')->delete($documentPath);
                }

                $documentPath = $verification->storeDocument($request->file('document'));
            }

            $verification->fill([
                'user_id' => $user->id,
                'document_type' => $validated['document_type'],
                'document_number' => $validated['document_number'] ?? null,
                'document_path' => $documentPath,
                'matricule' => $validated['matricule'],
                'date_of_birth_document' => $validated['date_of_birth'],
                'date_of_birth_matricule' => $validated['date_of_birth'],
                'status' => IdentityVerification::STATUS_PENDING,
                'review_required' => false,
                'last_action_ip' => $request->ip(),
            ]);

            if (! $verification->exists) {
                $verification->created_at_ip = $request->ip();
            }

            $verification->mergeMetadata([
                'remarks' => $validated['remarks'] ?? null,
                'submission_source' => 'self_service',
            ]);

            $verification->save();

            $user->forceFill([
                'is_identity_verified' => false,
                'date_of_birth_verified' => null,
            ])->save();

            $verification->addLog('submission_received', [
                'document_type' => $verification->document_type,
                'document_uploaded' => (bool) $verification->document_path,
            ], $request->ip(), $user->id, $request->userAgent());

            return $verification;
        });

        $this->identityVerificationService->process($verification);

        return redirect()
            ->route('identity.verification.show')
            ->with('success', 'Votre vérification d\'identité a été enregistrée. Elle sera examinée prochainement.');
    }
}
