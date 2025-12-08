<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    results: Array,
    period: Object,
});

const formatNumber = (num) => {
    return Number(num).toFixed(2);
};
</script>

<template>
    <AppLayout>
        <h2 style="margin-bottom: 2rem; font-weight: 700;">Final Rankings (Vue)</h2>

        <div v-if="period" class="glass" style="padding: 2rem; margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">Period: {{ period.name }}</h3>
            
            <table>
                <thead>
                    <tr>
                        <th width="10%">Rank</th>
                        <th>Participant</th>
                        <th width="20%">Total Borda Points</th>
                        <th width="15%">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="res in results" :key="res.participant.id">
                        <td>
                            <div :style="{
                                width: '32px', 
                                height: '32px', 
                                background: res.final_rank <= 3 ? 'linear-gradient(135deg, #ffd700, #f59e0b)' : 'rgba(255,255,255,0.1)',
                                borderRadius: '50%',
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                fontWeight: 'bold',
                                color: res.final_rank <= 3 ? 'black' : 'white'
                            }">
                                {{ res.final_rank }}
                            </div>
                        </td>
                        <td>{{ res.participant.name }}</td>
                        <td>
                            <span style="font-size: 1.25rem; font-weight: 600;">
                                {{ formatNumber(res.total_borda_score) }}
                            </span>
                        </td>
                        <td>
                            <!-- Link to detail view -->
                            <Link :href="`/reports/${res.participant.id}`" class="btn-primary" style="padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">View Detail</Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="glass" style="padding: 2rem;">
            <p>No active period found.</p>
        </div>
    </AppLayout>
</template>
