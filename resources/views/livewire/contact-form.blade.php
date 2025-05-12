@php
  use Hydrat\GroguCMS\Enums\FormFieldType;
@endphp

<div>
  <form wire:submit.prevent="submit" x-data="{ altcha: $wire.entangle('altcha') }">
    <div class="grid grid-cols-12 gap-4 p-2">
      @foreach ($form->fields as $field)
        <div class="col-span-{{ $field->column_span ?: 'full' }}">
          @switch ($field->type)
            @case (FormFieldType::Title)
              <x-grogu-cms::forms.title
                name="data.{{ $field->key }}"
                :content="$field->translate('content')"
              />
              @break
            @case (FormFieldType::Placeholder)
              <x-grogu-cms::forms.placeholder
                name="data.{{ $field->key }}"
                :content="$field->translate('content')"
              />
              @break
            @case (FormFieldType::Text)
              <x-grogu-cms::forms.input
                type="text"
                :label="$field->name"
                name="data.{{ $field->key }}"
                wire:model="data.{{ $field->key }}"
                :helperText="$field->translate('helper_text')"
                :placeholder="$field->translate('placeholder')"
                :required="$field->required"
              />
              @break
            @case (FormFieldType::Email)
              <x-grogu-cms::forms.input
                type="email"
                :label="$field->name"
                name="data.{{ $field->key }}"
                wire:model="data.{{ $field->key }}"
                :helperText="$field->translate('helper_text')"
                :placeholder="$field->translate('placeholder')"
                :required="$field->required"
              />
              @break
            @case (FormFieldType::Telephone)
              <x-grogu-cms::forms.input
                type="tel"
                :label="$field->name"
                name="data.{{ $field->key }}"
                wire:model="data.{{ $field->key }}"
                :helperText="$field->translate('helper_text')"
                :placeholder="$field->translate('placeholder')"
                :required="$field->required"
              />
              @break
            @case (FormFieldType::Textarea)
              <x-grogu-cms::forms.textarea
                type="email"
                :label="$field->name"
                name="data.{{ $field->key }}"
                wire:model="data.{{ $field->key }}"
                :helperText="$field->translate('helper_text')"
                :placeholder="$field->translate('placeholder')"
                :required="$field->required"
                rows="{{ $field->rows ?: 3 }}"
              />
              @break
            @case (FormFieldType::Select)
              <x-grogu-cms::forms.select
                :label="$field->name"
                name="data.{{ $field->key }}"
                wire:model="data.{{ $field->key }}"
                :helperText="$field->translate('helper_text')"
                :placeholder="$field->translate('placeholder')"
                :required="$field->required"
                :multiple="$field->multiple"
              >
                @foreach ($field->options as $option)
                  <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                @endforeach
              </x-forms.select>
              @break
            @case (FormFieldType::Confirm)
              <x-grogu-cms::forms.checkbox-confirm
                :label="$field->translate('content')"
                name="data.{{ $field->key }}"
                wire:model="data.{{ $field->key }}"
                :helperText="$field->translate('helper_text')"
                :required="$field->required"
              />
              @break
            @default
              {{-- Nothing. --}}
          @endswitch
        </div>
      @endforeach

      <div class="col-span-full">
        <div wire:ignore>
          <altcha-widget
            challengeurl="/altcha-challenge"
            x-on:statechange="$event.detail.state === 'verified' ? (altcha = $event.detail.payload) : null"
            floating
          ></altcha-widget>
        </div>
      </div>
    </div>

    <button
      type="submit"
      class="inline-flex items-center px-4 py-3 text-sm font-medium text-gray-800 bg-white border border-gray-200 rounded-lg shadow-sm gap-x-2 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
    >
      {{ $form->translate('submit_button_label') ?: __('Submit') }}
    </button>

    @if ($onErrorMessage)
      <div class="mt-4">
        <div class="text-red-600">{{ $onErrorMessage }}</div>
      </div>
    @elseif ($onSuccessMessage)
      <div class="mt-4">
        <div class="text-green-600">{{ $onSuccessMessage }}</div>
      </div>
    @endif
  </form>
</div>
