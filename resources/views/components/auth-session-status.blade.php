@props(['status'])

@if ($status)
<div {{ $attributes->merge(['class' => 'font-medium text-white bg-green-500 px-2 py-3 rounded-lg shadow-sm my-1']) }}>
    {{ $status }}
</div>
@endif
