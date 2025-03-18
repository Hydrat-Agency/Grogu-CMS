@props(['name', 'content'])

<div class="mb-4">
  <h2 class="block mb-2 text-sm font-medium dark:text-white">
    {!! strip_tags($content, ['b', 'i']) !!}
  </h2>
</div>
