<template>
    <div class="dark:bg-gray-800 dark:text-white md:col-span-1 flex justify-between">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium dark:bg-gray-800 dark:text-white text-gray-900">
                <slot name="title"></slot>
            </h3>

            <p class="mt-1 text-sm dark:bg-gray-800 dark:text-white text-gray-600">
                <slot name="description"></slot>
            </p>
        </div>

        <div class="px-4 sm:px-0 dark:bg-gray-800 dark:text-white">
            <slot name="aside"></slot>
        </div>
    </div>
</template>
