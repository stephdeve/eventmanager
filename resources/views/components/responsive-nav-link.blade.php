@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out dark:border-neutral-700 dark:text-neutral-100 dark:bg-neutral-800 dark:focus:text-neutral-100 dark:focus:bg-neutral-800 dark:focus:border-neutral-700'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out dark:text-neutral-300 dark:hover:text-neutral-100 dark:hover:bg-neutral-800 dark:hover:border-neutral-700 dark:focus:text-neutral-100 dark:focus:bg-neutral-800 dark:focus:border-neutral-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
