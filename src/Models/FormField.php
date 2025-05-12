<?php

namespace Hydrat\GroguCMS\Models;

use Hydrat\GroguCMS\Enums\FormFieldType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Omaralalwi\LexiTranslate\Traits\LexiTranslatable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class FormField extends Model implements Sortable
{
    use HasFactory;
    use LexiTranslatable;
    use SortableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'form_id',
        'name',
        'content',
        'type',
        'options',
        'column_span',
        'order',
        'placeholder',
        'helper_text',
        'required',
        'rows',
        'multiple',
        'min',
        'max',
        'min_date',
        'max_date',
        'hidden_label',
    ];

    /**
     * The list of translatable fields for the model.
     *
     * @var array
     */
    protected $translatableFields = [
        'name',
        'content',
        'placeholder',
        'helper_text',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'collection',
        'rules' => 'collection',
        'required' => 'boolean',
        'multiple' => 'boolean',
        'type' => FormFieldType::class,
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    public function form(): Relations\BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function buildSortQuery()
    {
        return static::query()->where('form_id', $this->form_id);
    }

    public function getKeyAttribute()
    {
        return "q{$this->id}";
    }
}
