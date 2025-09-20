<?php

namespace App\Models\CreditCard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $credit_card_id
 * @property string $name
 * @property string $due_date
 * @property string $closing_date
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read CreditCard $creditCard
 * @property-read Collection<int, CreditCardInvoiceItem> $items
 *
 * @mixin Builder<CreditCardInvoice>
 */
class CreditCardInvoice extends Model
{
    use HasFactory;

    protected $table = 'credit_card_invoices';

    protected $fillable = [
        'credit_card_id',
        'name',
        'due_date',
        'closing_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'closing_date' => 'date',
    ];

    public function creditCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CreditCardInvoiceItem::class);
    }
}
