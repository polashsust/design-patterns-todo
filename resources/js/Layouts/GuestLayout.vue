<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-b from-gray-100 to-gray-200">
    <div class="mb-8 flex flex-col items-center">
      <Link href="/" class="flex flex-col items-center group">
        <span
          class="inline-flex items-center justify-center w-28 h-28 rounded-full bg-white shadow-lg border border-gray-200 transition-transform group-hover:-translate-y-1 group-hover:shadow-xl"
        >
          <img
            src="/vrg.png"
            alt="VRG GmbH Logo"
            class="w-20 h-20 object-contain"
          />
        </span>
        <span class="mt-2 font-bold text-xl text-gray-800 tracking-wide">VRG GmbH</span>
      </Link>
    </div>

    <div
      class="w-full max-w-md bg-white px-6 py-8 rounded-2xl shadow-lg border border-gray-100"
    >
      <slot />
    </div>
  </div>
</template>
