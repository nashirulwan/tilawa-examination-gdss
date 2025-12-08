<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    users: Array,
});
</script>

<template>
    <AppLayout>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-weight: 700; margin: 0;">User Management</h2>
            <Link href="/users/create" class="btn-primary" style="text-decoration: none;">Add User</Link>
        </div>

        <div class="glass" style="padding: 1.5rem;">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <span style="padding: 4px 8px; border-radius: 4px; background: rgba(255, 255, 255, 0.1); font-size: 0.8rem;">
                                {{ user.role.charAt(0).toUpperCase() + user.role.slice(1) }}
                            </span>
                        </td>
                        <td>
                            <Link :href="`/users/${user.id}/edit`" style="color: var(--primary); margin-right: 1rem; text-decoration: none;">Edit</Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
