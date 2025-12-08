<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'
import { Bar } from 'vue-chartjs'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

defineProps({
    stats: Object,
    demographics: Array,
    period: Object
});
</script>

<template>
    <AppLayout>
        <h2 style="margin-bottom: 2rem; font-weight: 700;">Dashboard</h2>
        
        <!-- Stats Widgets -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div class="glass" style="padding: 1.5rem;">
                <p style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase;">Active Participants</p>
                <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ stats.participants }}</h3>
                <p style="color: #10b981; font-size: 0.875rem;">Total Registered</p>
            </div>
            
            <div class="glass" style="padding: 1.5rem;">
                <p style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase;">Active Appraisers</p>
                <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ stats.appraisers }}</h3>
                <p style="color: var(--text-muted); font-size: 0.875rem;">Judges</p>
            </div>
            
            <div class="glass" style="padding: 1.5rem;">
                <p style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase;">System Status</p>
                <h3 style="font-size: 2rem; margin: 0.5rem 0;">Online</h3>
                <p style="color: #10b981; font-size: 0.875rem;">Calculations Ready</p>
            </div>
        </div>

        <!-- Demographics Graph -->
        <div class="glass" style="padding: 2rem; margin-bottom: 2rem;" v-if="demographics && demographics.length">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0;">Participant Demographics</h3>
                <span v-if="period" style="color: var(--text-muted); font-size: 0.9rem;">Period: {{ period.year }}</span>
            </div>
            <div style="height: 300px;">
                <Bar 
                    :data="{
                        labels: demographics.map(d => d.department),
                        datasets: [{
                            label: 'Participants',
                            backgroundColor: ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#a78bfa'],
                            borderRadius: 8,
                            data: demographics.map(d => d.total)
                        }]
                    }" 
                    :options="{
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { display: false }
                        },
                        scales: {
                            y: { 
                                beginAtZero: true,
                                ticks: { color: 'white', stepSize: 1 }, 
                                grid: { color: 'rgba(255,255,255,0.1)' } 
                            },
                            x: { 
                                ticks: { color: 'white' }, 
                                grid: { display: false } 
                            }
                        }
                    }" 
                />
            </div>
        </div>

        <!-- Demographics Table (fallback if no chart) -->
        <div class="glass" style="padding: 2rem;" v-else-if="demographics">
            <h3 style="margin-bottom: 1.5rem;">Participant Demographics</h3>
            <p style="color: var(--text-muted);">No active participants found.</p>
        </div>
    </AppLayout>
</template>
