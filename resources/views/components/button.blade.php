<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2  border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest', 'style'=>'background-color: #00A0CE']) }}>
    {{ $slot }}
</button>