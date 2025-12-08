<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';

defineProps({
    stats: Object,
});
</script>

<template>
    <AppLayout>
        <h2 style="margin-bottom: 2rem; font-weight: 700;">Dashboard</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <!-- Widget 1 -->
            <div class="glass" style="padding: 1.5rem;">
                <p style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase;">Participants</p>
                <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ stats.participants }}</h3>
                <p style="color: #10b981; font-size: 0.875rem;">+2 this week</p>
            </div>
            
            <!-- Widget 2 -->
            <div class="glass" style="padding: 1.5rem;">
                <p style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase;">Appraisers</p>
                <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ stats.appraisers }}</h3>
                <p style="color: var(--text-muted); font-size: 0.875rem;">Active</p>
            </div>
            
            <!-- Widget 3 -->
            <div class="glass" style="padding: 1.5rem;">
                <p style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase;">Assessment Status</p>
                <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ stats.completion }}%</h3>
                <p style="color: #10b981; font-size: 0.875rem;">Completed</p>
            </div>
        </div>

        <div class="glass" style="padding: 2rem;">
            <h3 style="margin-bottom: 1.5rem;">Recent Activity</h3>
            <p style="color: var(--text-muted);">System initialized with journal data. (Vue.js Version)</p>
        </div>
    </AppLayout>
</template>
