<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'email',
        'phone',
        'address',
        'district',
        'delivery_area',
        'delivery_charge',
        'subtotal',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'landing_page_id',
        'notes',
        'courier_name',
        'courier_tracking_code',
        'courier_tracking_link',
        'courier_consignment_id',
        'courier_status',
        'courier_booked_at',
        'courier_last_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'delivery_charge' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
            'courier_booked_at' => 'datetime',
            'courier_last_synced_at' => 'datetime',
        ];
    }

    /**
     * Get human-readable label for Steadfast / courier delivery status
     */
    public function getCourierStatusLabelAttribute(): string
    {
        $status = strtolower($this->courier_status ?? '');

        return match ($status) {
            'in_review' => 'ইন-রিভিউ (In Review)',
            'pending' => 'পেন্ডিং (অপেক্ষমাণ)',
            'delivered_approval_pending' => 'ডেলিভারি অনুমোদন অপেক্ষমাণ',
            'partial_delivered_approval_pending' => 'আংশিক ডেলিভারি অনুমোদন অপেক্ষমাণ',
            'cancelled_approval_pending' => 'বাতিল অনুমোদন অপেক্ষমাণ',
            'delivered' => 'ডেলিভারি সম্পন্ন (Delivered)',
            'partial_delivered' => 'আংশিক ডেলিভারি (Partial Delivered)',
            'cancelled' => 'বাতিল / রিটার্ন (Cancelled)',
            'hold' => 'হোল্ড (On Hold)',
            'booked' => 'কুরিয়ারে বুকড (Booked)',
            default => ! empty($this->courier_status) ? ucfirst(str_replace('_', ' ', $this->courier_status)) : 'বুকড হয়নি',
        };
    }

    /**
     * Get CSS badge class for courier delivery status
     */
    public function getCourierStatusBadgeClassAttribute(): string
    {
        $status = strtolower($this->courier_status ?? '');

        return match ($status) {
            'delivered' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'partial_delivered', 'delivered_approval_pending' => 'bg-teal-100 text-teal-800 border-teal-300',
            'in_review', 'booked' => 'bg-blue-100 text-blue-800 border-blue-300',
            'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
            'hold' => 'bg-purple-100 text-purple-800 border-purple-300',
            'cancelled', 'cancelled_approval_pending' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-slate-100 text-slate-700 border-slate-300',
        };
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }
}
