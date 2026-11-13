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
    isActive(item.href) ? 'text-accent-500 after:scale-x-100' : 'text-slate-900 hover:text-accent-500';
const iconClass = (item) => (isActive(item.href) ? 'text-accent-500' : 'text-slate-400 group-hover:text-accent-500');
</script>

<template>
    <header class="sticky top-0 z-50 border-b border-slate-100 bg-white shadow-sm">
        <div class="bg-gradient-to-r from-brand-900 via-brand-800 to-brand-900 text-slate-200">
            <div class="container-x flex h-10 items-center justify-between gap-3 text-xs">
                <!-- contact -->
                <div class="flex min-w-0 items-center gap-5">
                    <a v-if="settings.hotline" :href="`tel:${settings.hotline}`" class="group flex items-center gap-2 whitespace-nowrap font-medium text-white">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white/10 transition group-hover:bg-accent-500"><Icon name="phone" class="h-3.5 w-3.5" /></span>
                        <span class="hidden text-slate-300 sm:inline">{{ c('layout.header.support_label') }}</span>
                        {{ settings.hotline }}
                    </a>
                    <a v-if="settings.email" :href="`mailto:${settings.email}`" class="hidden items-center gap-2 whitespace-nowrap transition hover:text-white lg:flex">
                        <Icon name="envelope" class="h-3.5 w-3.5 text-accent-300" />
                        {{ settings.email }}
                    </a>
                </div>

                <!-- self care + admin -->
                <div class="flex shrink-0 items-center gap-3">
                    <Link v-if="user" :href="route('admin.dashboard')" class="flex items-center gap-1.5 whitespace-nowrap transition hover:text-white">
                        <Icon name="cog" class="h-3.5 w-3.5" />
                        {{ c('layout.header.admin_label') }}
                    </Link>
                    <a
                        v-if="c('layout.header.selfcare_url')"
                        :href="c('layout.header.selfcare_url')"
                        v-bind="linkProps(c('layout.header.selfcare_url'))"
                        class="group flex items-center gap-2 whitespace-nowrap rounded-full bg-white/10 py-1 pl-1 pr-3.5 font-semibold text-white ring-1 ring-white/25 transition duration-300 hover:bg-white hover:text-brand-900 hover:shadow-lg hover:shadow-accent-500/30"
                    >
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-accent-500 text-white transition duration-300 group-hover:rotate-[360deg]"><Icon name="key" class="h-3.5 w-3.5" /></span>
                        {{ c('layout.header.selfcare_label') }}
                        <Icon name="chevron-right" class="h-3 w-3 transition duration-300 group-hover:translate-x-0.5" />
                    </a>
                </div>
            </div>
        </div>

        <div ref="row" class="container-x relative flex h-[72px] items-center justify-between gap-4">
            <Link ref="logo" :href="route('home')" class="flex shrink-0 items-center gap-2">
                <img :src="settings.logo || '/logo/logo-notag.png'" :alt="settings.site_name || 'EasyLink'" class="h-12 w-auto object-contain" />
                <span v-if="c('layout.header.logo_tagline')" class="max-w-[5.6rem] border-l-2 border-accent-500 pl-2 text-[9px] font-semibold uppercase leading-tight tracking-[0.12em] text-brand-900">{{ c('layout.header.logo_tagline') }}</span>
            </Link>

            <!-- invisible copy of the full menu, only used to measure whether it fits -->
            <div ref="measurer" aria-hidden="true" class="pointer-events-none invisible absolute left-0 top-0 -z-10 flex h-0 w-max items-center gap-6 overflow-hidden">
                <nav data-nav class="flex items-center">
                    <span v-for="item in nav" :key="item.href + item.label" class="flex items-center gap-1.5 px-1.5 py-2 text-[12.5px] font-medium uppercase whitespace-nowrap">
                        <Icon v-if="item.icon" :name="item.icon" class="h-4 w-4 shrink-0" />
                        {{ item.label }}
                    </span>
                </nav>
                <span data-btn class="btn-primary !py-2.5 whitespace-nowrap">{{ c('layout.header.button_label') }}</span>
            </div>

            <nav v-if="!collapsed" class="ml-auto flex min-w-0 items-center">
                <component
                    :is="isPlain(item.href) ? 'a' : Link"
                    v-for="item in nav"
                    :key="item.href + item.label"
                    :href="item.href"
                    v-bind="linkProps(item.href)"
                    class="group relative flex items-center gap-1.5 px-1.5 py-2 text-[12.5px] font-medium uppercase whitespace-nowrap transition after:absolute after:inset-x-1.5 after:bottom-0 after:h-0.5 after:origin-left after:scale-x-0 after:rounded-full after:bg-accent-500 after:transition-transform after:duration-300 hover:after:scale-x-100"
                    :class="navClass(item)"
                >
                    
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
                    :class="isActive(item.href) ? 'bg-accent-100/60 text-accent-600' : 'text-slate-700 hover:bg-slate-50'"
                    @click="mobileOpen = false"
                >
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl" :class="isActive(item.href) ? 'bg-accent-500 text-white' : 'bg-slate-100 text-slate-600'">
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
