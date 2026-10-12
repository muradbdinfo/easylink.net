<script setup>
defineProps({
    eyebrow: String,
    title: { type: String, required: true },
    subtitle: String,
});
</script>

<template>
    <section class="page-hero">
        <div class="grid-bg absolute inset-0 opacity-60 [mask-image:radial-gradient(ellipse_at_center,black,transparent_75%)]" />
        <div class="pointer-events-none absolute -top-24 right-0 h-72 w-72 rounded-full bg-accent-500/30 blur-3xl" />
        <div class="pointer-events-none absolute -bottom-24 left-0 h-72 w-72 rounded-full bg-brand-500/30 blur-3xl" />
        <div class="container-x relative text-center">
            <span v-if="eyebrow" class="eyebrow-dark">{{ eyebrow }}</span>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ title }}</h1>
            <p v-if="subtitle" class="mx-auto mt-4 max-w-2xl text-lg text-slate-300">{{ subtitle }}</p>
            <slot />
        </div>
    </section>
</template>
