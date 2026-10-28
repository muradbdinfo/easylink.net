<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useContent } from '@/composables/useContent';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    districts: Array,
    areas: Array,
});

const { c, list } = useContent();
const page = usePage();
const result = computed(() => page.props.flash?.coverageResult);

const form = useForm({
    district: '',
    upazilla: '',
});

const upazillasFor = (district) => props.areas.filter((a) => a.district === district).map((a) => a.upazilla);
const countFor = (district) => upazillasFor(district).length;

// {upazilla} and {district} in the admin-edited messages are replaced with the chosen area.
const fill = (text) => (text ?? '').replace('{upazilla}', result.value?.upazilla ?? '').replace('{district}', result.value?.district ?? '');

const isExternal = (url) => /^(https?:)?\/\//.test(url) || url?.startsWith('mailto:') || url?.startsWith('tel:');

const submit = () => {
    form.post(route('coverage.check'), { preserveScroll: true });
};
</script>

<template>
    <Head :title="c('coverage.hero.title', 'Check coverage')" />

    <PublicLayout>
        <PageHero page-key="coverage" />

        <!-- Search card over a picture -->
        <section class="relative overflow-hidden py-16 lg:py-20">
            <div v-if="c('coverage.search.image')" class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('coverage.search.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-b from-brand-900/85 via-brand-900/70 to-brand-900/90" />
            <div class="grid-bg absolute inset-0 opacity-30 [mask-image:radial-gradient(ellipse_at_center,black,transparent_75%)]" />

            <div class="container-x relative max-w-2xl">
                <form class="card space-y-5 border-white/40 bg-white/95 p-6 shadow-2xl shadow-black/30 backdrop-blur sm:p-8" @submit.prevent="submit">
                    <div class="flex items-start gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-accent-500 text-white shadow-lg">
                            <Icon name="map-pin" class="h-6 w-6" />
                        </span>
                        <div>
                            <h2 class="text-xl font-extrabold tracking-tight text-brand-900">{{ c('coverage.search.title') }}</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ c('coverage.search.text') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ c('coverage.search.district_label') }}</label>
                            <select v-model="form.district" class="field" required @change="form.upazilla = ''">
                                <option value="" disabled>{{ c('coverage.search.district_placeholder') }}</option>
                                <option v-for="d in districts" :key="d" :value="d">{{ d }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ c('coverage.search.upazila_label') }}</label>
                            <select v-model="form.upazilla" class="field" required :disabled="!form.district">
                                <option value="" disabled>{{ c('coverage.search.upazila_placeholder') }}</option>
                                <option v-for="u in upazillasFor(form.district)" :key="u" :value="u">{{ u }}</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary w-full !py-3.5" :disabled="form.processing">
                        <Icon name="magnifying-glass" class="h-5 w-5" />
                        {{ c('coverage.search.button') }}
                    </button>
                </form>

                <!-- Result -->
                <div
                    v-if="result"
                    class="mt-6 rounded-3xl border p-6 shadow-xl backdrop-blur"
                    :class="result.available ? 'border-emerald-200 bg-emerald-50/95 text-emerald-900' : 'border-rose-200 bg-rose-50/95 text-rose-900'"
                >
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-white" :class="result.available ? 'bg-emerald-500' : 'bg-rose-500'">
                            <Icon :name="result.available ? 'check' : 'signal'" class="h-5 w-5" />
                        </span>
                        <div>
                            <p class="font-bold">{{ fill(result.available ? c('coverage.result.available') : c('coverage.result.unavailable')) }}</p>
                            <p v-if="!result.available && c('coverage.result.unavailable_note')" class="mt-1 text-sm opacity-80">{{ c('coverage.result.unavailable_note') }}</p>
                        </div>
                    </div>
                    <Link v-if="result.available" :href="route('packages.index')" class="btn-primary mt-5">{{ c('coverage.result.packages_button') }}</Link>
                    <Link v-else :href="route('contact.index')" class="btn-secondary mt-5">{{ c('coverage.result.contact_button') }}</Link>
                </div>
            </div>
        </section>

        <!-- Benefits -->
        <section v-if="list('coverage.features').length" class="border-b border-slate-100 bg-white py-14">
            <div class="container-x grid grid-cols-1 gap-6 md:grid-cols-3">
                <div v-for="(f, i) in list('coverage.features')" :key="i" class="flex items-start gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-400 to-violet-600 text-white shadow-md shadow-violet-500/25">
                        <Icon :name="f.icon" class="h-6 w-6" />
                    </span>
                    <div>
                        <p class="font-bold text-brand-900">{{ f.title }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ f.text }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Areas we cover -->
        <section v-if="districts.length" class="relative overflow-hidden bg-gradient-to-b from-slate-50 to-white py-20">
            <div class="pointer-events-none absolute -right-24 top-10 h-80 w-80 rounded-full bg-accent-300/20 blur-3xl" />
            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="section-title">{{ c('coverage.areas.title') }}</h2>
                    <p class="section-subtitle">{{ c('coverage.areas.text') }}</p>
                </div>
                <div class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="d in districts" :key="d" class="card group flex items-center gap-4 p-5 transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-accent-500 text-white shadow-md">
                            <Icon name="map-pin" class="h-5 w-5" />
                        </span>
                        <div class="min-w-0">
                            <p class="truncate font-bold text-brand-900">{{ d }}</p>
                            <p class="text-xs text-slate-500">{{ countFor(d) }} {{ countFor(d) === 1 ? c('coverage.areas.count_one') : c('coverage.areas.count_many') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="relative overflow-hidden bg-gradient-to-r from-brand-900 to-brand-700 py-16 text-white">
            <div class="grid-bg absolute inset-0 opacity-30 [mask-image:radial-gradient(ellipse_at_right,black,transparent_70%)]" />
            <Icon name="signal" class="pointer-events-none absolute -bottom-10 right-6 hidden h-56 w-56 -rotate-12 text-white/10 md:block" />
            <div class="container-x relative flex flex-col items-center gap-6 text-center md:flex-row md:justify-between md:text-left">
                <div class="max-w-2xl">
                    <h2 class="text-2xl font-extrabold tracking-tight sm:text-3xl">{{ c('coverage.cta.title') }}</h2>
                    <p class="mt-2 text-slate-200">{{ c('coverage.cta.text') }}</p>
                </div>
                <component :is="isExternal(c('coverage.cta.button_url')) ? 'a' : Link" v-if="c('coverage.cta.button')" :href="c('coverage.cta.button_url')" class="btn-primary shrink-0">
                    {{ c('coverage.cta.button') }}
                </component>
            </div>
        </section>
    </PublicLayout>
</template>
