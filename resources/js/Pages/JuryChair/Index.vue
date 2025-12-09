<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

defineProps({
    period: Object,
    appraisers: Array,
    allCompleted: Boolean,
    bordaResults: Object
});

const triggerCalculation = () => {
    if (confirm('Are you sure you want to calculate the final rankings using Borda Count?')) {
        router.post('/jury-chair/calculate');
    }
};
</script>

<template>
    <AppLayout>
        <h2 style="margin-bottom: 2rem; font-weight: 700;">Jury Chair Dashboard</h2>
        
        <!-- Period Info -->
        <div class="glass" style="padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="margin: 0 0 0.5rem 0;">Active Period</h3>
            <p style="margin: 0; color: var(--text-muted);">{{ period?.year || 'No active period' }}</p>
        </div>

        <!-- Appraiser Assessment Status -->
        <div class="glass" style="padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="margin: 0 0 1rem 0;">Appraiser Assessment Status</h3>
            <table>
                <thead>
                    <tr>
                        <th>Appraiser</th>
                        <th>Assessed</th>
                        <th>Total Participants</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="appraiser in appraisers" :key="appraiser.id">
                        <td style="font-weight: 600;">{{ appraiser.name }}</td>
                        <td>{{ appraiser.assessed }}</td>
                        <td>{{ appraiser.total }}</td>
                        <td>
                            <span :style="{
                                padding: '4px 12px',
                                borderRadius: '20px',
                                fontSize: '0.75rem',
                                fontWeight: '600',
                                background: appraiser.completed ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #f59e0b, #d97706)',
                                color: 'white'
                            }">
                                {{ appraiser.completed ? 'Completed' : 'In Progress' }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Calculation Trigger -->
        <div class="glass" style="padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="margin: 0 0 1rem 0;">Final Borda Calculation</h3>
            <p style="color: var(--text-muted); margin-bottom: 1rem;">
                Once all appraisers have completed their assessments, you can trigger the final Borda Count calculation to determine the rankings.
            </p>
            <button 
                @click="triggerCalculation"
                class="btn-primary"
                :disabled="!allCompleted"
                :style="{ opacity: allCompleted ? 1 : 0.5 }"
            >
                Calculate Final Rankings
            </button>
            <p v-if="!allCompleted" style="color: #f59e0b; margin-top: 0.5rem; font-size: 0.875rem;">
                Waiting for all appraisers to complete their assessments.
            </p>
        </div>

        <!-- Results (if available) -->
        <div v-if="bordaResults" class="glass" style="padding: 1.5rem;">
            <h3 style="margin: 0 0 1rem 0;">Final Rankings (Borda Count)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Participant</th>
                        <th>Borda Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(result, index) in bordaResults" :key="index">
                        <td style="font-weight: 700; font-size: 1.25rem;">
                            <span :style="{
                                display: 'inline-flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                width: '32px',
                                height: '32px',
                                borderRadius: '50%',
                                background: index === 0 ? '#fbbf24' : index === 1 ? '#9ca3af' : index === 2 ? '#cd7f32' : 'transparent',
                                color: index < 3 ? '#1f2937' : 'inherit'
                            }">
                                {{ index + 1 }}
                            </span>
                        </td>
                        <td style="font-weight: 600;">{{ result.participant?.name }}</td>
                        <td>{{ result.total_borda_score.toFixed(2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
