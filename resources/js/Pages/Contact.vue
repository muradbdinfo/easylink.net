<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useContent } from '@/composables/useContent';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const props = defineProps({
    packages: Array,
});

const { c, list } = useContent();
const page = usePage();
const settings = computed(() => page.props.settings ?? {});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
    type: 'general',
    package_id: '',
});

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    if (params.get('package_id')) {
        form.package_id = params.get('package_id');
        form.type = params.get('type') || 'package';
        const pkg = props.packages.find((p) => String(p.id) === params.get('package_id'));
        if (pkg) {
            form.subject = `Inquiry about the ${pkg.name} package`;
        }
    }
});

const submit = () => {
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset('message', 'subject'),
    });
};
</script>

<template>
    <Head :title="c('contact.hero.title', 'Contact')" />

    <PublicLayout>
        <PageHero page-key="contact" />

        <section class="relative overflow-hidden bg-gradient-to-b from-white via-slate-50 to-white py-16 lg:py-20">
            <div class="pointer-events-none absolute -left-24 top-10 h-80 w-80 rounded-full bg-accent-300/20 blur-3xl" />
            <div class="pointer-events-none absolute -right-24 bottom-10 h-80 w-80 rounded-full bg-brand-300/20 blur-3xl" />

            <div class="container-x relative grid grid-cols-1 gap-10 lg:grid-cols-3">
                <!-- Info cards -->
                <div class="space-y-4 lg:col-span-1">
                    <div class="card group flex items-start gap-4 p-6 transition hover:-translate-y-0.5 hover:shadow-lg">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-accent-500 text-white shadow-md"><Icon name="phone" class="h-6 w-6" /></span>
                        <div>
                            <p class="font-bold text-brand-900">{{ c('contact.cards.support_title') }}</p>
                            <p class="mt-1 flex flex-col text-sm text-slate-500">
                                <a :href="`tel:${settings.hotline}`" class="py-1 hover:text-brand-600">{{ settings.hotline }}</a>
                                <a :href="`tel:${settings.phone}`" class="py-1 hover:text-brand-600">{{ settings.phone }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="card group flex items-start gap-4 p-6 transition hover:-translate-y-0.5 hover:shadow-lg">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-600 to-fuchsia-500 text-white shadow-md"><Icon name="envelope" class="h-6 w-6" /></span>
                        <div class="min-w-0">
                            <p class="font-bold text-brand-900">{{ c('contact.cards.email_title') }}</p>
                            <a :href="`mailto:${settings.email}`" class="mt-1 block break-all py-1 text-sm text-slate-500 hover:text-brand-600">{{ settings.email }}</a>
                        </div>
                    </div>
                    <div class="card group flex items-start gap-4 p-6 transition hover:-translate-y-0.5 hover:shadow-lg">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-500 text-white shadow-md"><Icon name="map-pin" class="h-6 w-6" /></span>
                        <div>
                            <p class="font-bold text-brand-900">{{ c('contact.cards.address_title') }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ settings.address }}</p>
                            <a v-if="settings.map_url" :href="settings.map_url" target="_blank" rel="noopener noreferrer" class="mt-1 inline-block py-2 text-sm font-semibold text-accent-600 hover:underline">{{ c('contact.cards.directions') }}</a>
                        </div>
                    </div>
                    <div v-if="c('contact.cards.hours_title')" class="card group flex items-start gap-4 p-6 transition hover:-translate-y-0.5 hover:shadow-lg">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-md"><Icon name="clock" class="h-6 w-6" /></span>
                        <div>
                            <p class="font-bold text-brand-900">{{ c('contact.cards.hours_title') }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ c('contact.cards.hours_text') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form class="card space-y-5 p-6 shadow-xl shadow-slate-900/5 sm:p-8 lg:col-span-2" @submit.prevent="submit">
                    <div v-if="c('contact.form.title')" class="flex items-start gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-400 to-violet-600 text-white shadow-md shadow-violet-500/25"><Icon name="paper-airplane" class="h-6 w-6" /></span>
                        <div>
                            <h2 class="text-xl font-extrabold tracking-tight text-brand-900">{{ c('contact.form.title') }}</h2>
                            <p v-if="c('contact.form.text')" class="mt-1 text-sm text-slate-500">{{ c('contact.form.text') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ c('contact.form.name') }}</label>
                            <input v-model="form.name" type="text" required class="field" />
                            <p v-if="form.errors.name" class="mt-1 text-xs text-rose-600">{{ form.errors.name }}</p>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ c('contact.form.email') }}</label>
                            <input v-model="form.email" type="email" required class="field" />
                            <p v-if="form.errors.email" class="mt-1 text-xs text-rose-600">{{ form.errors.email }}</p>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ c('contact.form.phone') }}</label>
                            <input v-model="form.phone" type="text" class="field" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ c('contact.form.subject') }}</label>
                            <input v-model="form.subject" type="text" class="field" />
                        </div>
                    </div>

                    <div v-if="form.package_id">
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ c('contact.form.package') }}</label>
                        <select v-model="form.package_id" class="field">
                            <option v-for="p in packages" :key="p.id" :value="p.id">{{ p.name }} ({{ p.type === 'home' ? 'Home' : 'Corporate' }})</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ c('contact.form.message') }}</label>
                        <textarea v-model="form.message" rows="5" required class="field" />
                        <p v-if="form.errors.message" class="mt-1 text-xs text-rose-600">{{ form.errors.message }}</p>
                    </div>

                    <button type="submit" class="btn-primary !px-8 !py-3.5" :disabled="form.processing">
                        <Icon name="paper-airplane" class="h-5 w-5" />
                        {{ form.processing ? c('contact.form.sending') : c('contact.form.button') }}
                    </button>
                </form>
            </div>
        </section>

        <!-- Promise strip over a picture -->
        <section v-if="list('contact.strip.items').length" class="relative overflow-hidden py-16 text-white">
            <div v-if="c('contact.strip.image')" class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('contact.strip.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900/95 via-brand-900/85 to-brand-800/75" />
            <div class="container-x relative">
                <h2 v-if="c('contact.strip.title')" class="text-center text-2xl font-extrabold tracking-tight sm:text-3xl">{{ c('contact.strip.title') }}</h2>
                <div class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3">
                    <div v-for="(item, i) in list('contact.strip.items')" :key="i" class="rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur transition hover:-translate-y-1 hover:bg-white/15">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-accent-300 ring-1 ring-white/20"><Icon :name="item.icon" class="h-6 w-6" /></span>
                        <p class="mt-4 text-lg font-bold">{{ item.title }}</p>
                        <p class="mt-1 text-sm text-slate-300">{{ item.text }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map -->
        <section v-if="settings.map_embed" class="py-16 lg:py-20">
            <div class="container-x">
                <h2 v-if="c('contact.map.title')" class="mb-6 text-center text-2xl font-extrabold tracking-tight text-brand-900 sm:text-3xl">{{ c('contact.map.title') }}</h2>
                <div class="card overflow-hidden p-2 shadow-xl shadow-slate-900/5">
                    <iframe
                        :src="settings.map_embed"
                        title="Our location on Google Maps"
                        class="h-[380px] w-full rounded-2xl border-0 sm:h-[440px]"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                    />
                </div>
                <div class="mt-5 flex flex-col items-center justify-between gap-3 text-center sm:flex-row sm:text-left">
                    <p class="flex items-center justify-center gap-2 text-sm text-slate-500 sm:justify-start">
                        <Icon name="map-pin" class="h-4 w-4 text-accent-600" />
                        {{ settings.address }}
                    </p>
                    <a v-if="settings.map_url" :href="settings.map_url" target="_blank" rel="noopener noreferrer" class="btn-secondary">{{ c('contact.map.button') }}</a>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
