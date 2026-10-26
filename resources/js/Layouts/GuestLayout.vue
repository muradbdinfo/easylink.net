<script setup>
import Icon from '@/Components/Icon.vue';
import { useContent } from '@/composables/useContent';
import { Link } from '@inertiajs/vue3';

const { c, list } = useContent();
</script>

<template>
    <div class="grid min-h-screen grid-cols-1 bg-slate-50 lg:grid-cols-2">
        <!-- Picture panel -->
        <aside class="relative hidden overflow-hidden bg-brand-900 text-white lg:block">
            <div class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('auth.brand.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-t from-brand-900 via-brand-900/70 to-brand-900/40" />
            <div class="grid-bg absolute inset-0 opacity-30 [mask-image:radial-gradient(ellipse_at_top_left,black,transparent_70%)]" />
            <div class="pointer-events-none absolute -right-20 -top-20 h-80 w-80 rounded-full bg-accent-500/30 blur-3xl" />
            <div class="relative flex h-full flex-col justify-end p-12 xl:p-16">
                <span class="eyebrow-dark w-fit">{{ c('auth.brand.eyebrow') }}</span>
                <h2 class="mt-5 max-w-md text-4xl font-extrabold leading-tight tracking-tight xl:text-5xl">{{ c('auth.brand.title') }}</h2>
                <p class="mt-4 max-w-md text-lg text-slate-200">{{ c('auth.brand.text') }}</p>
                <ul class="mt-8 space-y-3">
                    <li v-for="(p, i) in list('auth.brand.points')" :key="i" class="flex items-center gap-3 text-sm font-medium text-slate-100">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 ring-1 ring-white/20 backdrop-blur"><Icon :name="p.icon" class="h-5 w-5" /></span>
                        {{ p.text }}
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Form panel -->
        <main class="relative flex flex-col items-center justify-center overflow-hidden px-4 py-10 sm:px-8">
            <div class="pointer-events-none absolute -right-24 top-0 h-72 w-72 rounded-full bg-accent-200/40 blur-3xl lg:hidden" />

            <div class="relative w-full max-w-md">
                <Link href="/" class="flex justify-center">
                    <img src="/images/logo-full.png" alt="EasyLink" class="h-20 w-auto object-contain sm:h-24" />
                </Link>

                <div class="mt-6 w-full rounded-3xl border border-slate-200/70 bg-white px-6 py-7 shadow-xl shadow-slate-900/5 sm:px-8">
                    <slot />
                </div>

                <Link href="/" class="mt-6 flex min-h-[44px] items-center justify-center gap-1.5 text-sm font-medium text-slate-500 hover:text-brand-700">
                    <Icon name="chevron-right" class="h-4 w-4 rotate-180" />
                    {{ c('auth.back_to_site') }}
                </Link>
            </div>
        </main>
    </div>
</template>
