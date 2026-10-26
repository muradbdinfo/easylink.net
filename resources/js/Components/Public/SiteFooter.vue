<script setup>
import Icon from '@/Components/Icon.vue';
import { useContent } from '@/composables/useContent';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const settings = computed(() => page.props.settings ?? {});
const { c, list } = useContent();

const year = new Date().getFullYear();

const social = computed(() =>
    [
        { key: 'facebook_url', label: 'Facebook' },
        { key: 'youtube_url', label: 'YouTube' },
        { key: 'linkedin_url', label: 'LinkedIn' },
        { key: 'instagram_url', label: 'Instagram' },
    ].filter((s) => settings.value[s.key]),
);

// Paths on this site use Inertia <Link>; full addresses and #anchors are plain <a>.
const isPlain = (href) => /^(https?:|mailto:|tel:)/.test(href) || href.includes('#');
const external = (href) => /^https?:/.test(href) && new URL(href).origin !== window.location.origin;
const linkProps = (href) => (external(href) ? { target: '_blank', rel: 'noopener noreferrer' } : {});

const columns = computed(() => [
    { title: c('layout.footer.quick_title'), links: list('layout.footer.quick_links') },
    { title: c('layout.footer.company_title'), links: list('layout.footer.company_links') },
]);
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

            <div v-for="col in columns" :key="col.title">
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">{{ col.title }}</h4>
                <ul class="mt-5 space-y-1 text-sm">
                    <li v-for="item in col.links" :key="item.href + item.label">
                        <component
                            :is="isPlain(item.href) ? 'a' : Link"
                            :href="item.href"
                            v-bind="linkProps(item.href)"
                            class="group flex min-h-9 items-center gap-2.5 hover:text-white"
                        >
                            <Icon v-if="item.icon" :name="item.icon" class="h-4 w-4 shrink-0 text-brand-400 transition group-hover:text-accent-400" />
                            {{ item.label }}
                        </component>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">{{ c('layout.footer.contact_title') }}</h4>
                <ul class="mt-5 space-y-3.5 text-sm">
                    <li class="flex items-start gap-2.5">
                        <Icon name="phone" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400" />
                        <span class="flex flex-col">
                            <a :href="`tel:${settings.hotline}`" class="hover:text-white">{{ settings.hotline }}</a>
                            <a :href="`tel:${settings.phone}`" class="hover:text-white">{{ settings.phone }}</a>
                        </span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <Icon name="envelope" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400" />
                        {{ settings.email }}
                    </li>
                    <li class="flex items-start gap-2.5">
                        <Icon name="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400" />
                        <a v-if="settings.map_url" :href="settings.map_url" target="_blank" rel="noopener noreferrer" class="hover:text-white">{{ settings.address }}</a>
                        <span v-else>{{ settings.address }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="relative border-t border-white/10">
            <div class="container-x flex flex-col items-center justify-between gap-2 py-6 text-xs text-slate-400 sm:flex-row">
                <p>&copy; {{ year }} {{ settings.site_name || 'EasyLink' }}. {{ c('layout.footer.copyright') }}</p>
                <p>
                    {{ settings.footer_text }}
                    <span class="mx-1">&middot;</span>
                    {{ c('layout.footer.credit_prefix') }}
                    <a :href="c('layout.footer.credit_url')" target="_blank" rel="noopener" class="font-medium text-slate-300 hover:text-white">{{ c('layout.footer.credit_name') }}</a>
                </p>
            </div>
        </div>
    </footer>
</template>
