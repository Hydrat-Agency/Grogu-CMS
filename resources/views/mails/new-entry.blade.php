<div>
  <p>
    {{ __('Hello') }}, <br><br>

    {{ __('A new entry has been submitted via the web form') }} "{{ $entry->form->name }}"

    {{ strtolower(__('The :date at :time', ['date' => $entry->submitted_at->format('d/m/Y'), 'time' => $entry->submitted_at->format('H:i')])) }}. <br><br>

    {{ __('Here are the entry details') }} :
  </p>

  <ul>
    @foreach ($entry->values as $field)
      @if ($field->hasValueToDisplay())
        <li>
          <strong>{{ $field->label }} :</strong>
          @if ($url = $field->getRelatedUrl())
            <a href="{{ $url }}" target="_blank">{{ $field->displayValue() }}</a>
          @else
            {{ $field->displayValue() }}
          @endif
        </li>
      @endif
    @endforeach
  </ul>

  <p>
    {{ __('Sincerely') }}, <br>
    {{ config('app.name') }}
  </p>
</div>
