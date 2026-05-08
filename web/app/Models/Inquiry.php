<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'contact_name',
        'phone',
        'email',
        'message',
        'source',
        'product_id',
        'status',
        'handled_by',
        'handled_at',
        'notes',
        'ip_address',
        'user_agent',
        'privacy_agreed_at',
    ];

    protected function casts(): array
    {
        return [
            'handled_at' => 'datetime',
            'privacy_agreed_at' => 'datetime',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function handledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(InquiryAttachment::class);
    }
}
