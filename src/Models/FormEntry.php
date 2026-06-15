<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Hydrat\GroguCMS\Datas\FormEntryValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Spatie\LaravelData\DataCollection;

class FormEntry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'form_id',
        'user_id',
        'values',
        'submitted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'submitted_at' => 'datetime',
        'values' => DataCollection::class.':'.FormEntryValue::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', 'App\Models\User'));
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
