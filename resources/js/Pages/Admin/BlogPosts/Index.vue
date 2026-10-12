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
    posts: Array,
});

const showModal = ref(false);
const editing = ref(null);

const form = useForm({
    title: '',
    excerpt: '',
    content: '',
    image: null,
    author_name: 'EasyLink Team',
    is_published: true,
});

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.author_name = 'EasyLink Team';
    form.is_published = true;
    form.clearErrors();
    showModal.value = true;
};

const openEdit = (post) => {
    editing.value = post;
    form.title = post.title;
    form.excerpt = post.excerpt;
    form.content = post.content;
    form.image = null;
    form.author_name = post.author_name;
    form.is_published = post.is_published;
    form.clearErrors();
    showModal.value = true;
};

const submit = () => {
    if (editing.value) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(route('admin.blog-posts.update', editing.value.id), {
            forceFormData: true,
            onSuccess: () => (showModal.value = false),
        });
    } else {
        form.post(route('admin.blog-posts.store'), {
            forceFormData: true,
            onSuccess: () => (showModal.value = false),
        });
    }
};

const destroy = (post) => {
    if (confirm(`"${post.title}" Delete this item?`)) {
        router.delete(route('admin.blog-posts.destroy', post.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Blog Management" />

    <AdminLayout title="Blog Management">
        <AdminCard title="All posts">
            <template #tools>
                <PrimaryButton @click="openCreate">+ New post</PrimaryButton>
            </template>
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Author</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="post in posts" :key="post.id">
                        <td class="px-4 py-3 font-medium text-slate-700">{{ post.title }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ post.author_name }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-semibold" :class="post.is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'">
                                {{ post.is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button class="mr-3 text-brand-600 hover:underline" @click="openEdit(post)">Edit</button>
                            <button class="text-rose-600 hover:underline" @click="destroy(post)">Delete</button>
                        </td>
                    </tr>
                    <tr v-if="!posts.length">
                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">No posts yet.</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </AdminCard>

        <Modal :show="showModal" max-width="2xl" @close="showModal = false">
            <form class="max-h-[85vh] overflow-y-auto p-6" @submit.prevent="submit">
                <h2 class="text-lg font-semibold text-slate-800">{{ editing ? 'Edit Post' : 'New post' }}</h2>

                <div class="mt-4 space-y-4">
                    <div>
                        <InputLabel value="Title *" />
                        <TextInput v-model="form.title" class="mt-1 w-full" required />
                        <InputError :message="form.errors.title" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel value="Short description" />
                        <TextInput v-model="form.excerpt" class="mt-1 w-full" />
                    </div>
                    <div>
                        <InputLabel value="Full content *" />
                        <textarea v-model="form.content" rows="6" required class="mt-1 w-full rounded-md border-slate-300 text-sm" />
                        <InputError :message="form.errors.content" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel value="Image" />
                        <input type="file" accept="image/*" class="mt-1 block w-full text-sm" @input="form.image = $event.target.files[0]" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Author" />
                            <TextInput v-model="form.author_name" class="mt-1 w-full" />
                        </div>
                        <label class="mt-6 flex items-center gap-2">
                            <Checkbox v-model:checked="form.is_published" />
                            <span class="text-sm text-slate-600">Published</span>
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
