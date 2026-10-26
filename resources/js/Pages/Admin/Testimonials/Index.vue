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
    testimonials: Array,
});

const showModal = ref(false);
const editing = ref(null);

const form = useForm({
    name: '',
    designation: '',
    company: '',
    message: '',
    photo: null,
    rating: 5,
    order: 0,
    is_active: true,
});

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.rating = 5;
    form.clearErrors();
    showModal.value = true;
};

const openEdit = (t) => {
    editing.value = t;
    form.name = t.name;
    form.designation = t.designation;
    form.company = t.company;
    form.message = t.message;
    form.photo = null;
    form.rating = t.rating;
    form.order = t.order;
    form.is_active = t.is_active;
    form.clearErrors();
    showModal.value = true;
};

const submit = () => {
    if (editing.value) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(route('admin.testimonials.update', editing.value.id), {
            forceFormData: true,
            onSuccess: () => (showModal.value = false),
        });
    } else {
        form.post(route('admin.testimonials.store'), {
            forceFormData: true,
            onSuccess: () => (showModal.value = false),
        });
    }
};

const destroy = (t) => {
    if (confirm(`"${t.name}" Delete this item?`)) {
        router.delete(route('admin.testimonials.destroy', t.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Testimonial Management" />

    <AdminLayout title="Testimonial Management">
        <AdminCard title="All testimonials">
            <template #tools>
                <PrimaryButton @click="openCreate">+ New testimonial</PrimaryButton>
            </template>
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Company</th>
                        <th class="px-4 py-3">Rating</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="t in testimonials" :key="t.id">
                        <td class="px-4 py-3 font-medium text-slate-700">{{ t.name }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ t.company }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ t.rating }} / 5</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-semibold" :class="t.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'">
                                {{ t.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            <button class="mr-1 px-2 py-2 text-brand-600 hover:underline" @click="openEdit(t)">Edit</button>
                            <button class="px-2 py-2 text-rose-600 hover:underline" @click="destroy(t)">Delete</button>
                        </td>
                    </tr>
                    <tr v-if="!testimonials.length">
                        <td colspan="5" class="px-4 py-8 text-center text-slate-400">No testimonials yet.</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </AdminCard>

        <Modal :show="showModal" @close="showModal = false">
            <form class="max-h-[85vh] overflow-y-auto p-6" @submit.prevent="submit">
                <h2 class="text-lg font-semibold text-slate-800">{{ editing ? 'Edit Testimonial' : 'New testimonial' }}</h2>

                <div class="mt-4 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Name *" />
                            <TextInput v-model="form.name" class="mt-1 w-full" required />
                            <InputError :message="form.errors.name" class="mt-1" />
                        </div>
                        <div>
                            <InputLabel value="Designation" />
                            <TextInput v-model="form.designation" class="mt-1 w-full" />
                        </div>
                        <div>
                            <InputLabel value="Organization / Area" />
                            <TextInput v-model="form.company" class="mt-1 w-full" />
                        </div>
                        <div>
                            <InputLabel value="Rating (1-5)" />
                            <TextInput v-model="form.rating" type="number" min="1" max="5" class="mt-1 w-full" />
                        </div>
                    </div>
                    <div>
                        <InputLabel value="Message *" />
                        <textarea v-model="form.message" rows="3" required class="mt-1 w-full rounded-md border-slate-300 text-sm" />
                        <InputError :message="form.errors.message" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel value="Image" />
                        <input type="file" accept="image/*" class="mt-1 block w-full text-sm" @input="form.photo = $event.target.files[0]" />
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
