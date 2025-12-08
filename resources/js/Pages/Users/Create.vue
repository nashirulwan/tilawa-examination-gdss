<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    role: 'appraiser',
    password: '',
});

const submit = () => {
    form.post('/users');
};
</script>

<template>
    <AppLayout>
        <div style="max-width: 600px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="margin: 0;">Create User</h2>
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
                            <option value="committee">Committee</option>
                        </select>
                    </div>
                    <div>
                        <label>Password</label>
                        <input v-model="form.password" type="password" required>
                    </div>
                    <button type="submit" class="btn-primary" :disabled="form.processing">Save User</button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
