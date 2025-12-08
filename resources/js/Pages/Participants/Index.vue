<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    participants: Array,
});
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
                        <th>Gender</th>
                        <th>Period</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="p in participants" :key="p.id">
                        <td>{{ p.name }}</td>
                        <td>{{ p.gender.charAt(0).toUpperCase() + p.gender.slice(1) }}</td>
                        <td>{{ p.period.name }} ({{ p.period.year }})</td>
                        <td>
                            <Link :href="`/participants/${p.id}/edit`" style="color: var(--primary); text-decoration: none;">Edit</Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
