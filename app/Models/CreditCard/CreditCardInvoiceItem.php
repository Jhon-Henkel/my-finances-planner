<?php

namespace App\Models\CreditCard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $credit_card_invoice_id
 * @property string $name
 * @property float $value
 * @property string $date
 * @property int $installments
 * @property bool $is_fixed
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read CreditCardInvoice $invoice
 *
 * @mixin Builder<CreditCardInvoiceItem>
 */
class CreditCardInvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'credit_card_invoice_items';

    protected $fillable = [
        'credit_card_invoice_id',
        'name',
        'value',
        'date',
        'installments',
        'is_fixed',
    ];

    protected $casts = [
        'date' => 'date',
        'is_fixed' => 'boolean',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(CreditCardInvoice::class, 'credit_card_invoice_id');
    }
}
