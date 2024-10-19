@props(['label', 'name', 'helperText' => null])

<div class="mb-4">
  <label for="{{ $name }}" class="block mb-2 text-sm font-medium dark:text-white">
    {{ $label }}
  </label>

  <div class="relative">
    <input name="{{ $name }}" id="{{ $name }}" {{
      $attributes->class([
        'py-3 px-4 block w-full rounded-lg text-sm disabled:opacity-50 disabled:pointer-events-none',
        'border-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600' => !$errors->has($name),
        'border-red-500 focus:border-red-500 focus:ring-red-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400' => $errors->has($name),
      ])
    }} />

    @if ($errors->has($name))
      <div class="absolute inset-y-0 flex items-center pointer-events-none end-0 pe-3">
        <svg class="text-red-500 shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" x2="12" y1="8" y2="12"></line>
          <line x1="12" x2="12.01" y1="16" y2="16"></line>
        </svg>
      </div>
    @endif
  </div>

  @if ($errors->has($name))
    <p class="mt-2 !text-sm text-red-600">
      @foreach ($errors->get($name) as $error)
        {{ $error }}<br>
      @endforeach
    </p>
  @elseif ($helperText)
    <p class="mt-2 text-xs text-gray-500 dark:text-neutral-500">{{ $helperText }}</p>
  @endif
</div>
