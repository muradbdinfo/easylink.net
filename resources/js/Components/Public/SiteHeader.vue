<script setup>
import Icon from '@/Components/Icon.vue';
import { useContent } from '@/composables/useContent';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';

const page = usePage();
const settings = computed(() => page.props.settings ?? {});
const user = computed(() => page.props.auth?.user);
const { c, list } = useContent();

const mobileOpen = ref(false);

// Paths on this site use Inertia <Link>; full addresses and #anchors are plain <a>.
const isPlain = (href) => /^(https?:|mailto:|tel:)/.test(href) || href.includes('#');
const external = (href) => /^https?:/.test(href) && new URL(href).origin !== window.location.origin;

const nav = computed(() => list('layout.menu'));

const isActive = (href) => !isPlain(href) && page.url.split('?')[0] === new URL(href, window.location.origin).pathname;
const linkProps = (href) => (external(href) ? { target: '_blank', rel: 'noopener noreferrer' } : {});

// The full menu is only shown when it really fits next to the logo and the button
// (measured from an invisible copy), otherwise the hamburger menu is used — so items can never overlap,
// whatever the screen width or however long the admin makes the labels.
const row = ref(null);
const logo = ref(null);
const measurer = ref(null);
const collapsed = ref(true);

const fit = () => {
    if (!row.value || !measurer.value) return;

    const style = getComputedStyle(row.value);
    const available = row.value.clientWidth - parseFloat(style.paddingLeft) - parseFloat(style.paddingRight);
    const navW = measurer.value.querySelector('[data-nav]')?.getBoundingClientRect().width ?? 0;
    const btnW = measurer.value.querySelector('[data-btn]')?.getBoundingClientRect().width ?? 0;
    const needed = (logo.value?.$el?.getBoundingClientRect().width ?? 0) + navW + btnW + 2 * 16 + 8;

    collapsed.value = needed > available;
    if (!collapsed.value) mobileOpen.value = false;
};

let observer;
onMounted(async () => {
    await nextTick();
    fit();
    observer = new ResizeObserver(fit);
    observer.observe(row.value);
    document.fonts?.ready.then(fit);
});
onUnmounted(() => observer?.disconnect());
watch([nav, () => c('layout.header.button_label'), () => settings.value.site_name, () => settings.value.logo], () => nextTick(fit));

const navClass = (item) =>
    isActive(item.href) ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-900';
const iconClass = (item) => (isActive(item.href) ? 'text-brand-600' : 'text-slate-400 group-hover:text-brand-600');
</script>

<template>
    <header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/85 backdrop-blur-lg">
        <div class="bg-brand-900 text-slate-300">
            <div class="container-x flex h-9 items-center justify-between text-xs">
                <div class="hidden items-center gap-5 self-stretch sm:flex">
                    <a :href="`mailto:${settings.email}`" class="flex items-center gap-1.5 self-stretch hover:text-white">
                        <Icon name="envelope" class="h-3.5 w-3.5" />
                        {{ settings.email }}
                    </a>
                    <span class="hidden items-center gap-1.5 lg:flex">
                        <Icon name="map-pin" class="h-3.5 w-3.5" />
                        {{ settings.address }}
                    </span>
                </div>
                <div class="flex w-full items-center justify-between gap-4 self-stretch whitespace-nowrap sm:w-auto sm:justify-end">
                    <a :href="`tel:${settings.hotline}`" class="flex items-center gap-1.5 self-stretch font-semibold text-brand-300">
                        <Icon name="phone" class="h-3.5 w-3.5" />
                        {{ c('layout.header.support_label') }} {{ settings.hotline }}
                    </a>
                    <Link v-if="user" :href="route('admin.dashboard')" class="flex items-center gap-1.5 self-stretch hover:text-white">
                        <Icon name="cog" class="h-3.5 w-3.5" />
                        {{ c('layout.header.admin_label') }}
                    </Link>
                    <a v-else :href="c('layout.header.selfcare_url')" v-bind="linkProps(c('layout.header.selfcare_url'))" class="flex items-center gap-1.5 self-stretch hover:text-white">
                        <Icon name="key" class="h-3.5 w-3.5" />
                        {{ c('layout.header.selfcare_label') }}
                    </a>
                </div>
            </div>
        </div>

        <div ref="row" class="container-x relative flex h-[72px] items-center justify-between gap-4">
            <Link ref="logo" :href="route('home')" class="flex shrink-0 items-center gap-2.5">
                <img :src="settings.logo || '/images/logo-mark.png'" alt="EasyLink logo" class="h-12 w-12 object-contain" />
                <span class="font-display text-xl font-extrabold tracking-tight whitespace-nowrap text-brand-900">{{ settings.site_name || 'EasyLink' }}</span>
            </Link>

            <!-- invisible copy of the full menu, only used to measure whether it fits -->
            <div ref="measurer" aria-hidden="true" class="pointer-events-none invisible absolute left-0 top-0 -z-10 flex h-0 w-max items-center gap-6 overflow-hidden">
                <nav data-nav class="flex items-center gap-0.5">
                    <span v-for="item in nav" :key="item.href + item.label" class="flex items-center gap-1.5 rounded-full px-2.5 py-2 text-sm font-medium whitespace-nowrap">
                        <Icon v-if="item.icon" :name="item.icon" class="h-4 w-4 shrink-0" />
                        {{ item.label }}
                    </span>
                </nav>
                <span data-btn class="btn-primary !py-2.5 whitespace-nowrap">{{ c('layout.header.button_label') }}</span>
            </div>

            <nav v-if="!collapsed" class="flex min-w-0 items-center gap-0.5">
                <component
                    :is="isPlain(item.href) ? 'a' : Link"
                    v-for="item in nav"
                    :key="item.href + item.label"
                    :href="item.href"
                    v-bind="linkProps(item.href)"
                    class="group flex items-center gap-1.5 rounded-full px-2.5 py-2 text-sm font-medium whitespace-nowrap transition"
                    :class="navClass(item)"
                >
                    <Icon v-if="item.icon" :name="item.icon" class="h-4 w-4 shrink-0 transition" :class="iconClass(item)" />
                    {{ item.label }}
                </component>
            </nav>

            <div v-if="!collapsed" class="flex shrink-0">
                <component :is="isPlain(c('layout.header.button_url')) ? 'a' : Link" :href="c('layout.header.button_url')" class="btn-primary !py-2.5 whitespace-nowrap">
                    {{ c('layout.header.button_label') }}
                </component>
            </div>

            <button v-else class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg" :aria-label="c('layout.header.menu_label')" :aria-expanded="mobileOpen" @click="mobileOpen = !mobileOpen">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-brand-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path v-if="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div v-if="collapsed && mobileOpen" class="max-h-[calc(100vh-108px)] overflow-y-auto border-t border-slate-100 bg-white">
            <nav class="container-x flex flex-col gap-1 py-3">
                <component
                    :is="isPlain(item.href) ? 'a' : Link"
                    v-for="item in nav"
                    :key="item.href + item.label"
                    :href="item.href"
                    v-bind="linkProps(item.href)"
                    class="flex min-h-12 items-center gap-3 rounded-xl px-3 py-2 text-[15px] font-medium"
                    :class="isActive(item.href) ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50'"
                    @click="mobileOpen = false"
                >
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl" :class="isActive(item.href) ? 'bg-brand-600 text-white' : 'bg-brand-50 text-brand-600'">
                        <Icon :name="item.icon || 'sparkles'" class="h-5 w-5" />
                    </span>
                    {{ item.label }}
                </component>
                <component :is="isPlain(c('layout.header.button_url')) ? 'a' : Link" :href="c('layout.header.button_url')" class="btn-primary mt-3" @click="mobileOpen = false">
                    {{ c('layout.header.button_label') }}
                </component>
            </nav>
        </div>
    </header>
</template>
