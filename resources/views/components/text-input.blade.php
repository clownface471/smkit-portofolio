@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-assyifa-500 dark:focus:border-assyifa-600 focus:ring-assyifa-500 dark:focus:ring-assyifa-600 rounded-md shadow-sm']) !!}>