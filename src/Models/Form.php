<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Omaralalwi\LexiTranslate\Traits\LexiTranslatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function fields(): Relations\HasMany
    {
        return $this->hasMany(FormField::class)->orderBy('order');
    }

    public function entries(): Relations\HasMany
    {
        return $this->hasMany(FormEntry::class);
    }
}
