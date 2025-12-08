<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    participants: Array,
});

const deleteParticipant = (id) => {
    if (confirm('Are you sure you want to delete this participant?')) {
        router.delete(`/participants/${id}`);
    }
};

const toggleActive = (id, currentStatus) => {
    router.patch(`/participants/${id}`, { is_active: !currentStatus });
};
</script>

<template>
    <AppLayout>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-weight: 700; margin: 0;">Participant Management</h2>
            <Link href="/participants/create" class="btn-primary" style="text-decoration: none;">Add Participant</Link>
        </div>

        <div class="glass" style="padding: 1.5rem;">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Gender</th>
                        <th>Period</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="p in participants" :key="p.id">
                        <td style="font-weight: 600;">{{ p.name }}</td>
                        <td>{{ p.department }}</td>
                        <td>{{ p.gender.charAt(0).toUpperCase() + p.gender.slice(1) }}</td>
                        <td>{{ p.period?.year }}</td>
                        <td>
                            <button 
                                @click="toggleActive(p.id, p.is_active)"
                                :style="{
                                    padding: '6px 14px',
                                    borderRadius: '20px',
                                    border: 'none',
                                    cursor: 'pointer',
                                    fontSize: '0.75rem',
                                    fontWeight: '600',
                                    background: p.is_active ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #6b7280, #4b5563)',
                                    color: 'white',
                                    boxShadow: '0 2px 4px rgba(0,0,0,0.2)'
                                }"
                            >
                                {{ p.is_active ? '✓ Active' : '✗ Inactive' }}
                            </button>
                        </td>
                        <td style="display: flex; gap: 0.5rem;">
                            <Link :href="`/participants/${p.id}/edit`" style="padding: 6px 12px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border-radius: 6px; text-decoration: none; font-size: 0.8rem;">Edit</Link>
                            <button @click="deleteParticipant(p.id)" style="padding: 6px 12px; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.8rem;">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
