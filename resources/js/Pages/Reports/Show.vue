<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    participant_result: Object,
    stats: Object,
    appraisers: Object
});

const p = computed(() => props.participant_result.participant);
const details = computed(() => props.participant_result.appraiser_details);

const formatNumber = (n) => Number(n).toFixed(2);
const formatScore = (n) => Number(n).toFixed(4); // Higher precision for weighted scores
</script>

<template>
    <AppLayout>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-weight: 700; margin: 0;">Analysis Report</h2>
                <p style="color: var(--text-muted); margin-top: 0.5rem;">Detailed breakdown for {{ p.name }}</p>
            </div>
            <Link href="/reports" class="btn-primary" style="background: transparent; border: 1px solid var(--glass-border);">&larr; Back to Rankings</Link>
        </div>

        <!-- summary Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div class="glass" style="padding: 1.5rem; text-align: center;">
                <p style="text-transform: uppercase; font-size: 0.8rem; color: var(--text-muted);">Final Rank</p>
                <h3 style="font-size: 2.5rem; margin: 0.5rem 0; color: #fbbf24;">#{{ participant_result.final_rank }}</h3>
            </div>
            <div class="glass" style="padding: 1.5rem; text-align: center;">
                <p style="text-transform: uppercase; font-size: 0.8rem; color: var(--text-muted);">Total Points</p>
                <h3 style="font-size: 2.5rem; margin: 0.5rem 0;">{{ formatNumber(participant_result.total_borda_score) }}</h3>
                <p style="font-size: 0.8rem; color: var(--text-muted);">vs Avg: {{ formatNumber(stats.class_average) }}</p>
            </div>
        </div>

        <!-- Performance Comparison Chart -->
        <div class="glass" style="padding: 2rem; margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1.5rem;">Performance Comparison</h3>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <!-- Participant Bar -->
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span>{{ p.name }}</span>
                        <span>{{ formatNumber(participant_result.total_borda_score) }}</span>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); height: 8px; border-radius: 4px; overflow: hidden;">
                        <div :style="{ width: (participant_result.total_borda_score / stats.max_score) * 100 + '%', background: '#4f46e5', height: '100%' }"></div>
                    </div>
                </div>
                <!-- Average Bar -->
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: var(--text-muted);">Class Average</span>
                        <span style="color: var(--text-muted);">{{ formatNumber(stats.class_average) }}</span>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); height: 8px; border-radius: 4px; overflow: hidden;">
                        <div :style="{ width: (stats.class_average / stats.max_score) * 100 + '%', background: '#9ca3af', height: '100%' }"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Breakdown per Appraiser -->
        <h3 style="margin-bottom: 1rem; margin-top: 3rem;">Detailed Calculation Steps</h3>
        
        <div v-for="(detail, appraiserId) in details" :key="appraiserId" class="glass" style="padding: 2rem; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--glass-border); padding-bottom: 1rem; margin-bottom: 1rem;">
                <h4 style="margin: 0;">Assessor: {{ appraisers[appraiserId] }}</h4>
                <div style="text-align: right;">
                    <div style="font-size: 0.9rem;">SMART Score: <span style="font-weight: 700;">{{ formatScore(detail.smart_score) }}</span></div>
                    <div style="font-size: 0.9rem;">Individual Rank: <span style="font-weight: 700;">#{{ detail.rank }}</span></div>
                    <div style="font-size: 0.9rem;">Borda Points: <span style="font-weight: 700; color: #10b981;">{{ detail.borda_points }}</span></div>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid var(--glass-border);">
                        <th style="padding: 0.75rem 1rem; width: 15%;">Criteria</th>
                        <th style="padding: 0.75rem 1rem; width: 15%; text-align: right;">Raw Value</th>
                        <th style="padding: 0.75rem 1rem; width: 35%;">Utility (0-100)</th>
                        <th style="padding: 0.75rem 1rem; width: 20%; text-align: right;">Weighted Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(criterion, code) in detail.smart_details" :key="code" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 0.75rem 1rem; font-weight: 600;">{{ code }}</td>
                        <td style="padding: 0.75rem 1rem; text-align: right;">{{ criterion.value }}</td>
                        <td style="padding: 0.75rem 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="flex: 1; height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden;">
                                    <div :style="{ width: criterion.utility + '%', background: 'var(--primary)', height: '100%' }"></div>
                                </div>
                                <span style="min-width: 50px; text-align: right; font-weight: 600;">{{ formatNumber(criterion.utility) }}</span>
                            </div>
                        </td>
                        <td style="padding: 0.75rem 1rem; font-weight: 700; text-align: right; color: #10b981;">{{ formatScore(criterion.weighted_score) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
