<script setup>
import Icon from '@/Components/Icon.vue';
import { useContent } from '@/composables/useContent';
import { computed } from 'vue';

// pageKey pulls eyebrow/title/subtitle/image/icon from the admin "Page content" (config/site_content);
// the plain props are only fallbacks for pages without a content entry.
const props = defineProps({
    pageKey: String,
    eyebrow: String,
    title: String,
    subtitle: String,
    image: String,
    icon: String,
});

const { c } = useContent();
const field = (name) => (props.pageKey ? c(`${props.pageKey}.hero.${name}`) : '') || props[name] || '';

const eyebrow = computed(() => field('eyebrow'));
const title = computed(() => field('title'));
const subtitle = computed(() => field('subtitle'));
const image = computed(() => field('image'));
const icon = computed(() => field('icon'));
</script>

<template>
    <section class="page-hero">
        <!-- picture -->
        <div v-if="image" class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${image}')` }" />
        <!-- readability overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-brand-900/80 via-brand-900/65 to-brand-900/90" />
        <div class="absolute inset-0 bg-gradient-to-r from-brand-900/70 via-transparent to-brand-900/40" />
        <div class="grid-bg absolute inset-0 opacity-40 [mask-image:radial-gradient(ellipse_at_center,black,transparent_75%)]" />
        <div class="pointer-events-none absolute -top-24 right-0 h-72 w-72 rounded-full bg-accent-500/30 blur-3xl" />
        <div class="pointer-events-none absolute -bottom-24 left-0 h-72 w-72 rounded-full bg-brand-500/30 blur-3xl" />
        <!-- big watermark icon -->
        <Icon v-if="icon" :name="icon" class="pointer-events-none absolute -bottom-10 right-4 hidden h-64 w-64 -rotate-12 text-white/10 md:block lg:right-24" />

        <div class="container-x relative text-center">
            <span v-if="icon" class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur">
                <Icon :name="icon" class="h-7 w-7" />
            </span>
            <span v-if="eyebrow" class="eyebrow-dark">{{ eyebrow }}</span>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ title }}</h1>
            <p v-if="subtitle" class="mx-auto mt-4 max-w-2xl text-lg text-slate-200">{{ subtitle }}</p>
            <slot />
        </div>
    </section>
</template>
