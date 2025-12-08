<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: 'admin@mtq.com',
    password: 'password',
});

const submit = () => {
    form.post('/login');
};
</script>

<template>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div class="glass" style="padding: 3rem; width: 100%; max-width: 400px; text-align: center;">
            <h2 style="margin-bottom: 2rem;">Welcome Back</h2>
            
            <form @submit.prevent="submit">
                <div style="margin-bottom: 1rem; text-align: left;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Email</label>
                    <input v-model="form.email" type="email" required autofocus>
                    <div v-if="form.errors.email" style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ form.errors.email }}</div>
                </div>

                <div style="margin-bottom: 2rem; text-align: left;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Password</label>
                    <input v-model="form.password" type="password" required>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%;" :disabled="form.processing">
                    Sign In
                </button>
            </form>
            
            <div style="margin-top: 1rem; font-size: 0.875rem; color: var(--text-muted);">
                <p>Demo Accounts:</p>
                <p>Admin: admin@mtq.com / password</p>
                <p>Appraiser: appraiser1@mtq.com / password</p>
            </div>
        </div>
    </div>
</template>
