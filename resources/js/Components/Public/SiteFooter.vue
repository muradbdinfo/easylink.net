<script setup>
import Icon from '@/Components/Icon.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const settings = computed(() => page.props.settings ?? {});

const year = new Date().getFullYear();

const social = computed(() =>
    [
        { key: 'facebook_url', label: 'Facebook' },
        { key: 'youtube_url', label: 'YouTube' },
        { key: 'linkedin_url', label: 'LinkedIn' },
        { key: 'instagram_url', label: 'Instagram' },
    ].filter((s) => settings.value[s.key]),
);
</script>

<template>
    <footer class="relative overflow-hidden bg-brand-900 text-slate-300">
        <div class="pointer-events-none absolute -top-32 left-1/2 h-64 w-[40rem] -translate-x-1/2 rounded-full bg-brand-500/20 blur-3xl" />

        <div class="container-x relative grid grid-cols-1 gap-10 py-16 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white p-1"><img :src="settings.logo || '/images/logo-mark.png'" alt="EasyLink logo" class="h-full w-full object-contain" /></span>
                    <span class="font-display text-xl font-extrabold text-white">{{ settings.site_name || 'EasyLink' }}</span>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-slate-400">{{ settings.tagline }}</p>
                <div class="mt-6 flex flex-wrap gap-2">
                    <a
                        v-for="s in social"
                        :key="s.key"
                        :href="settings[s.key]"
                        target="_blank"
                        rel="noopener"
                        :aria-label="s.label"
                        :title="s.label"
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-xs font-semibold transition hover:bg-accent-500"
                    >
                        {{ s.label[0] }}
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Quick links</h4>
                <ul class="mt-5 space-y-2.5 text-sm">
                    <li><Link :href="route('packages.index')" class="hover:text-white">Packages</Link></li>
                    <li><Link :href="route('corporate')" class="hover:text-white">Corporate solutions</Link></li>
                    <li><Link :href="route('services.index')" class="hover:text-white">Services</Link></li>
                    <li><Link :href="route('coverage.index')" class="hover:text-white">Check coverage</Link></li>
                    <li><Link :href="route('blog.index')" class="hover:text-white">Blog</Link></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Company</h4>
                <ul class="mt-5 space-y-2.5 text-sm">
                    <li><Link :href="route('about')" class="hover:text-white">About us</Link></li>
                    <li><Link :href="route('contact.index')" class="hover:text-white">Contact</Link></li>
                    <li><Link :href="route('login')" class="hover:text-white">Self-Care Login</Link></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Get in touch</h4>
                <ul class="mt-5 space-y-3.5 text-sm">
                    <li class="flex items-start gap-2.5">
                        <Icon name="phone" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400" />
                        {{ settings.hotline }} / {{ settings.phone }}
                    </li>
                    <li class="flex items-start gap-2.5">
                        <Icon name="envelope" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400" />
                        {{ settings.email }}
                    </li>
                    <li class="flex items-start gap-2.5">
                        <Icon name="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400" />
                        {{ settings.address }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="relative border-t border-white/10">
            <div class="container-x flex flex-col items-center justify-between gap-2 py-6 text-xs text-slate-400 sm:flex-row">
                <p>&copy; {{ year }} {{ settings.site_name || 'EasyLink' }}. All rights reserved.</p>
                <p>{{ settings.footer_text }}</p>
            </div>
        </div>
    </footer>
</template>
