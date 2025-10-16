<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Omaralalwi\LexiTranslate\Traits\LexiTranslatable;

class Form extends Model
{
    use HasFactory;
    use LexiTranslatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'submit_button_label',
        'submit_success_message',
        'notify_subject',
        'notify_emails',
        'entry_columns',
    ];

    /**
     * The list of translatable fields for the model.
     *
     * @var array
     */
    protected $translatableFields = [
        'name',
        'submit_button_label',
        'submit_success_message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'entry_columns' => 'array',
    ];

    public function fields(): Relations\HasMany
    {
        return $this->hasMany(FormField::class)->orderBy('order');
    }

    public function entries(): Relations\HasMany
    {
        return $this->hasMany(FormEntry::class);
    }
}
