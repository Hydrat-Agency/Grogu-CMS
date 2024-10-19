@props(['label', 'name', 'helperText' => null])

<div class="mb-4">
  <div class="flex">
    <input
      type="checkbox" name="{{ $name }}" id="{{ $name }}" {{
        $attributes->class([
          'shrink-0 mt-0.5 rounded disabled:opacity-50 disabled:pointer-events-none border-gray-200 dark:bg-neutral-800 dark:border-neutral-700 dark:focus:ring-offset-gray-800',
          'border-gray-200 text-blue-600 focus:ring-blue-500 dark:checked:bg-blue-500 dark:checked:border-blue-500' => !$errors->has($name),
          'text-red-600 focus:ring-red-500 dark:checked:bg-red-500 dark:checked:border-red-500"' => $errors->has($name),
        ])
    }} />

    <label for="{{ $name }}" value="1" class="!text-sm ms-3 dark:text-neutral-400 prose {{ $errors->has($name) ? 'text-red-500' : 'text-gray-500' }}">
      {!! strip_tags($label, '<br><b><a><i>') !!}
    </label>
  </div>

  @if ($helperText)
    <p class="mt-2 text-xs text-gray-500 dark:text-neutral-500">{{ $helperText }}</p>
  @endif
</div>
