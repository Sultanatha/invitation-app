<?php

namespace App\Models\Concerns;

use App\Models\Invitation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait AssignsDefaultInvitation
{
    protected static function bootAssignsDefaultInvitation(): void
    {
        static::creating(function ($model): void {
            if (empty($model->invitation_id)) {
                $model->invitation_id = Invitation::default()->id;
            }
        });
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
