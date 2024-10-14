@props(['value'])
 
<p {{ $attributes->merge(['class' => 'text-sm text-red-600']) }}>{{ $value ?? $slot }}</p>
