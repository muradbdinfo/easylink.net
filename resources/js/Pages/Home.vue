<script setup>
import Icon from '@/Components/Icon.vue';
import PackageCard from '@/Components/Public/PackageCard.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useContent } from '@/composables/useContent';
import { tone } from '@/composables/useTones';
import { Head, Link } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    sliders: Array,
    homePackages: Array,
    services: Array,
    stats: Array,
    testimonials: Array,
    clients: Array,
    partners: Array,
    posts: Array,
});

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

const { c, list } = useContent();

const reasons = computed(() => list('home.why.items'));
const app = computed(() => ({ title: c('home.app.title'), desc: c('home.app.desc'), href: c('home.app.href'), button: c('home.app.button'), icon: c('home.app.icon') || 'cloud' }));
const entertainment = computed(() => list('home.ent.items'));
const speedRows = computed(() => list('home.speed.rows'));

// repeat short lists so the marquee track is always wider than the viewport
const logos = computed(() => {
    const list = [...props.clients, ...props.partners];
    if (!list.length) return [];
    return Array.from({ length: Math.max(1, Math.ceil(10 / list.length)) }, () => list).flat();
});

// picture position is a layout detail (slide 3 is a portrait photo); the pictures themselves are editable
const heroPositions = ['center', 'center', 'center 30%', 'center', 'center', 'center'];
const slideBg = (slide, i) => {
    const n = i % heroPositions.length;
    return {
        backgroundImage: `url('${slide.image ? `/storage/${slide.image}` : c(`home.hero.image_${n + 1}`)}')`,
        backgroundPosition: slide.image ? 'center' : heroPositions[n],
    };
};

const logoSrc = (logo) => (logo.startsWith('/') || logo.startsWith('http') ? logo : `/storage/${logo}`);

const cover = (post) => (post.image ? `/storage/${post.image}` : `/images/blog-${(post.id % 3) + 1}.svg`);
const formatDate = (d) => new Date(d).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
</script>

<template>
    <Head title="Home" />

    <PublicLayout>
        <!-- Hero slider -->
        <section class="relative overflow-hidden bg-brand-900">
            <!-- slide pictures (crossfade) -->
            <div
                v-for="(s, i) in sliders"
                :key="`bg-${s.id}`"
                class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
                :class="i === active ? 'opacity-100' : 'opacity-0'"
                :style="slideBg(s, i)"
            />
            <!-- readability overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900/95 via-[#1e1b6b]/75 to-violet-900/25" />
            <div class="absolute inset-0 bg-gradient-to-t from-brand-900/50 via-transparent to-brand-900/20" />
            <div class="grid-bg absolute inset-0 opacity-40 [mask-image:radial-gradient(ellipse_at_top_right,black,transparent_70%)]" />
            <div class="pointer-events-none absolute -right-24 -top-24 h-[28rem] w-[28rem] rounded-full bg-accent-500/30 blur-3xl" />
            <div class="pointer-events-none absolute -bottom-32 left-0 h-[26rem] w-[26rem] rounded-full bg-violet-500/30 blur-3xl" />
            <div class="pointer-events-none absolute right-1/3 top-1/3 h-72 w-72 rounded-full bg-rose-500/20 blur-3xl" />

            <div class="container-x relative grid min-h-[540px] items-center gap-12 py-20 [@media(max-height:500px)]:min-h-0 [@media(max-height:500px)]:py-10 text-white lg:grid-cols-5 lg:py-28">
                <div class="lg:col-span-3">
                    <Transition
                        mode="out-in"
                        enter-active-class="transition duration-500 ease-out"
                        enter-from-class="opacity-0 translate-y-4"
                        leave-active-class="transition duration-200"
                        leave-to-class="opacity-0"
                    >
                        <div :key="active">
                            <span class="eyebrow-dark">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-300" />
                                {{ c('home.hero.badge') }}
                            </span>
                            <h1 class="mt-6 text-4xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl lg:text-6xl">{{ currentSlide?.title }}</h1>
                            <p class="mt-5 max-w-xl text-lg text-slate-200">{{ currentSlide?.subtitle }}</p>
                            <div class="mt-9 flex flex-wrap gap-3">
                                <Link v-if="currentSlide?.button_link" :href="currentSlide.button_link" class="btn-primary">
                                    {{ currentSlide.button_text }}
                                </Link>
                                <Link :href="route('coverage.index')" class="btn-outline">{{ c('home.hero.coverage_button') }}</Link>
                            </div>
                        </div>
                    </Transition>

                    <div v-if="sliders.length > 1" class="mt-12 flex gap-2">
                        <button
                            v-for="(s, i) in sliders"
                            :key="s.id"
                            :aria-label="`Show slide ${i + 1}`"
                            class="group flex h-6 items-center px-1.5"
                            @click="active = i"
                        >
                            <span class="h-1.5 rounded-full transition-all" :class="i === active ? 'w-10 bg-gradient-to-r from-sky-300 to-violet-400' : 'w-4 bg-white/25 group-hover:bg-white/40'" />
                        </button>
                    </div>
                </div>

                <!-- Speed visual -->
                <div class="hidden lg:col-span-2 lg:block">
                    <div class="relative mx-auto max-w-sm">
                        <div class="rounded-3xl border border-white/20 bg-gradient-to-br from-white/15 to-violet-300/10 p-7 shadow-2xl shadow-violet-900/30 backdrop-blur-md">
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wider text-slate-400">
                                <span>{{ c('home.speed.title') }}</span>
                                <span class="flex items-center gap-1.5 text-brand-300"><span class="h-2 w-2 animate-pulse rounded-full bg-brand-400" /> {{ c('home.speed.status') }}</span>
                            </div>
                            <p class="text-gradient-light mt-6 font-display text-7xl font-extrabold tracking-tight">
                                {{ c('home.speed.value') }}<span class="ml-1 text-2xl font-semibold text-sky-200/80">{{ c('home.speed.unit') }}</span>
                            </p>
                            <div class="mt-6 space-y-3">
                                <div v-for="row in speedRows" :key="row.label">
                                    <div class="mb-1 flex justify-between text-xs text-slate-400"><span>{{ row.label }}</span><span>{{ row.value }}</span></div>
                                    <div class="h-2 rounded-full bg-white/10"><div class="h-2 rounded-full bg-gradient-to-r from-sky-400 via-violet-400 to-rose-400" :style="{ width: `${Math.min(100, Math.max(0, Number(row.percent) || 0))}%` }" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -bottom-12 -left-8 flex items-center gap-3 rounded-2xl bg-white px-4 py-3 text-brand-900 shadow-xl">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 text-white shadow-md"><Icon name="check" class="h-5 w-5" /></span>
                            <span class="text-sm font-semibold leading-tight">{{ c('home.speed.badge_title') }}<br /><span class="text-xs font-normal text-slate-500">{{ c('home.speed.badge_text') }}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <section class="relative z-10 -mt-10">
            <div class="container-x">
                <div class="card relative grid grid-cols-2 gap-6 overflow-hidden border-white bg-white/90 p-8 shadow-2xl shadow-violet-900/10 backdrop-blur sm:grid-cols-4">
                    <span class="rainbow-bar absolute inset-x-0 top-0" />
                    <div v-for="(stat, i) in stats" :key="stat.id" class="group flex flex-col items-center rounded-2xl bg-gradient-to-b px-2 py-4 text-center" :class="tone(i).wash">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl shadow-lg transition duration-300 group-hover:-translate-y-1 group-hover:rotate-6" :class="tone(i).tile">
                            <Icon :name="stat.icon" class="h-6 w-6" />
                        </span>
                        <span class="text-gradient mt-3 font-display text-3xl font-extrabold">{{ stat.value }}{{ stat.suffix }}</span>
                        <span class="text-sm text-slate-500">{{ stat.label }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Home packages -->
        <section class="relative overflow-hidden bg-gradient-to-b from-white via-sky-50 to-fuchsia-50/60 py-24">
            <!-- router picture, fading into white behind the cards -->
            <div class="absolute inset-0 bg-cover bg-right opacity-40" :style="{ backgroundImage: `url('${c('home.plans.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-r from-white/90 via-white/70 to-white/30" />
            <div class="absolute inset-0 bg-gradient-to-b from-white via-transparent to-white" />
            <div class="pointer-events-none absolute -right-24 top-10 h-96 w-96 rounded-full bg-accent-300/30 blur-3xl" />
            <div class="pointer-events-none absolute -left-24 bottom-10 h-96 w-96 rounded-full bg-violet-300/25 blur-3xl" />

            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('home.plans.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('home.plans.title') }}</h2>
                    <p class="section-subtitle">{{ c('home.plans.subtitle') }}</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <PackageCard v-for="pkg in homePackages" :key="pkg.id" :pkg="pkg" />
                </div>
                <div class="mt-12 text-center">
                    <Link :href="route('packages.index')" class="btn-secondary">{{ c('home.plans.button') }}</Link>
                </div>
            </div>
        </section>

        <!-- Services -->
        <section class="relative overflow-hidden bg-gradient-to-br from-violet-50 via-white to-rose-50 py-24">
            <!-- dotted texture, fading from the corners -->
            <div class="pointer-events-none absolute inset-0 opacity-60 [background-image:radial-gradient(rgb(139_92_246/0.22)_1.2px,transparent_1.2px)] [background-size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,transparent_30%,black)]" />
            <!-- glow blobs -->
            <div class="pointer-events-none absolute -left-24 top-0 h-96 w-96 rounded-full bg-violet-200/50 blur-3xl" />
            <div class="pointer-events-none absolute -right-24 bottom-0 h-96 w-96 rounded-full bg-rose-200/50 blur-3xl" />
            <!-- decorative rings -->
            <div class="pointer-events-none absolute -right-40 -top-40 h-[28rem] w-[28rem] rounded-full border border-violet-200/70" />
            <div class="pointer-events-none absolute -right-24 -top-24 h-[22rem] w-[22rem] rounded-full border border-violet-200/50" />
            <div class="pointer-events-none absolute -bottom-40 -left-40 h-[28rem] w-[28rem] rounded-full border border-rose-200/60" />

            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="inline-flex items-center gap-2 rounded-full border border-violet-200 bg-violet-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-violet-700">{{ c('home.services.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('home.services.title') }}</h2>
                    <p class="section-subtitle">{{ c('home.services.subtitle') }}</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="(service, i) in services"
                        :key="service.id"
                        :href="route('services.show', service.slug)"
                        class="card group relative overflow-hidden border-white bg-white/70 p-7 backdrop-blur-md transition duration-300 hover:-translate-y-1.5 hover:bg-white hover:shadow-2xl"
                        :class="tone(i).hover"
                    >
                        <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r" :class="tone(i).top" />
                        <span class="pointer-events-none absolute -right-8 -top-8 h-28 w-28 rounded-full opacity-70 transition duration-500 group-hover:scale-150" :class="tone(i).glow" />
                        <span class="relative flex h-14 w-14 items-center justify-center rounded-2xl shadow-lg transition duration-300 group-hover:rotate-6 group-hover:scale-110" :class="tone(i).tile">
                            <Icon :name="service.icon" class="h-7 w-7" />
                        </span>
                        <h3 class="relative mt-5 text-lg font-bold text-brand-900">{{ service.title }}</h3>
                        <p class="relative mt-2 text-sm leading-relaxed text-slate-500">{{ service.short_description }}</p>
                        <span class="relative mt-4 inline-block text-sm font-semibold" :class="tone(i).text">{{ c('home.services.link_label') }} <span class="inline-block transition group-hover:translate-x-1">→</span></span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Why choose us -->
        <section class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-[#1e1b6b] to-violet-900 py-24 text-white">
            <div class="pointer-events-none absolute -right-24 top-0 h-96 w-96 rounded-full bg-rose-500/20 blur-3xl" />
            <div class="pointer-events-none absolute -left-24 bottom-0 h-96 w-96 rounded-full bg-accent-500/25 blur-3xl" />
            <div class="grid-bg absolute inset-0 opacity-40 [mask-image:radial-gradient(ellipse_at_left,black,transparent_70%)]" />
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
                    <img :src="c('home.quote.image')" :alt="c('home.quote.image_alt')" loading="lazy" class="h-56 w-full object-cover" />
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

        <!-- Entertainment -->
        <section id="entertainment" class="relative scroll-mt-28 overflow-hidden bg-gradient-to-b from-sky-50 via-fuchsia-50/40 to-white py-24">
            <div class="pointer-events-none absolute -left-32 top-10 h-80 w-80 rounded-full bg-accent-300/30 blur-3xl" />
            <div class="pointer-events-none absolute -right-32 bottom-10 h-80 w-80 rounded-full bg-fuchsia-300/30 blur-3xl" />

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

        <!-- Testimonials -->
        <section v-if="testimonials.length" class="relative overflow-hidden bg-gradient-to-br from-violet-50 via-white to-rose-50 py-24">
            <div class="pointer-events-none absolute inset-0 opacity-60 [background-image:radial-gradient(rgb(139_92_246/0.22)_1.2px,transparent_1.2px)] [background-size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,transparent_30%,black)]" />
            <div class="pointer-events-none absolute -left-24 top-0 h-96 w-96 rounded-full bg-violet-200/50 blur-3xl" />
            <div class="pointer-events-none absolute -right-24 bottom-0 h-96 w-96 rounded-full bg-rose-200/50 blur-3xl" />
            <div class="pointer-events-none absolute -right-40 -top-40 h-[28rem] w-[28rem] rounded-full border border-violet-200/70" />
            <div class="pointer-events-none absolute -bottom-40 -left-40 h-[28rem] w-[28rem] rounded-full border border-rose-200/60" />

            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="inline-flex items-center gap-2 rounded-full border border-violet-200 bg-violet-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-violet-700">{{ c('home.testimonials.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('home.testimonials.title') }}</h2>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                    <div
                        v-for="(t, ti) in testimonials"
                        :key="t.id"
                        class="card group relative flex flex-col overflow-hidden border-white bg-white/70 p-7 backdrop-blur-md transition duration-300 hover:-translate-y-1.5 hover:bg-white hover:shadow-2xl"
                        :class="tone(ti + 2).hover"
                    >
                        <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r" :class="tone(ti + 2).top" />
                        <span class="pointer-events-none absolute right-5 top-2 select-none font-display text-7xl font-black leading-none text-violet-200/70">“</span>
                        <div class="relative flex gap-0.5 text-amber-400">
                            <Icon v-for="n in t.rating" :key="n" name="star" class="h-5 w-5 fill-current" />
                        </div>
                        <p class="relative mt-4 flex-1 text-sm leading-relaxed text-slate-600">"{{ t.message }}"</p>
                        <div class="relative mt-5 flex items-center gap-3 border-t border-violet-100 pt-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br text-sm font-bold text-white shadow-md" :class="tone(ti + 2).avatar">{{ t.name?.charAt(0) }}</span>
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
        <section v-if="logos.length" class="border-y border-violet-100 bg-gradient-to-r from-sky-50/60 via-white to-violet-50/60 py-14">
            <div class="container-x">
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
        <section v-if="posts.length" class="relative overflow-hidden bg-gradient-to-b from-sky-50 via-teal-50/60 to-amber-50/50 py-24">
            <!-- notebook ruling -->
            <div class="pointer-events-none absolute inset-0 opacity-70 [background-image:linear-gradient(rgb(14_116_144/0.08)_1px,transparent_1px)] [background-size:100%_34px] [mask-image:linear-gradient(180deg,transparent,black_20%,black_80%,transparent)]" />
            <!-- glow blobs -->
            <div class="pointer-events-none absolute -left-24 top-20 h-80 w-80 rounded-full bg-teal-200/50 blur-3xl" />
            <div class="pointer-events-none absolute -right-24 bottom-10 h-80 w-80 rounded-full bg-amber-200/50 blur-3xl" />
            <!-- watermark -->
            <Icon name="newspaper" class="pointer-events-none absolute -right-6 top-10 h-64 w-64 rotate-12 text-teal-600/[0.07]" />
            <Icon name="sparkles" class="pointer-events-none absolute -left-4 bottom-8 h-40 w-40 -rotate-12 text-amber-500/10" />

            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="inline-flex items-center gap-2 rounded-full border border-teal-200 bg-teal-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-teal-700">{{ c('home.blog.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('home.blog.title') }}</h2>
                    <p class="section-subtitle">{{ c('home.blog.subtitle') }}</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="post in posts"
                        :key="post.id"
                        :href="route('blog.show', post.slug)"
                        class="card group relative overflow-hidden border-white bg-white transition duration-300 hover:-translate-y-1.5 hover:border-teal-300 hover:shadow-2xl hover:shadow-teal-500/10"
                    >
                        <div class="relative h-44 overflow-hidden bg-brand-900">
                            <img :src="cover(post)" :alt="post.title" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                            <span class="absolute inset-0 bg-gradient-to-t from-teal-900/40 to-transparent opacity-0 transition group-hover:opacity-100" />
                        </div>
                        <div class="p-6">
                            <p v-if="post.published_at" class="inline-flex items-center gap-1.5 rounded-full bg-teal-50 px-2.5 py-1 text-xs font-medium text-teal-700">
                                <Icon name="calendar" class="h-3.5 w-3.5" />
                                {{ formatDate(post.published_at) }}
                            </p>
                            <h3 class="mt-3 line-clamp-2 text-lg font-bold text-brand-900 transition group-hover:text-teal-700">{{ post.title }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm text-slate-500">{{ post.excerpt }}</p>
                            <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-teal-600">{{ c('home.blog.read_more') }} <span class="transition group-hover:translate-x-1">→</span></span>
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
