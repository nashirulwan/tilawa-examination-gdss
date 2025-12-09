<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role,
    password: '',
});

const submit = () => {
    form.put(`/users/${props.user.id}`);
};
</script>

<template>
    <AppLayout>
        <div style="max-width: 600px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="margin: 0;">Edit User: {{ user.name }}</h2>
                <Link href="/users" style="color: var(--text-muted); text-decoration: none;">← Back</Link>
            </div>
            <div class="glass" style="padding: 2rem;">
                <form @submit.prevent="submit">
                    <div>
                        <label>Name</label>
                        <input v-model="form.name" type="text" required>
                    </div>
                    <div>
                        <label>Email</label>
                        <input v-model="form.email" type="email" required>
                    </div>
                    <div>
                        <label>Role</label>
                        <select v-model="form.role" style="width: 100%; padding: 12px; margin-bottom: 1rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                            <option value="appraiser">Appraiser</option>
                            <option value="jury_chair">Jury Chair</option>
                            <option value="committee">Committee</option>
                        </select>
                    </div>
                    <div>
                        <label>Password (Leave blank to keep)</label>
                        <input v-model="form.password" type="password">
                    </div>
                    <button type="submit" class="btn-primary" :disabled="form.processing">Update User</button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
