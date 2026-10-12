<script setup>
import Icon from '@/Components/Icon.vue';
import PackageCard from '@/Components/Public/PackageCard.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
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

const reasons = [
    { icon: 'bolt', title: '99.9% uptime', desc: 'Redundant network infrastructure keeps you online.' },
    { icon: 'shield-check', title: 'DDoS protection', desc: 'Enterprise-grade network security built in.' },
    { icon: 'headset', title: '24/7 support', desc: 'Real people ready to help, any time of day.' },
    { icon: 'map', title: 'Nationwide coverage', desc: 'Fiber reaching all 64 districts of Bangladesh.' },
];

const cover = (post) => (post.image ? `/storage/${post.image}` : `/images/blog-${(post.id % 3) + 1}.svg`);
const formatDate = (d) => new Date(d).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
</script>

<template>
    <Head title="Home" />

    <PublicLayout>
        <!-- Hero slider -->
        <section class="relative overflow-hidden bg-brand-900">
            <div class="grid-bg absolute inset-0 opacity-70 [mask-image:radial-gradient(ellipse_at_top_right,black,transparent_70%)]" />
            <div class="pointer-events-none absolute -right-24 -top-24 h-[28rem] w-[28rem] rounded-full bg-accent-500/30 blur-3xl" />
            <div class="pointer-events-none absolute -bottom-32 left-0 h-[26rem] w-[26rem] rounded-full bg-brand-500/25 blur-3xl" />

            <div class="container-x relative grid min-h-[540px] items-center gap-12 py-20 text-white lg:grid-cols-5 lg:py-28">
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
                                <span class="h-1.5 w-1.5 rounded-full bg-brand-400" />
                                BTRC-approved nationwide ISP
                            </span>
                            <h1 class="mt-6 text-4xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl lg:text-6xl">{{ currentSlide?.title }}</h1>
                            <p class="mt-5 max-w-xl text-lg text-slate-300">{{ currentSlide?.subtitle }}</p>
                            <div class="mt-9 flex flex-wrap gap-3">
                                <Link v-if="currentSlide?.button_link" :href="currentSlide.button_link" class="btn-primary">
                                    {{ currentSlide.button_text }}
                                </Link>
                                <Link :href="route('coverage.index')" class="btn-outline">Check coverage</Link>
                            </div>
                        </div>
                    </Transition>

                    <div v-if="sliders.length > 1" class="mt-12 flex gap-2">
                        <button
                            v-for="(s, i) in sliders"
                            :key="s.id"
                            :aria-label="`Show slide ${i + 1}`"
                            class="h-1.5 rounded-full transition-all"
                            :class="i === active ? 'w-10 bg-brand-400' : 'w-4 bg-white/25 hover:bg-white/40'"
                            @click="active = i"
                        />
                    </div>
                </div>

                <!-- Speed visual -->
                <div class="hidden lg:col-span-2 lg:block">
                    <div class="relative mx-auto max-w-sm">
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-7 shadow-2xl backdrop-blur">
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wider text-slate-400">
                                <span>Live speed</span>
                                <span class="flex items-center gap-1.5 text-brand-300"><span class="h-2 w-2 animate-pulse rounded-full bg-brand-400" /> Online</span>
                            </div>
                            <p class="mt-6 font-display text-7xl font-extrabold tracking-tight">
                                35<span class="ml-1 text-2xl font-semibold text-slate-400">Mbps</span>
                            </p>
                            <div class="mt-6 space-y-3">
                                <div>
                                    <div class="mb-1 flex justify-between text-xs text-slate-400"><span>Download</span><span>35 Mbps</span></div>
                                    <div class="h-2 rounded-full bg-white/10"><div class="h-2 w-[92%] rounded-full bg-gradient-to-r from-brand-400 to-accent-400" /></div>
                                </div>
                                <div>
                                    <div class="mb-1 flex justify-between text-xs text-slate-400"><span>Upload</span><span>35 Mbps</span></div>
                                    <div class="h-2 rounded-full bg-white/10"><div class="h-2 w-[88%] rounded-full bg-gradient-to-r from-brand-400 to-accent-400" /></div>
                                </div>
                                <div>
                                    <div class="mb-1 flex justify-between text-xs text-slate-400"><span>Latency</span><span>4 ms</span></div>
                                    <div class="h-2 rounded-full bg-white/10"><div class="h-2 w-[12%] rounded-full bg-gradient-to-r from-brand-400 to-accent-400" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -bottom-5 -left-6 flex items-center gap-3 rounded-2xl bg-white px-4 py-3 text-brand-900 shadow-xl">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-100 text-brand-700"><Icon name="check" class="h-5 w-5" /></span>
                            <span class="text-sm font-semibold leading-tight">Free installation<br /><span class="text-xs font-normal text-slate-500">on all home plans</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <section class="relative z-10 -mt-10">
            <div class="container-x">
                <div class="card grid grid-cols-2 gap-6 p-8 shadow-xl shadow-slate-900/5 sm:grid-cols-4">
                    <div v-for="stat in stats" :key="stat.id" class="flex flex-col items-center text-center">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                            <Icon :name="stat.icon" class="h-6 w-6" />
                        </span>
                        <span class="mt-3 font-display text-3xl font-extrabold text-brand-900">{{ stat.value }}{{ stat.suffix }}</span>
                        <span class="text-sm text-slate-500">{{ stat.label }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Home packages -->
        <section class="py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">Home internet</span>
                    <h2 class="section-title mt-4">Simple plans. Unlimited fiber.</h2>
                    <p class="section-subtitle">Pick the speed that fits your household. No data caps, no hidden fees.</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <PackageCard v-for="pkg in homePackages" :key="pkg.id" :pkg="pkg" />
                </div>
                <div class="mt-12 text-center">
                    <Link :href="route('packages.index')" class="btn-secondary">View all packages</Link>
                </div>
            </div>
        </section>

        <!-- Services -->
        <section class="bg-slate-50 py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">What we do</span>
                    <h2 class="section-title mt-4">Everything connectivity, one provider</h2>
                    <p class="section-subtitle">From the living room to the data center — complete solutions under one roof.</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="service in services"
                        :key="service.id"
                        :href="route('services.show', service.slug)"
                        class="card group p-7 transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-xl"
                    >
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 transition group-hover:bg-brand-600 group-hover:text-white">
                            <Icon :name="service.icon" class="h-7 w-7" />
                        </span>
                        <h3 class="mt-5 text-lg font-bold text-brand-900">{{ service.title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ service.short_description }}</p>
                        <span class="mt-4 inline-block text-sm font-semibold text-accent-600">Learn more →</span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Why choose us -->
        <section class="relative overflow-hidden bg-brand-900 py-24 text-white">
            <div class="grid-bg absolute inset-0 opacity-40 [mask-image:radial-gradient(ellipse_at_left,black,transparent_70%)]" />
            <div class="container-x relative grid grid-cols-1 items-center gap-14 lg:grid-cols-2">
                <div>
                    <span class="eyebrow-dark">Why EasyLink</span>
                    <h2 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">Internet you never have to think about</h2>
                    <p class="mt-4 text-lg text-slate-300">Reliable network, fast support and fair pricing — the way an ISP should be.</p>
                    <div class="mt-10 grid grid-cols-1 gap-7 sm:grid-cols-2">
                        <div v-for="item in reasons" :key="item.title" class="flex items-start gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-brand-300">
                                <Icon :name="item.icon" class="h-6 w-6" />
                            </span>
                            <div>
                                <p class="font-semibold">{{ item.title }}</p>
                                <p class="mt-1 text-sm text-slate-400">{{ item.desc }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/5 backdrop-blur">
                    <img src="/images/router.svg" alt="EasyLink fiber router" loading="lazy" class="h-56 w-full object-cover" />
                    <div class="p-9">
                    <h3 class="text-2xl font-bold">Get a free quote</h3>
                    <p class="mt-3 text-slate-300">Tell us your location and needs — our team will get back to you shortly.</p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <Link :href="route('contact.index')" class="btn-primary">Contact us now</Link>
                        <Link :href="route('coverage.index')" class="btn-outline">Check coverage</Link>
                    </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section v-if="testimonials.length" class="py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">Testimonials</span>
                    <h2 class="section-title mt-4">Loved by customers</h2>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="t in testimonials" :key="t.id" class="card flex flex-col p-7">
                        <div class="flex gap-0.5 text-amber-400">
                            <Icon v-for="n in t.rating" :key="n" name="star" class="h-5 w-5 fill-current" />
                        </div>
                        <p class="mt-4 flex-1 text-sm leading-relaxed text-slate-600">"{{ t.message }}"</p>
                        <div class="mt-5 border-t border-slate-100 pt-4">
                            <p class="text-sm font-semibold text-brand-900">{{ t.name }}</p>
                            <p class="text-xs text-slate-500">{{ t.designation }}<span v-if="t.company"> · {{ t.company }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Clients / partners -->
        <section v-if="clients.length || partners.length" class="border-y border-slate-100 bg-slate-50 py-14">
            <div class="container-x">
                <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-400">Trusted by our clients &amp; technology partners</p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-x-12 gap-y-5">
                    <span v-for="p in [...clients, ...partners]" :key="p.id" class="font-display text-lg font-bold text-slate-400">
                        {{ p.name }}
                    </span>
                </div>
            </div>
        </section>

        <!-- Blog -->
        <section v-if="posts.length" class="py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">Blog</span>
                    <h2 class="section-title mt-4">Latest from the blog</h2>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link v-for="post in posts" :key="post.id" :href="route('blog.show', post.slug)" class="card group overflow-hidden transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative h-44 overflow-hidden bg-brand-900">
                            <img :src="cover(post)" :alt="post.title" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                        </div>
                        <div class="p-6">
                            <p v-if="post.published_at" class="text-xs font-medium text-slate-400">{{ formatDate(post.published_at) }}</p>
                            <h3 class="mt-1 line-clamp-2 text-lg font-bold text-brand-900 group-hover:text-brand-600">{{ post.title }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm text-slate-500">{{ post.excerpt }}</p>
                        </div>
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
