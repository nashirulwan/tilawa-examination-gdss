<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    participants: Array,
});
</script>

<template>
    <AppLayout>
        <h2 style="margin-bottom: 2rem; font-weight: 700;">Rate Participants</h2>

        <div class="glass" style="padding: 1.5rem;">
            <table>
                <thead>
                    <tr>
                        <th>Participant</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="p in participants" :key="p.id">
                        <td>{{ p.name }}</td>
                        <td>
                            <span v-if="p.is_assessed" style="color: #10b981; font-weight: 600;">Completed</span>
                            <span v-else style="color: var(--text-muted);">Pending</span>
                        </td>
                        <td>
                            <Link :href="`/assessments/${p.id}/rate`" class="btn-primary" style="padding: 8px 16px; font-size: 0.9rem; text-decoration: none;">
                                {{ p.is_assessed ? 'Update Rating' : 'Rate Now' }}
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
