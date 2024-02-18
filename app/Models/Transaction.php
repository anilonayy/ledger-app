<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_account_id',
        'receiver_account_id',
        'amount',
        'type',
        'status',
        'creator_id',
        'description',
    ];

    /**
     * @return BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'sender_account_id', 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'receiver_account_id', 'user_id');
    }
}
