<script setup>
import Icon from '@/Components/Icon.vue';
import PackageCard from '@/Components/Public/PackageCard.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useContent } from '@/composables/useContent';
import { tone } from '@/composables/useTones';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps({
    sliders: Array,
    homePackages: Array,
    heroPackages: { type: Array, default: () => [] },
    services: Array,
    stats: Array,
    testimonials: Array,
    clients: Array,
    partners: Array,
    posts: Array,
    faqs: { type: Array, default: () => [] },
});

const settings = computed(() => usePage().props.settings ?? {});
const openFaq = ref(null);
const toggleFaq = (id) => (openFaq.value = openFaq.value === id ? null : id);

const active = ref(0);
let timer = null;

onMounted(() => {
    if (props.sliders.length > 1) {
        timer = setInterval(() => {
            active.value = (active.value + 1) % props.sliders.length;
        }, 6000);
    }
});
onUnmounted(() => clearInterval(timer));

const currentSlide = computed(() => props.sliders[active.value]);
const go = (step) => (active.value = (active.value + step + props.sliders.length) % props.sliders.length);

const { c, list, richHtml } = useContent();

const reasons = computed(() => list('home.why.items'));
const app = computed(() => ({ title: c('home.app.title'), desc: c('home.app.desc'), href: c('home.app.href'), button: c('home.app.button'), icon: c('home.app.icon') || 'cloud' }));
const entertainment = computed(() => list('home.ent.items'));
// Hero card: the real home packages take turns (name, price, speed). A slide can still carry its own custom
// speed in Admin → Sliders; then the card shows that instead of a package.
const reduceMotion = typeof window !== 'undefined' && window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;
const pkgIndex = ref(0);
const paused = ref(false);
const pkg = computed(() => props.heroPackages[pkgIndex.value % Math.max(props.heroPackages.length, 1)] ?? null);
const custom = computed(() => {
    const s = currentSlide.value || {};
    return s.speed_value ? { speed: parseFloat(s.speed_value) || 0, unit: s.speed_unit || 'Mbps', download: s.download, upload: s.upload } : null;
});
const maxSpeed = computed(() => Math.max(1, ...props.heroPackages.map((p) => Number(p.speed_mbps) || 0)));
const target = computed(() => (custom.value ? custom.value.speed : Number(pkg.value?.speed_mbps) || 0));
const cardUnit = computed(() => custom.value?.unit || 'Mbps');
const fmtPrice = (v) => Number(v).toLocaleString('en-US', { maximumFractionDigits: 0 });

// count-up of the big number, and the ring that fills up to the plan's share of the fastest plan
const counter = ref(0);
let raf = null;
watch(
    target,
    (to) => {
        cancelAnimationFrame(raf);
        if (reduceMotion) {
            counter.value = to;
            return;
        }
        const from = counter.value;
        const t0 = performance.now();
        const step = (t) => {
            const k = Math.min(1, (t - t0) / 900);
            counter.value = Math.round(from + (to - from) * (1 - Math.pow(1 - k, 3)));
            if (k < 1) raf = requestAnimationFrame(step);
        };
        raf = requestAnimationFrame(step);
    },
    { immediate: true },
);
const RING = 2 * Math.PI * 54;
const ringOffset = computed(() => RING * (1 - Math.min(1, target.value / maxSpeed.value)));
const pickPackage = (i) => (pkgIndex.value = i);

let pkgTimer = null;
onMounted(() => {
    if (props.heroPackages.length > 1) {
        pkgTimer = setInterval(() => {
            if (!paused.value) pkgIndex.value = (pkgIndex.value + 1) % props.heroPackages.length;
        }, 3500);
    }
});
onUnmounted(() => {
    clearInterval(pkgTimer);
    cancelAnimationFrame(raf);
});

// repeat short lists so the marquee track is always wider than the viewport
const logos = computed(() => {
    const list = [...props.clients, ...props.partners];
    if (!list.length) return [];
    return Array.from({ length: Math.max(1, Math.ceil(10 / list.length)) }, () => list).flat();
});

// picture position is a layout detail (slide 3 is a portrait photo); the pictures themselves are editable
const heroPositions = ['center 30%', 'center 30%', 'center 30%', 'center 30%', 'center 30%', 'center 30%'];
const slideBg = (slide, i) => {
    const n = i % heroPositions.length;
    return {
        backgroundImage: `url('${slide.image ? `/storage/${slide.image}` : c(`home.hero.image_${n + 1}`)}')`,
        backgroundPosition: slide.image ? 'center' : heroPositions[n],
    };
};

// "৳525 /Month" under the hero heading: Page content wins, otherwise the cheapest home package
const heroPrice = computed(() => {
    const own = c('home.hero.price');
    if (own) return own;
    const prices = props.homePackages.map((p) => Number(p.price)).filter((n) => n > 0);
    return prices.length ? Math.min(...prices).toLocaleString('en-US') : '';
});

// fade-up when a block scrolls into view (optional delay in ms as the directive value)
const vReveal = {
    mounted(el, binding) {
        if (!('IntersectionObserver' in window)) return;
        el.classList.add('reveal');
        el.style.setProperty('--d', `${binding.value ?? 0}ms`);
        const io = new IntersectionObserver(
            ([entry]) => {
                if (!entry.isIntersecting) return;
                el.classList.add('reveal-in');
                io.disconnect();
            },
            { threshold: 0.12 },
        );
        io.observe(el);
    },
};

// cursor position inside a card, used by the glow
const spot = (e) => {
    const r = e.currentTarget.getBoundingClientRect();
    e.currentTarget.style.setProperty('--mx', `${e.clientX - r.left}px`);
    e.currentTarget.style.setProperty('--my', `${e.clientY - r.top}px`);
};

const logoSrc = (logo) => (logo.startsWith('/') || logo.startsWith('http') ? logo : `/storage/${logo}`);

// a post without its own picture gets a matching stock photo, chosen from its title
const cover = (post) => {
    if (post.image) return `/storage/${post.image}`;
    const t = post.title ?? '';
    const photo = /gam|stream|tv|movie/i.test(t) ? 'father-son-tv' : /home|office|work|plan|choose/i.test(t) ? 'man-laptop-home' : 'router-wifi';
    return `/images/stock/${photo}.jpg`;
};

// customer photo: uploaded one, otherwise a stock portrait
const avatar = (t, i) => (t.photo ? `/storage/${t.photo}` : `/images/stock/people/person-${(i % 4) + 1}.jpg`);
const formatDate = (d) => new Date(d).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
</script>

<template>
    <Head title="Home" />

    <PublicLayout>
        <!-- Hero slider (full width picture, IQTEL layout: text left, customer-service pill under the picture) -->
        <section class="relative bg-white">
            <div class="relative overflow-hidden bg-brand-900">
                <!-- full-width picture, crossfading between slides -->
                <div
                    v-for="(s, i) in sliders"
                    :key="`bg-${s.id}`"
                    class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
                    :class="i === active ? 'opacity-100' : 'opacity-0'"
                    :style="slideBg(s, i)"
                />
                <!-- navy only behind the text, the right side of the picture stays clear -->
                <div class="absolute inset-0 bg-gradient-to-r from-brand-900/95 via-brand-900/55 to-transparent max-lg:from-brand-900/90 max-lg:via-brand-900/70 max-lg:to-brand-900/40" />
                <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-brand-900/50 to-transparent" />

                <div class="container-x relative flex min-h-[600px] items-center py-16 lg:min-h-[680px] lg:py-24">
                    <div class="max-w-xl text-white">
                        <Transition
                            mode="out-in"
                            enter-active-class="transition duration-500 ease-out"
                            enter-from-class="opacity-0 translate-y-4"
                            leave-active-class="transition duration-200"
                            leave-to-class="opacity-0"
                        >
                            <div :key="active">
                                <span v-if="c('home.hero.badge')" class="eyebrow-dark">{{ c('home.hero.badge') }}</span>
                                <h1 class="mt-5 font-sans text-4xl font-semibold leading-[1.1] tracking-tight sm:text-5xl lg:text-6xl">{{ currentSlide?.title }}</h1>
                                <p class="mt-5 max-w-md text-lg font-medium text-slate-200">{{ currentSlide?.subtitle }}</p>
                                <p v-if="heroPrice" class="mt-6 flex items-baseline gap-2">
                                    <span class="font-sans text-4xl font-medium text-accent-300 sm:text-5xl">৳</span>
                                    <span class="font-sans text-5xl font-semibold sm:text-6xl">{{ heroPrice }}</span>
                                    <span class="text-base text-slate-300">{{ c('home.hero.price_unit') }}</span>
                                </p>
                                <div class="mt-8 flex flex-wrap gap-3">
                                    <Link v-if="currentSlide?.button_link" :href="currentSlide.button_link" class="btn-primary">
                                        {{ currentSlide.button_text }}
                                        <Icon name="chevron-right" class="h-4 w-4" />
                                    </Link>
                                    <Link :href="route('coverage.index')" class="btn-outline">{{ c('home.hero.coverage_button') }}</Link>
                                </div>
                            </div>
                        </Transition>

                        <div v-if="sliders.length > 1" class="mt-10 flex items-center gap-3">
                            <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/40 transition hover:bg-white hover:text-brand-900" aria-label="Previous slide" @click="go(-1)">
                                <Icon name="chevron-right" class="h-5 w-5 rotate-180" />
                            </button>
                            <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/40 transition hover:bg-white hover:text-brand-900" aria-label="Next slide" @click="go(1)">
                                <Icon name="chevron-right" class="h-5 w-5" />
                            </button>
                            <div class="ml-2 flex">
                                <button v-for="(s, i) in sliders" :key="s.id" :aria-label="`Show slide ${i + 1}`" class="group flex h-6 items-center px-1.5" @click="active = i">
                                    <span class="h-1.5 rounded-full transition-all" :class="i === active ? 'w-10 bg-accent-400' : 'w-4 bg-white/40 group-hover:bg-white/60'" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- plan card: real packages, count-up speed, spinning ring -->
                    <div
                        class="absolute right-6 top-10 hidden w-64 rounded-2xl border border-white/25 bg-brand-900/60 p-5 text-white shadow-2xl shadow-black/30 backdrop-blur-md lg:block xl:right-12"
                        @mouseenter="paused = true"
                        @mouseleave="paused = false"
                    >
                        <div class="flex items-center justify-between text-[11px] font-semibold uppercase tracking-wider text-slate-300">
                            <span>{{ c('home.speed.title') }}</span>
                            <span v-if="c('home.speed.status')" class="flex items-center gap-1.5 text-accent-300"><span class="h-1.5 w-1.5 rounded-full bg-accent-400" />{{ c('home.speed.status') }}</span>
                        </div>

                        <!-- ring with the animated number -->
                        <div class="relative mx-auto mt-4 h-36 w-36">
                            <!-- slow spinner around the ring -->
                            <svg class="absolute inset-0 h-full w-full animate-spin text-accent-400/60" style="animation-duration: 14s" viewBox="0 0 120 120" fill="none" aria-hidden="true">
                                <circle cx="60" cy="60" r="58" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3 9" stroke-linecap="round" />
                            </svg>
                            <svg class="absolute inset-0 h-full w-full -rotate-90" viewBox="0 0 120 120" fill="none" aria-hidden="true">
                                <circle cx="60" cy="60" r="54" stroke="rgb(255 255 255 / 0.12)" stroke-width="7" />
                                <circle
                                    cx="60"
                                    cy="60"
                                    r="54"
                                    stroke="url(#ringGrad)"
                                    stroke-width="7"
                                    stroke-linecap="round"
                                    :stroke-dasharray="RING"
                                    :stroke-dashoffset="ringOffset"
                                    style="transition: stroke-dashoffset 0.9s cubic-bezier(0.22, 1, 0.36, 1)"
                                />
                                <defs>
                                    <linearGradient id="ringGrad" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0" stop-color="#3aa0ee" />
                                        <stop offset="1" stop-color="#8cc6f7" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span v-if="c('home.speed.prefix')" class="text-[10px] font-medium uppercase tracking-wider text-accent-300">{{ c('home.speed.prefix') }}</span>
                                <span class="font-sans text-4xl font-semibold tabular-nums leading-none">{{ counter }}</span>
                                <span class="mt-0.5 text-xs font-medium text-slate-300">{{ cardUnit }}</span>
                            </div>
                        </div>

                        <!-- package name and price -->
                        <Transition mode="out-in" enter-active-class="transition duration-300" enter-from-class="opacity-0 translate-y-2" leave-active-class="transition duration-150" leave-to-class="opacity-0">
                            <div v-if="pkg && !custom" :key="pkg.id" class="mt-4 text-center">
                                <p class="font-display text-lg tracking-wide">{{ pkg.name }}</p>
                                <p class="mt-1 text-accent-300"><span class="font-sans text-2xl font-semibold text-white">৳{{ fmtPrice(pkg.price) }}</span> <span class="text-xs">{{ pkg.price_note }}</span></p>
                            </div>
                        </Transition>

                        <!-- download / upload with moving arrows -->
                        <div class="mt-4 grid grid-cols-2 gap-2 text-center text-xs">
                            <div class="rounded-xl bg-white/10 px-2 py-2">
                                <Icon name="arrow-down-tray" class="mx-auto h-4 w-4 animate-bounce text-accent-300" />
                                <p class="mt-1 text-slate-300">{{ c('home.speed.download') }}</p>
                                <p class="font-semibold tabular-nums">{{ custom?.download || `${counter} ${cardUnit}` }}</p>
                            </div>
                            <div v-if="c('home.speed.show_upload') !== '0'" class="rounded-xl bg-white/10 px-2 py-2">
                                <Icon name="arrow-up-tray" class="mx-auto h-4 w-4 animate-bounce text-accent-300" style="animation-delay: 0.5s" />
                                <p class="mt-1 text-slate-300">{{ c('home.speed.upload') }}</p>
                                <p class="font-semibold tabular-nums">{{ custom?.upload || `${counter} ${cardUnit}` }}</p>
                            </div>
                        </div>

                        <!-- which package is showing -->
                        <div v-if="!custom && heroPackages.length > 1" class="mt-4 flex justify-center gap-1.5">
                            <button
                                v-for="(p, i) in heroPackages"
                                :key="p.id"
                                :aria-label="p.name"
                                class="h-1.5 rounded-full transition-all"
                                :class="i === pkgIndex % heroPackages.length ? 'w-5 bg-accent-400' : 'w-1.5 bg-white/30 hover:bg-white/60'"
                                @click="pickPackage(i)"
                            />
                        </div>

                        <Link v-if="pkg && !custom" :href="route('contact.index', { package_id: pkg.id, type: 'package' })" class="btn-primary mt-4 w-full !py-2.5 text-xs">
                            {{ c('home.speed.order_button') }}
                            <Icon name="chevron-right" class="h-3.5 w-3.5" />
                        </Link>
                        <p v-if="c('home.speed.badge_title')" class="mt-3 flex items-center justify-center gap-2 border-t border-white/15 pt-3 text-xs text-slate-300">
                            <Icon name="check" class="h-4 w-4 text-accent-300" />
                            <span><span class="font-semibold text-white">{{ c('home.speed.badge_title') }}</span> {{ c('home.speed.badge_text') }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- customer service pill, half over the next section -->
            <div v-if="settings.hotline" class="container-x pointer-events-none absolute inset-x-0 -bottom-9 z-10 flex justify-end">
                <a :href="`tel:${settings.hotline}`" class="pointer-events-auto flex items-center gap-4 rounded-full border border-slate-100 bg-white px-8 py-4 shadow-xl shadow-slate-900/10 lg:mr-[18%]">
                    <Icon name="phone" class="h-9 w-9 text-accent-500" />
                    <span>
                        <span class="block text-sm text-slate-500">{{ c('home.hero.phone_label') }}</span>
                        <span class="block text-xl font-semibold text-accent-600">{{ settings.hotline }}</span>
                    </span>
                </a>
            </div>
        </section>

        <!-- Home packages -->
        <section class="bg-white pb-20 pt-28 sm:pb-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="font-display text-4xl font-normal leading-tight text-slate-900 sm:text-5xl">{{ c('home.plans.title') }}</h2>
                    <p class="section-subtitle">{{ c('home.plans.subtitle') }}</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <PackageCard v-for="pkg in homePackages" :key="pkg.id" :pkg="pkg" />
                </div>
                <div class="mt-12 text-center">
                    <Link :href="route('packages.index')" class="btn-secondary">{{ c('home.plans.button') }}</Link>
                </div>
            </div>
        </section>

        <!-- Video / features -->
        <section class="relative overflow-hidden bg-slate-50">
            <div class="container-x grid items-center gap-12 py-20 lg:grid-cols-2 lg:py-24">
                <div v-reveal class="relative overflow-hidden rounded-xl shadow-xl shadow-slate-900/10">
                    <img :src="c('home.video.image')" :alt="c('home.video.title')" loading="lazy" class="h-[320px] w-full object-cover sm:h-[440px]" />
                    <span class="absolute inset-0 bg-brand-900/20" />
                    <a
                        v-if="c('home.video.url')"
                        :href="c('home.video.url')"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Play video"
                        class="absolute inset-0 m-auto flex h-20 w-20 items-center justify-center rounded-full bg-white text-accent-600 ring-8 ring-white/40 transition hover:scale-110"
                    >
                        <svg viewBox="0 0 24 24" class="ml-1 h-8 w-8 fill-current"><path d="M8 5v14l11-7z" /></svg>
                    </a>
                </div>
                <div>
                    <h2 class="section-title">{{ c('home.video.title') }}</h2>
                    <p class="mt-6 text-base leading-relaxed text-slate-500">{{ c('home.video.text') }}</p>
                    <div class="mt-8 grid grid-cols-3 gap-4">
                        <div v-for="(st, i) in list('home.video.stats')" :key="i">
                            <p class="font-display text-2xl font-medium text-accent-600 sm:text-3xl">{{ st.value }}</p>
                            <p class="mt-1 text-sm font-medium text-slate-800">{{ st.label }}</p>
                        </div>
                    </div>
                    <Link :href="c('home.video.button_link')" class="btn-primary mt-9">{{ c('home.video.button') }}</Link>
                </div>
            </div>
        </section>

        <!-- Services (bordered grid, IQTEL style, interactive) -->
        <section class="bg-white py-20 sm:py-24">
            <div class="container-x">
                <div v-reveal class="mx-auto max-w-2xl text-center">
                    <h2 class="font-display text-4xl font-medium leading-tight text-slate-900 sm:text-5xl">{{ c('home.services.title') }}</h2>
                    <p class="section-subtitle">{{ c('home.services.subtitle') }}</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-px overflow-hidden rounded-xl border border-slate-200 bg-slate-200 md:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="(service, i) in services"
                        :key="service.id"
                        v-reveal="(i % 3) * 120"
                        :href="route('services.show', service.slug)"
                        class="service-cell group relative overflow-hidden bg-white p-8 outline-none transition duration-300 hover:z-10 hover:shadow-2xl hover:shadow-accent-500/20 focus-visible:z-10 focus-visible:ring-2 focus-visible:ring-accent-500 sm:p-10"
                        @mousemove="spot"
                    >
                        <!-- glow that follows the cursor -->
                        <span class="service-glow pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100" />
                        <!-- line that grows on hover -->
                        <span class="absolute inset-x-0 bottom-0 h-1 origin-left scale-x-0 bg-accent-500 transition-transform duration-500 group-hover:scale-x-100" />
                        <!-- big faint icon in the corner -->
                        <Icon :name="service.icon" class="pointer-events-none absolute -bottom-8 -right-8 h-40 w-40 rotate-12 stroke-[0.75] text-accent-500 opacity-0 transition duration-500 group-hover:-rotate-6 group-hover:opacity-10" />

                        <span class="relative flex h-16 w-16 items-center justify-center rounded-2xl border border-accent-200 bg-accent-100/40 text-accent-500 transition duration-300 group-hover:-translate-y-1 group-hover:scale-110 group-hover:border-accent-500 group-hover:bg-accent-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-accent-500/30">
                            <Icon :name="service.icon" class="h-9 w-9 stroke-[1.25]" />
                        </span>
                        <h3 class="relative mt-6 font-display text-xl text-slate-900 transition-colors duration-300 group-hover:text-accent-700">{{ service.title }}</h3>
                        <p class="relative mt-3 text-sm leading-7 text-slate-500">{{ service.short_description }}</p>
                        <span class="relative mt-5 inline-flex items-center gap-2 text-sm font-medium text-accent-600">
                            {{ c('home.services.link_label') }}
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-accent-100 transition duration-300 group-hover:translate-x-1.5 group-hover:bg-accent-500 group-hover:text-white"><Icon name="chevron-right" class="h-3.5 w-3.5" /></span>
                        </span>
                    </Link>
                </div>
                <div v-if="c('home.services.button')" v-reveal class="mt-10 text-center">
                    <Link :href="route('services.index')" class="btn-secondary">{{ c('home.services.button') }}</Link>
                </div>
            </div>
        </section>

        <!-- Call-to-action banner -->
        <section class="relative overflow-hidden bg-brand-900 py-20 text-center text-white sm:py-28">
            <div class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('home.cta.image')}')` }" />
            <div class="absolute inset-0 bg-brand-900/85" />
            <div class="container-x relative">
                <h2 class="mx-auto max-w-3xl font-display text-3xl font-normal leading-tight sm:text-5xl">{{ c('home.cta.title') }}</h2>
                <div class="mt-9 flex flex-wrap items-center justify-center gap-4">
                    <Link :href="c('home.cta.button_link')" class="btn-primary">{{ c('home.cta.button') }}</Link>
                    <span v-if="settings.hotline" class="text-sm font-medium uppercase">{{ c('home.cta.or') }}</span>
                    <a v-if="settings.hotline" :href="`tel:${settings.hotline}`" class="btn-outline !px-7 !py-3.5 uppercase">
                        <Icon name="phone" class="h-4 w-4" />
                        {{ settings.hotline }}
                    </a>
                </div>
            </div>
        </section>

        <!-- Why choose us -->
        <section class="relative overflow-hidden bg-brand-900 py-24 text-white">
            <div class="container-x relative grid grid-cols-1 items-center gap-14 lg:grid-cols-2">
                <div>
                    <span class="eyebrow-dark">{{ c('home.why.eyebrow') }}</span>
                    <h2 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">{{ c('home.why.title') }}</h2>
                    <p class="mt-4 text-lg text-slate-300">{{ c('home.why.subtitle') }}</p>
                    <div class="mt-10 grid grid-cols-1 gap-7 sm:grid-cols-2">
                        <div v-for="(item, i) in reasons" :key="`${i}-${item.title}`" class="flex items-start gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl ring-1" :class="tone(i).dark">
                                <Icon :name="item.icon" class="h-6 w-6" />
                            </span>
                            <div>
                                <p class="font-semibold">{{ item.title }}</p>
                                <p class="mt-1 text-sm text-slate-400">{{ item.desc }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden rounded-3xl border border-white/15 bg-white/10 shadow-2xl shadow-black/20 backdrop-blur">
                    <img :src="c('home.quote.image')" :alt="c('home.quote.image_alt')" loading="lazy" class="h-56 w-full object-cover object-top" />
                    <div class="p-9">
                    <h3 class="text-2xl font-bold">{{ c('home.quote.title') }}</h3>
                    <p class="mt-3 text-slate-300">{{ c('home.quote.text') }}</p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <Link :href="c('home.quote.button1_link')" class="btn-primary">{{ c('home.quote.button1_label') }}</Link>
                        <Link :href="c('home.quote.button2_link')" class="btn-outline">{{ c('home.quote.button2_label') }}</Link>
                    </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Affordable price promo -->
        <section class="relative overflow-hidden bg-white">
            <div class="container-x grid items-center gap-12 py-20 lg:grid-cols-2 lg:py-28">
                <div>
                    <h2 class="section-title">{{ c('home.promo.title') }}</h2>
                    <p class="mt-6 max-w-xl text-base leading-relaxed text-slate-500">{{ c('home.promo.text') }}</p>
                    <div class="mt-8 flex flex-wrap items-end gap-x-6 gap-y-3">
                        <p class="flex items-start font-display text-accent-600">
                            <span class="mt-2 text-2xl">{{ c('home.promo.currency') }}</span>
                            <span class="text-7xl font-medium leading-none">{{ c('home.promo.price') }}</span>
                        </p>
                        <p class="pb-1 text-sm text-slate-500">
                            {{ c('home.promo.period') }}<br />
                            <span class="font-medium text-slate-800">{{ c('home.promo.note') }}</span>
                        </p>
                    </div>
                    <Link :href="c('home.promo.button_link')" class="btn-secondary mt-9">{{ c('home.promo.button') }}</Link>
                </div>
                <div v-reveal="150" class="flex justify-center">
                    <img :src="c('home.promo.image')" alt="" loading="lazy" class="max-h-96 w-full max-w-lg rounded-2xl object-cover shadow-xl shadow-slate-900/10" />
                </div>
            </div>
        </section>

        <!-- Entertainment -->
        <section id="entertainment" class="relative scroll-mt-28 overflow-hidden bg-slate-50 py-24">

            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('home.ent.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('home.ent.title') }}</h2>
                    <p class="section-subtitle">{{ c('home.ent.subtitle') }}</p>
                </div>

                <!-- App download banner -->
                <a
                    :href="app.href"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group relative mt-14 flex flex-col items-start gap-6 overflow-hidden rounded-3xl bg-gradient-to-r from-brand-900 via-violet-700 to-fuchsia-600 p-8 text-white shadow-xl transition hover:shadow-2xl sm:flex-row sm:items-center sm:p-10"
                >
                    <div class="grid-bg absolute inset-0 opacity-40 [mask-image:radial-gradient(ellipse_at_right,black,transparent_70%)]" />
                    <span class="relative flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur">
                        <Icon :name="app.icon" class="h-8 w-8" />
                    </span>
                    <div class="relative flex-1">
                        <h3 class="text-2xl font-extrabold sm:text-3xl">{{ app.title }}</h3>
                        <p class="mt-1 text-brand-200">{{ app.desc }}</p>
                    </div>
                    <span class="btn-primary relative !bg-white !bg-none !text-brand-900 !shadow-none group-hover:!bg-violet-50">{{ app.button }}</span>
                </a>

                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                    <a
                        v-for="(item, i) in entertainment"
                        :key="`${i}-${item.href}`"
                        :href="item.href"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group relative flex min-h-[230px] flex-col overflow-hidden rounded-3xl bg-gradient-to-br p-7 text-white shadow-lg ring-1 ring-white/10 transition duration-500 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl"
                        :class="item.color"
                    >
                        <!-- texture + glow -->
                        <span class="grid-bg pointer-events-none absolute inset-0 opacity-30 [mask-image:linear-gradient(135deg,black,transparent_65%)]" />
                        <span class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/20 blur-2xl transition duration-500 group-hover:scale-150" />
                        <!-- watermark icon -->
                        <Icon :name="item.icon" class="pointer-events-none absolute -bottom-6 -right-4 h-36 w-36 -rotate-12 text-white/15 transition duration-500 group-hover:-rotate-6 group-hover:scale-125 group-hover:text-white/25" />
                        <!-- shine sweep -->
                        <span class="pointer-events-none absolute inset-y-0 -left-1/2 w-1/3 -skew-x-12 bg-white/25 opacity-0 blur-md transition-all duration-700 group-hover:left-[130%] group-hover:opacity-100" />

                        <div class="relative flex items-start justify-between">
                            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/20 ring-1 ring-white/30 backdrop-blur transition duration-300 group-hover:scale-110 group-hover:bg-white group-hover:text-brand-900">
                                <Icon :name="item.icon" class="h-7 w-7" />
                            </span>
                            <span v-if="item.live && item.live !== '0'" class="inline-flex items-center gap-1.5 rounded-full bg-black/30 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider backdrop-blur">
                                <span class="relative flex h-2 w-2">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-white opacity-75" />
                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-white" />
                                </span>
                                {{ c('home.ent.live_label') }}
                            </span>
                        </div>
                        <h3 class="relative mt-6 text-2xl font-extrabold tracking-tight">{{ item.title }}</h3>
                        <p class="relative mt-2 flex-1 text-sm leading-relaxed text-white/80">{{ item.desc }}</p>
                        <span class="relative mt-5 inline-flex w-fit items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-sm font-semibold ring-1 ring-white/25 backdrop-blur transition duration-300 group-hover:bg-white group-hover:text-brand-900">
                            {{ item.cta }}
                            <span class="transition group-hover:translate-x-1">→</span>
                        </span>
                    </a>
                </div>
                <p class="mt-10 text-center text-xs text-slate-400">{{ c('home.ent.disclaimer') }}</p>
            </div>
        </section>


        <!-- FAQ + coverage -->
        <section v-if="faqs.length" class="bg-white py-20 sm:py-24">
            <div class="container-x grid items-start gap-12 lg:grid-cols-2">
                <div>
                    <h2 class="section-title">{{ c('home.faq.title') }}</h2>
                    <div class="mt-10 divide-y divide-slate-200 overflow-hidden rounded-xl border border-slate-200 bg-white">
                        <div v-for="faq in faqs" :key="faq.id">
                            <button class="flex min-h-[60px] w-full items-center gap-4 px-6 py-4 text-left font-medium text-slate-900 hover:bg-slate-50" :aria-expanded="openFaq === faq.id" @click="toggleFaq(faq.id)">
                                <span class="w-4 shrink-0 text-xl leading-none text-slate-900">{{ openFaq === faq.id ? '−' : '+' }}</span>
                                {{ faq.question }}
                            </button>
                            <div v-if="openFaq === faq.id" class="rich px-6 pb-5 pl-14 text-sm leading-7 text-slate-500" v-html="richHtml(faq.answer)" />
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <img :src="c('home.coverage.image')" :alt="c('home.coverage.title')" loading="lazy" class="h-64 w-full object-cover" />
                    <div class="p-8">
                        <h3 class="font-display text-2xl text-brand-900">{{ c('home.coverage.title') }}</h3>
                        <p class="mt-3 text-slate-500">{{ c('home.coverage.text') }}</p>
                        <Link :href="c('home.coverage.button_link')" class="btn-primary mt-6">
                            <Icon name="map-pin" class="h-4 w-4" />
                            {{ c('home.coverage.button') }}
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section v-if="testimonials.length" class="relative overflow-hidden bg-white py-24">

            <div class="container-x relative">
                <div v-reveal class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('home.testimonials.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('home.testimonials.title') }}</h2>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                    <div
                        v-for="(t, ti) in testimonials"
                        :key="t.id"
                        v-reveal="ti * 110"
                        class="card group relative flex flex-col overflow-hidden border-slate-200 bg-white p-7 hover:-translate-y-2 hover:border-accent-300 hover:shadow-2xl hover:shadow-accent-500/15"
                    >
                        <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r" :class="tone(ti + 2).top" />
                        <span class="pointer-events-none absolute right-5 top-2 select-none font-display text-7xl font-black leading-none text-accent-200/70 transition duration-300 group-hover:-translate-y-1 group-hover:scale-125 group-hover:text-accent-300">“</span>
                        <div class="relative flex gap-0.5 text-amber-400">
                            <Icon v-for="n in t.rating" :key="n" name="star" class="h-5 w-5 fill-current" />
                        </div>
                        <p class="relative mt-4 flex-1 text-sm leading-relaxed text-slate-600">"{{ t.message }}"</p>
                        <div class="relative mt-5 flex items-center gap-3 border-t border-slate-100 pt-4">
                            <img :src="avatar(t, ti)" :alt="t.name" loading="lazy" class="h-12 w-12 shrink-0 rounded-full object-cover ring-2 ring-white transition duration-300 group-hover:ring-accent-400" />
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-brand-900">{{ t.name }}</p>
                                <p class="text-xs text-slate-500">{{ t.designation }}<span v-if="t.company"> · {{ t.company }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Clients / partners -->
        <section v-if="logos.length" class="border-y border-slate-200 bg-slate-50 py-14">
            <div v-reveal class="container-x">
                <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-400">{{ c('home.clients.title') }}</p>
            </div>
            <div class="marquee mt-8 overflow-hidden [mask-image:linear-gradient(90deg,transparent,black_12%,black_88%,transparent)]">
                <div class="marquee-track flex w-max items-center">
                    <div v-for="n in 2" :key="n" class="flex shrink-0 items-center" :aria-hidden="n === 2">
                        <component
                            :is="p.website_url ? 'a' : 'div'"
                            v-for="(p, i) in logos"
                            :key="`${n}-${i}`"
                            :href="p.website_url || undefined"
                            :target="p.website_url ? '_blank' : undefined"
                            rel="noopener noreferrer"
                            class="mx-4 flex h-20 w-44 shrink-0 items-center justify-center rounded-2xl border border-slate-100 bg-white px-6 grayscale transition duration-300 hover:border-violet-200 hover:shadow-lg hover:grayscale-0"
                        >
                            <img v-if="p.logo" :src="logoSrc(p.logo)" :alt="p.name" class="max-h-12 w-auto max-w-full object-contain" />
                            <span v-else class="font-display text-lg font-bold text-slate-400">{{ p.name }}</span>
                        </component>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog -->
        <section v-if="posts.length" class="relative overflow-hidden bg-slate-50 py-24">
            <!-- glow blobs -->

            <div class="container-x relative">
                <div v-reveal class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('home.blog.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('home.blog.title') }}</h2>
                    <p class="section-subtitle">{{ c('home.blog.subtitle') }}</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="(post, pi) in posts"
                        :key="post.id"
                        v-reveal="pi * 120"
                        :href="route('blog.show', post.slug)"
                        class="card group relative overflow-hidden border-white bg-white transition duration-300 hover:-translate-y-1.5 hover:border-accent-300 hover:shadow-2xl hover:shadow-accent-500/15"
                    >
                        <div class="relative h-44 overflow-hidden bg-brand-900">
                            <img :src="cover(post)" :alt="post.title" loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-110" />
                            <span class="absolute inset-0 bg-gradient-to-t from-brand-900/60 to-transparent opacity-0 transition group-hover:opacity-100" />
                        </div>
                        <div class="p-6">
                            <p v-if="post.published_at" class="inline-flex items-center gap-1.5 rounded-full bg-accent-100/60 px-2.5 py-1 text-xs font-medium text-accent-700">
                                <Icon name="calendar" class="h-3.5 w-3.5" />
                                {{ formatDate(post.published_at) }}
                            </p>
                            <h3 class="mt-3 line-clamp-2 text-lg font-bold text-brand-900 transition group-hover:text-accent-600">{{ post.title }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm text-slate-500">{{ post.excerpt }}</p>
                            <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-accent-600">{{ c('home.blog.read_more') }} <span class="transition group-hover:translate-x-1">→</span></span>
                        </div>
                    </Link>
                </div>
                <div class="mt-12 text-center">
                    <Link :href="route('blog.index')" class="btn-secondary">{{ c('home.blog.button') }}</Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
