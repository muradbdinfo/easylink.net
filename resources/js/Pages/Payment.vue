<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useContent } from '@/composables/useContent';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const { c, list } = useContent();
const settings = computed(() => usePage().props.settings ?? {});

const lines = (text) => (text ?? '').split('\n').map((l) => l.trim()).filter(Boolean);
const noNumber = computed(() => c('payment.no_number').replace('{phone}', settings.value.hotline ?? ''));

// bKash tabs
const tab = ref('send');
const tabs = computed(() => [
    {
        key: 'send',
        name: c('payment.bkash.send_tab'),
        icon: 'paper-airplane',
        numberLabel: c('payment.bkash.send_number_label'),
        number: c('payment.bkash.send_number'),
        extraLabel: '',
        extra: '',
        steps: lines(c('payment.bkash.send_steps')),
    },
    {
        key: 'merchant',
        name: c('payment.bkash.merchant_tab'),
        icon: 'building-storefront',
        numberLabel: c('payment.bkash.merchant_number_label'),
        number: c('payment.bkash.merchant_number'),
        extraLabel: c('payment.bkash.merchant_counter_label'),
        extra: c('payment.bkash.merchant_counter'),
        steps: lines(c('payment.bkash.merchant_steps')),
    },
]);
const current = computed(() => tabs.value.find((t) => t.key === tab.value) ?? tabs.value[0]);

// copy to clipboard with a short "Copied" confirmation
const copied = ref('');
const copy = async (text, key) => {
    try {
        await navigator.clipboard.writeText(text);
    } catch {
        const area = document.createElement('textarea');
        area.value = text;
        document.body.appendChild(area);
        area.select();
        document.execCommand('copy');
        area.remove();
    }
    copied.value = key;
    setTimeout(() => {
        if (copied.value === key) copied.value = '';
    }, 1800);
};

const qrs = computed(() =>
    [
        { image: c('payment.qr.send_image'), label: c('payment.qr.send_label'), caption: c('payment.qr.send_caption') },
        { image: c('payment.qr.merchant_image'), label: c('payment.qr.merchant_label'), caption: c('payment.qr.merchant_caption') },
    ].filter((q) => q.image),
);
const methods = computed(() => list('payment.methods'));
const steps = computed(() => list('payment.steps'));

// fade-up when a block scrolls into view
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
</script>

<template>
    <Head :title="c('payment.hero.title', 'Payment')" />

    <PublicLayout>
        <PageHero page-key="payment" />

        <!-- intro + bKash -->
        <section class="bg-slate-50 py-20 sm:py-24">
            <div class="container-x">
                <div v-reveal class="mx-auto max-w-2xl text-center">
                    <h2 class="font-display text-4xl font-normal leading-tight text-slate-900 sm:text-5xl">{{ c('payment.heading') }}</h2>
                    <p class="section-subtitle">{{ c('payment.intro') }}</p>
                </div>

                <div v-reveal class="mx-auto mt-14 max-w-6xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/10">
                    <!-- header -->
                    <div class="flex flex-col gap-5 bg-gradient-to-r from-[#e2136e] to-[#b80a56] px-6 py-6 text-white sm:flex-row sm:items-center sm:justify-between sm:px-10">
                        <div>
                            <p class="font-display text-3xl font-semibold tracking-tight">bKash</p>
                            <p class="mt-1 text-sm text-pink-100">{{ c('payment.bkash.text') }}</p>
                        </div>
                        <div class="inline-flex rounded-full bg-white/15 p-1 backdrop-blur" role="tablist">
                            <button
                                v-for="t in tabs"
                                :key="t.key"
                                role="tab"
                                :aria-selected="tab === t.key"
                                class="flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium transition"
                                :class="tab === t.key ? 'bg-white text-[#b80a56] shadow' : 'text-white/90 hover:bg-white/15'"
                                @click="tab = t.key"
                            >
                                <Icon :name="t.icon" class="h-4 w-4" />
                                {{ t.name }}
                            </button>
                        </div>
                    </div>

                    <!-- body -->
                    <div class="grid gap-10 p-6 sm:p-10 lg:grid-cols-5">
                        <div class="lg:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">{{ current.numberLabel }}</p>
                            <div class="mt-3 flex items-center gap-3 rounded-2xl border border-pink-100 bg-pink-50/60 p-4">
                                <p class="min-w-0 flex-1 font-sans text-2xl font-semibold tabular-nums tracking-wide text-slate-900 sm:text-3xl" :class="current.number ? '' : '!text-base !font-medium !tracking-normal text-slate-600'">
                                    {{ current.number || noNumber }}
                                </p>
                                <button
                                    v-if="current.number"
                                    class="flex shrink-0 items-center gap-1.5 rounded-full bg-white px-3.5 py-2 text-xs font-semibold text-[#b80a56] shadow-sm ring-1 ring-pink-200 transition hover:bg-[#e2136e] hover:text-white"
                                    @click="copy(current.number, current.key)"
                                >
                                    <Icon :name="copied === current.key ? 'check' : 'document-text'" class="h-4 w-4" />
                                    {{ copied === current.key ? c('payment.copied') : c('payment.copy') }}
                                </button>
                            </div>

                            <template v-if="current.extra">
                                <p class="mt-5 text-xs font-semibold uppercase tracking-widest text-slate-500">{{ current.extraLabel }}</p>
                                <p class="mt-2 font-sans text-xl font-semibold tabular-nums text-slate-900">{{ current.extra }}</p>
                            </template>

                            <!-- reference reminder -->
                            <div class="mt-8 flex gap-4 rounded-2xl bg-brand-900 p-5 text-white">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white/10"><Icon name="tag" class="h-6 w-6 text-accent-300" /></span>
                                <div>
                                    <p class="font-medium">{{ c('payment.reference_title') }}</p>
                                    <p class="mt-1 text-sm leading-6 text-slate-300">{{ c('payment.reference_text') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- steps timeline -->
                        <div class="lg:col-span-3">
                            <ol class="relative space-y-5 before:absolute before:bottom-3 before:left-[19px] before:top-3 before:w-px before:bg-pink-200">
                                <li v-for="(step, i) in current.steps" :key="`${tab}-${i}`" class="relative flex items-start gap-5">
                                    <span class="z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white font-sans text-sm font-semibold text-[#b80a56] ring-2 ring-[#e2136e]">{{ i + 1 }}</span>
                                    <p class="pt-2 text-[15px] leading-6 text-slate-700">{{ step }}</p>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bangla QR -->
        <section v-if="qrs.length" class="bg-white py-20 sm:py-24">
            <div class="container-x">
                <div v-reveal class="mx-auto max-w-2xl text-center">
                    <h2 class="font-display text-3xl text-slate-900 sm:text-4xl">{{ c('payment.qr.title') }}</h2>
                    <p class="section-subtitle">{{ c('payment.qr.text') }}</p>
                </div>
                <div class="mx-auto mt-12 grid max-w-3xl gap-8 sm:grid-cols-2">
                    <figure v-for="(q, i) in qrs" :key="i" v-reveal="i * 120" class="flex flex-col items-center rounded-3xl border border-pink-100 bg-pink-50/40 p-6 text-center shadow-xl shadow-pink-900/5">
                        <a :href="q.image" target="_blank" rel="noopener" class="block overflow-hidden rounded-2xl bg-white ring-1 ring-pink-100">
                            <img :src="q.image" :alt="q.label" loading="lazy" class="mx-auto max-h-[28rem] w-auto object-contain" />
                        </a>
                        <figcaption class="mt-5">
                            <p class="font-display text-xl text-slate-900">{{ q.label }}</p>
                            <p v-if="q.caption" class="mt-1 text-sm leading-6 text-slate-500">{{ q.caption }}</p>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- other methods -->
        <section v-if="methods.length" class="bg-slate-50 py-20 sm:py-24">
            <div class="container-x">
                <h2 v-reveal class="text-center font-display text-3xl text-slate-900 sm:text-4xl">{{ c('payment.methods_title') }}</h2>
                <div class="mx-auto mt-12 grid max-w-6xl gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="(m, i) in methods"
                        :key="i"
                        v-reveal="i * 110"
                        class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-7 transition duration-300 hover:-translate-y-1.5 hover:border-accent-300 hover:shadow-2xl hover:shadow-accent-500/15"
                    >
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-accent-100/60 text-accent-600 transition duration-300 group-hover:bg-accent-500 group-hover:text-white"><Icon :name="m.icon || 'banknotes'" class="h-7 w-7" /></span>
                        <h3 class="mt-5 font-display text-xl text-slate-900">{{ m.name }}</h3>
                        <p class="mt-2 text-sm leading-7 text-slate-500">{{ m.text }}</p>

                        <div class="mt-5 flex items-center gap-3 rounded-xl bg-slate-50 p-3.5">
                            <p class="min-w-0 flex-1 font-sans text-lg font-semibold tabular-nums text-slate-900" :class="m.number ? '' : '!text-sm !font-medium text-slate-500'">{{ m.number || noNumber }}</p>
                            <button
                                v-if="m.number"
                                class="flex shrink-0 items-center gap-1.5 rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-accent-600 ring-1 ring-slate-200 transition hover:bg-accent-500 hover:text-white"
                                @click="copy(m.number, `m${i}`)"
                            >
                                <Icon :name="copied === `m${i}` ? 'check' : 'document-text'" class="h-3.5 w-3.5" />
                                {{ copied === `m${i}` ? c('payment.copied') : c('payment.copy') }}
                            </button>
                        </div>

                        <ol v-if="lines(m.steps).length" class="mt-5 list-decimal space-y-2 pl-5 text-sm leading-6 text-slate-700">
                            <li v-for="(line, n) in lines(m.steps)" :key="n">{{ line }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- how it works -->
        <section v-if="steps.length" class="bg-white py-20 sm:py-24">
            <div class="container-x">
                <h2 v-reveal class="text-center font-display text-3xl text-slate-900 sm:text-4xl">{{ c('payment.steps_title') }}</h2>
                <div class="mx-auto mt-12 grid max-w-5xl gap-8 md:grid-cols-3">
                    <div v-for="(s, i) in steps" :key="i" v-reveal="i * 120" class="text-center">
                        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-accent-500 font-sans text-2xl font-semibold text-white shadow-lg shadow-accent-500/30">{{ i + 1 }}</span>
                        <h3 class="mt-5 font-display text-lg text-slate-900">{{ s.title }}</h3>
                        <p class="mt-2 text-sm leading-7 text-slate-500">{{ s.text }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-brand-900 py-16 text-center text-white">
            <div v-reveal class="container-x">
                <h2 class="font-display text-3xl sm:text-4xl">{{ c('payment.help_title') }}</h2>
                <p class="mx-auto mt-4 max-w-xl text-slate-300">{{ c('payment.help_text') }}</p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <Link :href="c('payment.help_link')" class="btn-primary">{{ c('payment.help_button') }}</Link>
                    <a v-if="settings.hotline" :href="`tel:${settings.hotline}`" class="btn-outline !py-3.5">
                        <Icon name="phone" class="h-4 w-4" />
                        {{ settings.hotline }}
                    </a>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
