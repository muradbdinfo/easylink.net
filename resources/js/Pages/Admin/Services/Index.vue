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

defineProps({
    services: Array,
});

const iconOptions = ['wifi', 'building-office', 'phone', 'server', 'signal', 'shield-check', 'tv', 'chat-bubble-left-right', 'cloud', 'lock', 'globe', 'bolt'];

const showModal = ref(false);
const editing = ref(null);

const form = useForm({
    title: '',
    icon: 'wifi',
    short_description: '',
    description: '',
    image: null,
    category: 'general',
    order: 0,
    is_active: true,
});

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.icon = 'wifi';
    form.category = 'general';
    form.clearErrors();
    showModal.value = true;
};

const openEdit = (service) => {
    editing.value = service;
    form.title = service.title;
    form.icon = service.icon;
    form.short_description = service.short_description;
    form.description = service.description;
    form.image = null;
    form.category = service.category;
    form.order = service.order;
    form.is_active = service.is_active;
    form.clearErrors();
    showModal.value = true;
};

const submit = () => {
    if (editing.value) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(route('admin.services.update', editing.value.id), {
            forceFormData: true,
            onSuccess: () => (showModal.value = false),
        });
    } else {
        form.post(route('admin.services.store'), {
            forceFormData: true,
            onSuccess: () => (showModal.value = false),
        });
    }
};

const destroy = (service) => {
    if (confirm(`"${service.title}" Delete this item?`)) {
        router.delete(route('admin.services.destroy', service.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Service Management" />

    <AdminLayout title="Service Management">
        <AdminCard title="All services">
            <template #tools>
                <PrimaryButton @click="openCreate">+ New service</PrimaryButton>
            </template>
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="service in services" :key="service.id">
                        <td class="px-4 py-3 font-medium text-slate-700">{{ service.title }}</td>
                        <td class="px-4 py-3 capitalize text-slate-500">{{ service.category }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ service.order }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-semibold" :class="service.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'">
                                {{ service.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button class="mr-3 text-brand-600 hover:underline" @click="openEdit(service)">Edit</button>
                            <button class="text-rose-600 hover:underline" @click="destroy(service)">Delete</button>
                        </td>
                    </tr>
                    <tr v-if="!services.length">
                        <td colspan="5" class="px-4 py-8 text-center text-slate-400">No services yet.</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </AdminCard>

        <Modal :show="showModal" max-width="2xl" @close="showModal = false">
            <form class="max-h-[85vh] overflow-y-auto p-6" @submit.prevent="submit">
                <h2 class="text-lg font-semibold text-slate-800">{{ editing ? 'Edit Service' : 'New service' }}</h2>

                <div class="mt-4 space-y-4">
                    <div>
                        <InputLabel value="Title *" />
                        <TextInput v-model="form.title" class="mt-1 w-full" required />
                        <InputError :message="form.errors.title" class="mt-1" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Icon" />
                            <select v-model="form.icon" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                                <option v-for="icon in iconOptions" :key="icon" :value="icon">{{ icon }}</option>
                            </select>
                        </div>
                        <div>
                            <InputLabel value="Category *" />
                            <select v-model="form.category" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                                <option value="home">Home</option>
                                <option value="corporate">Corporate</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <InputLabel value="Short description" />
                        <TextInput v-model="form.short_description" class="mt-1 w-full" />
                    </div>
                    <div>
                        <InputLabel value="Full description" />
                        <textarea v-model="form.description" rows="4" class="mt-1 w-full rounded-md border-slate-300 text-sm" />
                    </div>
                    <div>
                        <InputLabel value="Image" />
                        <input type="file" accept="image/*" class="mt-1 block w-full text-sm" @input="form.image = $event.target.files[0]" />
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
