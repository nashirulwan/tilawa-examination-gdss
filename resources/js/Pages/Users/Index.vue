<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    users: Array,
});

const deleteUser = (userId) => {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(`/users/${userId}`);
    }
};

const toggleActive = (userId, currentStatus) => {
    router.patch(`/users/${userId}`, { is_active: !currentStatus });
};
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
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td style="font-weight: 600;">{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <span style="padding: 4px 10px; border-radius: 4px; background: rgba(255, 255, 255, 0.1); font-size: 0.8rem;">
                                {{ user.role.charAt(0).toUpperCase() + user.role.slice(1) }}
                            </span>
                        </td>
                        <td>
                            <button 
                                @click="toggleActive(user.id, user.is_active)"
                                :style="{
                                    padding: '6px 14px',
                                    borderRadius: '20px',
                                    border: 'none',
                                    cursor: 'pointer',
                                    fontSize: '0.75rem',
                                    fontWeight: '600',
                                    background: user.is_active ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #6b7280, #4b5563)',
                                    color: 'white',
                                    boxShadow: '0 2px 4px rgba(0,0,0,0.2)'
                                }"
                            >
                                {{ user.is_active ? '✓ Active' : '✗ Inactive' }}
                            </button>
                        </td>
                        <td style="display: flex; gap: 0.5rem;">
                            <Link :href="`/users/${user.id}/edit`" style="padding: 6px 12px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border-radius: 6px; text-decoration: none; font-size: 0.8rem;">Edit</Link>
                            <button @click="deleteUser(user.id)" style="padding: 6px 12px; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.8rem;">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
