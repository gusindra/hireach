@props(['value'])
<div>
    <span {{ $attributes->merge(['class' => 'inline-flex items-center text-xs tracking-widest opacity-50']) }}>
        {{ $value }}
    </span>
</div>
