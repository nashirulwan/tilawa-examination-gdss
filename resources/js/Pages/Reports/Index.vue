<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    results: Array,
    period: Object,
});

const formatNumber = (num) => Number(num).toFixed(2);

// Get all appraisers from first result
const appraisers = props.results && props.results.length > 0 
    ? Object.keys(props.results[0].appraiser_details) 
    : [];
</script>

<template>
    <AppLayout>
        <h2 style="margin-bottom: 2rem; font-weight: 700;">Final Group Rankings</h2>

        <div v-if="period">
            <!-- SMART Calculation Tables per Appraiser -->
            <div v-for="(appId, idx) in appraisers" :key="appId" class="glass" style="padding: 2rem; margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem;">SMART Calculation - Appraiser {{ idx + 1 }}</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Participant</th>
                            <th>K1 (Fashah)</th>
                            <th>K2 (Tajweed)</th>
                            <th>K3 (Voice)</th>
                            <th>K4 (Song)</th>
                            <th>SMART Score</th>
                            <th>Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="res in results" :key="res.participant.id">
                            <td>{{ res.participant.name }}</td>
                            <td>{{ formatNumber(res.appraiser_details[appId]?.smart_details?.K1?.weighted_score || 0) }}</td>
                            <td>{{ formatNumber(res.appraiser_details[appId]?.smart_details?.K2?.weighted_score || 0) }}</td>
                            <td>{{ formatNumber(res.appraiser_details[appId]?.smart_details?.K3?.weighted_score || 0) }}</td>
                            <td>{{ formatNumber(res.appraiser_details[appId]?.smart_details?.K4?.weighted_score || 0) }}</td>
                            <td style="font-weight: 700;">{{ formatNumber(res.appraiser_details[appId]?.smart_score || 0) }}</td>
                            <td style="font-weight: 700;">{{ res.appraiser_details[appId]?.rank }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Borda Point Conversion Table -->
            <div class="glass" style="padding: 2rem; margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem;">Borda Point Conversion</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Participant</th>
                            <th v-for="(appId, idx) in appraisers" :key="appId">
                                Rank J{{ idx + 1 }} (Points)
                            </th>
                            <th style="background: rgba(251,191,36,0.2);">Total Points</th>
                            <th style="background: rgba(251,191,36,0.2);">Final Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="res in results" :key="res.participant.id" :style="{ background: res.final_rank === 1 ? 'rgba(251, 191, 36, 0.1)' : 'transparent' }">
                            <td>{{ res.participant.name }}</td>
                            <td v-for="(appId, idx) in appraisers" :key="appId">
                                {{ res.appraiser_details[appId]?.rank }} ({{ res.appraiser_details[appId]?.borda_points }})
                            </td>
                            <td style="font-weight: 700; font-size: 1.2rem;">{{ res.total_borda_score }}</td>
                            <td>
                                <div :style="{
                                    width: '32px', height: '32px', 
                                    background: res.final_rank <= 3 ? 'linear-gradient(135deg, #ffd700, #f59e0b)' : 'rgba(255,255,255,0.1)',
                                    borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center',
                                    fontWeight: 'bold', color: res.final_rank <= 3 ? 'black' : 'white'
                                }">
                                    {{ res.final_rank }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Final Leaderboard -->
            <div class="glass" style="padding: 2rem;">
                <h3 style="margin-bottom: 1rem;">🏆 Final Leaderboard</h3>
                <table>
                    <thead>
                        <tr>
                            <th width="10%">Rank</th>
                            <th>Participant</th>
                            <th>Total Borda Points</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="res in results" :key="res.participant.id" :style="{ background: res.final_rank === 1 ? 'rgba(251, 191, 36, 0.15)' : 'transparent' }">
                            <td>
                                <div :style="{
                                    width: '40px', height: '40px', 
                                    background: res.final_rank <= 3 ? 'linear-gradient(135deg, #ffd700, #f59e0b)' : 'rgba(255,255,255,0.1)',
                                    borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center',
                                    fontWeight: 'bold', color: res.final_rank <= 3 ? 'black' : 'white',
                                    boxShadow: res.final_rank === 1 ? '0 0 20px rgba(251, 191, 36, 0.6)' : 'none'
                                }">
                                    {{ res.final_rank }}
                                </div>
                            </td>
                            <td style="font-weight: 600; font-size: 1.1rem;">{{ res.participant.name }}</td>
                            <td style="font-size: 1.5rem; font-weight: 700;">{{ res.total_borda_score }}</td>
                            <td>
                                <span v-if="res.final_rank === 1" style="background: linear-gradient(135deg, #ffd700, #f59e0b); color: black; padding: 4px 12px; border-radius: 4px; font-weight: 700;">🏆 Winner</span>
                                <span v-else-if="res.final_rank === 2" style="background: #c0c0c0; color: black; padding: 4px 12px; border-radius: 4px;">🥈 Runner Up</span>
                                <span v-else-if="res.final_rank === 3" style="background: #cd7f32; color: white; padding: 4px 12px; border-radius: 4px;">🥉 3rd Place</span>
                                <span v-else style="color: var(--text-muted);">Participant</span>
                            </td>
                            <td>
                                <Link :href="`/reports/${res.participant.id}`" class="btn-primary" style="padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">View Detail</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else class="glass" style="padding: 2rem;">
            <p>No active period found.</p>
        </div>
    </AppLayout>
</template>
