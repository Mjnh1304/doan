@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => '
        bg-white text-gray-800 
        border border-gray-300 
        focus:border-blue-400 focus:ring-blue-300 
        rounded-md shadow-sm
    ']) }}>
