<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    settings: Object,
});

const form = useForm({
    site_name: props.settings.site_name || '',
    tagline: props.settings.tagline || '',
    hotline: props.settings.hotline || '',
    phone: props.settings.phone || '',
    email: props.settings.email || '',
    address: props.settings.address || '',
    about_text: props.settings.about_text || '',
    facebook_url: props.settings.facebook_url || '',
    youtube_url: props.settings.youtube_url || '',
    linkedin_url: props.settings.linkedin_url || '',
    instagram_url: props.settings.instagram_url || '',
    footer_text: props.settings.footer_text || '',
    logo: null,
    remove_logo: false,
});

const logoPreview = ref(null);

const onLogoChange = (e) => {
    const file = e.target.files[0] || null;
    form.logo = file;
    form.remove_logo = false;
    logoPreview.value = file ? URL.createObjectURL(file) : null;
};

const removeLogo = () => {
    form.logo = null;
    form.remove_logo = true;
    logoPreview.value = null;
};

const submit = () =>
    form
        .transform((data) => ({ ...data, _method: 'put' }))
        .post(route('admin.settings.update'), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                form.logo = null;
                form.remove_logo = false;
                logoPreview.value = null;
            },
        });
</script>

<template>
    <Head title="Site settings" />

    <AdminLayout title="Site settings">
        <AdminCard title="General settings" class="max-w-3xl">
        <form class="space-y-6 p-6" @submit.prevent="submit">
            <div>
                <InputLabel value="Website logo" />
                <div class="mt-2 flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-md border border-slate-200 bg-slate-50">
                        <img
                            v-if="logoPreview || (settings.logo && !form.remove_logo)"
                            :src="logoPreview || settings.logo"
                            alt="Logo"
                            class="h-full w-full object-contain"
                        />
                        <span v-else class="text-xs text-slate-400">No Logo</span>
                    </div>
                    <div>
                        <input type="file" accept="image/*" class="block w-full text-sm" @change="onLogoChange" />
                        <button
                            v-if="logoPreview || (settings.logo && !form.remove_logo)"
                            type="button"
                            class="mt-1 text-xs text-rose-600 hover:underline"
                            @click="removeLogo"
                        >
                            Remove logo
                        </button>
                    </div>
                </div>
                <InputError :message="form.errors.logo" class="mt-1" />
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <InputLabel value="Site name" />
                    <TextInput v-model="form.site_name" class="mt-1 w-full" />
                </div>
                <div>
                    <InputLabel value="Tagline" />
                    <TextInput v-model="form.tagline" class="mt-1 w-full" />
                </div>
                <div>
                    <InputLabel value="Hotline" />
                    <TextInput v-model="form.hotline" class="mt-1 w-full" />
                </div>
                <div>
                    <InputLabel value="Phone" />
                    <TextInput v-model="form.phone" class="mt-1 w-full" />
                </div>
                <div>
                    <InputLabel value="Email" />
                    <TextInput v-model="form.email" type="email" class="mt-1 w-full" />
                </div>
                <div class="sm:col-span-2">
                    <InputLabel value="Address" />
                    <TextInput v-model="form.address" class="mt-1 w-full" />
                </div>
            </div>

            <div>
                <InputLabel value="About text" />
                <textarea v-model="form.about_text" rows="5" class="mt-1 w-full rounded-md border-slate-300 text-sm" />
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <InputLabel value="Facebook URL" />
                    <TextInput v-model="form.facebook_url" class="mt-1 w-full" />
                </div>
                <div>
                    <InputLabel value="YouTube URL" />
                    <TextInput v-model="form.youtube_url" class="mt-1 w-full" />
                </div>
                <div>
                    <InputLabel value="LinkedIn URL" />
                    <TextInput v-model="form.linkedin_url" class="mt-1 w-full" />
                </div>
                <div>
                    <InputLabel value="Instagram URL" />
                    <TextInput v-model="form.instagram_url" class="mt-1 w-full" />
                </div>
            </div>

            <div>
                <InputLabel value="Footer text" />
                <TextInput v-model="form.footer_text" class="mt-1 w-full" />
            </div>

            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
        </form>
        </AdminCard>
    </AdminLayout>
</template>
