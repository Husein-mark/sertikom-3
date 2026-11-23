<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'type',
        'ticket_id',
        'package_id',
        'visit_date',
        'quantity',
        'unit_price',
        'total_price',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'school_name',
        'school_address',
        'pic_name',
        'pic_position',
        'pic_phone',
        'pic_email',
        'notes',
        'admin_notes',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'quantity' => 'integer',
        'unit_price' => 'integer',
        'total_price' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function eTicket(): HasOne
    {
        return $this->hasOne(ETicket::class);
    }

    public function isGeneral(): bool
    {
        return $this->type === 'general';
    }

    public function isSchool(): bool
    {
        return $this->type === 'school';
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
