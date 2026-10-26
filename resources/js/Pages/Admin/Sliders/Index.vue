<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    sliders: Array,
});

const showModal = ref(false);
const editing = ref(null);

const form = useForm({
    title: '',
    subtitle: '',
    image: null,
    button_text: '',
    button_link: '',
    order: 0,
    is_active: true,
});

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.clearErrors();
    showModal.value = true;
};

const openEdit = (slider) => {
    editing.value = slider;
    form.title = slider.title;
    form.subtitle = slider.subtitle;
    form.image = null;
    form.button_text = slider.button_text;
    form.button_link = slider.button_link;
    form.order = slider.order;
    form.is_active = slider.is_active;
    form.clearErrors();
    showModal.value = true;
};

const submit = () => {
    if (editing.value) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(route('admin.sliders.update', editing.value.id), {
            forceFormData: true,
            onSuccess: () => (showModal.value = false),
        });
    } else {
        form.post(route('admin.sliders.store'), {
            forceFormData: true,
            onSuccess: () => (showModal.value = false),
        });
    }
};

const destroy = (slider) => {
    if (confirm(`"${slider.title}" Delete this item?`)) {
        router.delete(route('admin.sliders.destroy', slider.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Slider Management" />

    <AdminLayout title="Slider Management">
        <AdminCard title="All sliders">
            <template #tools>
                <PrimaryButton @click="openCreate">+ New slider</PrimaryButton>
            </template>
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Button</th>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="slider in sliders" :key="slider.id">
                        <td class="px-4 py-3 font-medium text-slate-700">{{ slider.title }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ slider.button_text }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ slider.order }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-semibold" :class="slider.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'">
                                {{ slider.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            <button class="mr-1 px-2 py-2 text-brand-600 hover:underline" @click="openEdit(slider)">Edit</button>
                            <button class="px-2 py-2 text-rose-600 hover:underline" @click="destroy(slider)">Delete</button>
                        </td>
                    </tr>
                    <tr v-if="!sliders.length">
                        <td colspan="5" class="px-4 py-8 text-center text-slate-400">No sliders yet.</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </AdminCard>

        <Modal :show="showModal" @close="showModal = false">
            <form class="p-6" @submit.prevent="submit">
                <h2 class="text-lg font-semibold text-slate-800">{{ editing ? 'Edit Slider' : 'New slider' }}</h2>

                <div class="mt-4 space-y-4">
                    <div>
                        <InputLabel value="Title *" />
                        <TextInput v-model="form.title" class="mt-1 w-full" required />
                        <InputError :message="form.errors.title" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel value="Subtitle" />
                        <TextInput v-model="form.subtitle" class="mt-1 w-full" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Button text" />
                            <TextInput v-model="form.button_text" class="mt-1 w-full" />
                        </div>
                        <div>
                            <InputLabel value="Button link" />
                            <TextInput v-model="form.button_link" class="mt-1 w-full" placeholder="/packages" />
                        </div>
                    </div>
                    <div>
                        <InputLabel value="Image" />
                        <input type="file" accept="image/*" class="mt-1 block w-full text-sm" @input="form.image = $event.target.files[0]" />
                        <InputError :message="form.errors.image" class="mt-1" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Order" />
                            <TextInput v-model="form.order" type="number" class="mt-1 w-full" />
                        </div>
                        <label class="mt-6 flex items-center gap-2">
                            <Checkbox v-model:checked="form.is_active" />
                            <span class="text-sm text-slate-600">Active</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton type="button" @click="showModal = false">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                </div>
            </form>
        </Modal>
    </AdminLayout>
</template>
