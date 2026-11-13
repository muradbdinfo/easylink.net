<script setup>
import Icon from '@/Components/Icon.vue';
import { useContent } from '@/composables/useContent';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const settings = computed(() => page.props.settings ?? {});
const { c, list, richHtml } = useContent();

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

const columns = computed(() =>
    [
        { title: c('layout.footer.quick_title'), links: list('layout.footer.quick_links') },
        { title: c('layout.footer.company_title'), links: list('layout.footer.company_links') },
    ].filter((col) => col.links.length),
);

// "Who we are": Page content first, otherwise a short piece of the About text from Settings
const aboutText = computed(() => {
    const own = c('layout.footer.about_text');
    if (own) return own;
    const t = (settings.value.about_text ?? '').replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
    return t.length > 260 ? `${t.slice(0, 260).replace(/\s+\S*$/, '')}…` : t;
});
const schedule = computed(() => list('layout.footer.schedule'));
</script>

<template>
    <footer>
        <div class="bg-white">
            <div class="container-x grid grid-cols-1 gap-12 py-16 sm:grid-cols-2 lg:grid-cols-4 lg:py-20">
                <!-- contact -->
                <div>
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-accent-100 text-accent-600"><Icon name="headset" class="h-6 w-6" /></span>
                        <div>
                            <p class="text-sm font-medium text-slate-500">{{ c('layout.footer.call_label') }}</p>
                            <a :href="`tel:${settings.hotline}`" class="block text-lg font-semibold leading-tight text-slate-900 hover:text-accent-600">{{ settings.hotline }}</a>
                            <a v-if="settings.phone" :href="`tel:${settings.phone}`" class="block text-lg font-semibold leading-tight text-slate-900 hover:text-accent-600">{{ settings.phone }}</a>
                        </div>
                    </div>

                    <h4 class="mt-8 font-display text-lg font-medium text-slate-900">{{ c('layout.footer.contact_info_title') }}</h4>
                    <p class="mt-3 text-sm leading-7 text-slate-500">
                        <a v-if="settings.map_url" :href="settings.map_url" target="_blank" rel="noopener noreferrer" class="hover:text-accent-600">{{ settings.address }}</a>
                        <span v-else>{{ settings.address }}</span>
                    </p>
                    <a v-if="settings.email" :href="`mailto:${settings.email}`" class="mt-1 block text-sm text-slate-500 hover:text-accent-600">{{ settings.email }}</a>

                    <div class="mt-6 flex flex-wrap gap-2">
                        <a
                            v-for="s in social"
                            :key="s.key"
                            :href="settings[s.key]"
                            target="_blank"
                            rel="noopener"
                            :aria-label="s.label"
                            :title="s.label"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-xs font-semibold text-slate-700 transition duration-200 hover:-translate-y-1 hover:border-accent-500 hover:bg-accent-500 hover:text-white hover:shadow-lg hover:shadow-accent-500/30"
                        >
                            {{ s.label[0] }}
                        </a>
                    </div>
                </div>

                <!-- links -->
                <div class="space-y-8">
                    <div v-for="col in columns" :key="col.title">
                        <h4 class="text-sm font-semibold uppercase tracking-wide text-slate-900">{{ col.title }}</h4>
                        <ul class="mt-4 space-y-1 text-sm text-slate-500">
                            <li v-for="item in col.links" :key="item.href + item.label">
                                <component :is="isPlain(item.href) ? 'a' : Link" :href="item.href" v-bind="linkProps(item.href)" class="flex min-h-9 items-center transition duration-200 hover:translate-x-1.5 hover:text-accent-600">
                                    {{ item.label }}
                                </component>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- who we are -->
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wide text-slate-900">{{ c('layout.footer.about_title') }}</h4>
                    <div class="rich mt-4 text-sm leading-7 text-slate-500" v-html="richHtml(aboutText)" />
                </div>

                <!-- schedule -->
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wide text-slate-900">{{ c('layout.footer.schedule_title') }}</h4>
                    <ul class="mt-4 space-y-4 text-sm">
                        <li v-for="(row, i) in schedule" :key="i">
                            <p class="text-slate-500">{{ row.days }}</p>
                            <p class="font-semibold text-slate-900">{{ row.time }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-brand-900 text-slate-300">
            <div class="container-x flex flex-col items-center justify-between gap-4 py-6 text-sm sm:flex-row">
                <span class="inline-flex rounded-lg bg-white p-1.5"><img :src="settings.logo || '/logo/logo-notag.png'" :alt="settings.site_name || 'EasyLink'" class="h-10 w-auto object-contain" /></span>
                <p class="text-center text-xs text-slate-300 sm:text-right">
                    &copy; {{ year }} {{ settings.site_name || 'EasyLink' }}. {{ c('layout.footer.copyright') }}
                    <span v-if="settings.footer_text" class="mx-1">&middot;</span>{{ settings.footer_text }}
                    <span class="mx-1">&middot;</span>
                    {{ c('layout.footer.credit_prefix') }}
                    <a :href="c('layout.footer.credit_url')" target="_blank" rel="noopener" class="font-medium text-white hover:underline">{{ c('layout.footer.credit_name') }}</a>
                </p>
            </div>
        </div>
    </footer>
</template>
