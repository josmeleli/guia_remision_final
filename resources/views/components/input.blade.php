@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['style' => 'border: 1px solid #00A0CE; border-radius: 5px; outline: none; background-color: transparent', 'onfocus' => 'this.style.boxShadow="none";']) !!}>
