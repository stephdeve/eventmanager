<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IdentityVerification extends Model
{
    use HasFactory, HasUuids;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'document_path',
        'selfie_path',
        'matricule',
        'date_of_birth_document',
        'date_of_birth_matricule',
        'otp_phone',
        'otp_sent_at',
        'otp_verified_at',
        'status',
        'verification_score',
        'review_required',
        'reviewed_by',
        'reviewed_at',
        'metadata',
        'created_at_ip',
        'last_action_ip',
    ];

    protected $casts = [
        'date_of_birth_document' => 'date',
        'date_of_birth_matricule' => 'date',
        'otp_sent_at' => 'datetime',
        'otp_verified_at' => 'datetime',
        'review_required' => 'boolean',
        'reviewed_at' => 'datetime',
        'metadata' => 'array',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_NEEDS_REVIEW = 'needs_review';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(IdentityVerificationLog::class);
    }

    public function setDocumentNumberAttribute(?string $value): void
    {
        $this->attributes['document_number'] = $value ? Crypt::encryptString($value) : null;
    }

    public function getDocumentNumberAttribute(?string $value): ?string
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function setMatriculeAttribute(?string $value): void
    {
        $this->attributes['matricule'] = $value ? Crypt::encryptString($value) : null;
    }

    public function getMatriculeAttribute(?string $value): ?string
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function markVerified(): void
    {
        $this->status = self::STATUS_VERIFIED;
        $this->review_required = false;
        $this->verification_score = 100;
        $this->save();
    }

    public function markRejected(): void
    {
        $this->status = self::STATUS_REJECTED;
        $this->review_required = true;
        $this->save();
    }

    public function addLog(string $event, array $details = [], ?string $ip = null, ?int $performedBy = null, ?string $userAgent = null): void
    {
        $this->logs()->create([
            'event' => $event,
            'details' => $details,
            'ip_address' => $ip,
            'user_agent' => $userAgent ? Str::limit($userAgent, 250) : null,
            'performed_by' => $performedBy,
        ]);
    }

    public function mergeMetadata(array $data): void
    {
        $metadata = $this->metadata ?? [];
        $this->metadata = array_filter(array_merge($metadata, $data), static fn ($value) => $value !== null);
    }

    public function storeDocument($file): string
    {
        $directory = 'identity/documents/' . Str::uuid();
        return Storage::disk('local')->putFile($directory, $file);
    }
}
