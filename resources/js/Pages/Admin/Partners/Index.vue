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
    partners: Array,
});

const showModal = ref(false);
const editing = ref(null);

const form = useForm({
    name: '',
    logo: null,
    website_url: '',
    type: 'partner',
    order: 0,
    is_active: true,
});

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.type = 'partner';
    form.clearErrors();
    showModal.value = true;
};

const openEdit = (p) => {
    editing.value = p;
    form.name = p.name;
    form.logo = null;
    form.website_url = p.website_url;
    form.type = p.type;
    form.order = p.order;
    form.is_active = p.is_active;
    form.clearErrors();
    showModal.value = true;
};

const submit = () => {
    if (editing.value) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(route('admin.partners.update', editing.value.id), {
            forceFormData: true,
            onSuccess: () => (showModal.value = false),
        });
    } else {
        form.post(route('admin.partners.store'), {
            forceFormData: true,
            onSuccess: () => (showModal.value = false),
        });
    }
};

const destroy = (p) => {
    if (confirm(`"${p.name}" Delete this item?`)) {
        router.delete(route('admin.partners.destroy', p.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Client / Partner Management" />

    <AdminLayout title="Client / Partner Management">
        <AdminCard title="All clients / partners">
            <template #tools>
                <PrimaryButton @click="openCreate">+ Add new</PrimaryButton>
            </template>
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="p in partners" :key="p.id">
                        <td class="px-4 py-3 font-medium text-slate-700">{{ p.name }}</td>
                        <td class="px-4 py-3 capitalize text-slate-500">{{ p.type }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-semibold" :class="p.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'">
                                {{ p.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            <button class="mr-1 px-2 py-2 text-brand-600 hover:underline" @click="openEdit(p)">Edit</button>
                            <button class="px-2 py-2 text-rose-600 hover:underline" @click="destroy(p)">Delete</button>
                        </td>
                    </tr>
                    <tr v-if="!partners.length">
                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">No entries yet.</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </AdminCard>

        <Modal :show="showModal" @close="showModal = false">
            <form class="p-6" @submit.prevent="submit">
                <h2 class="text-lg font-semibold text-slate-800">{{ editing ? 'Edit' : 'Add new' }}</h2>

                <div class="mt-4 space-y-4">
                    <div>
                        <InputLabel value="Name *" />
                        <TextInput v-model="form.name" class="mt-1 w-full" required />
                        <InputError :message="form.errors.name" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel value="Website URL" />
                        <TextInput v-model="form.website_url" class="mt-1 w-full" />
                    </div>
                    <div>
                        <InputLabel value="Logo" />
                        <input type="file" accept="image/*" class="mt-1 block w-full text-sm" @input="form.logo = $event.target.files[0]" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Type *" />
                            <select v-model="form.type" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                                <option value="client">Client</option>
                                <option value="partner">Partner</option>
                            </select>
                        </div>
                        <div>
                            <InputLabel value="Order" />
                            <TextInput v-model="form.order" type="number" class="mt-1 w-full" />
                        </div>
                    </div>
                    <label class="flex items-center gap-2">
                        <Checkbox v-model:checked="form.is_active" />
                        <span class="text-sm text-slate-600">Active</span>
                    </label>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton type="button" @click="showModal = false">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                </div>
            </form>
        </Modal>
    </AdminLayout>
</template>
