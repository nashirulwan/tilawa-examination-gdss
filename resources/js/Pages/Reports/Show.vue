<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    participant_id: String,
    // data: Object // Detailed calculation data would be passed here
});
</script>

<template>
    <AppLayout>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-weight: 700; margin: 0;">Calculation Details</h2>
            <Link href="/reports" style="color: var(--text-muted); text-decoration: none;">&larr; Back to Rankings</Link>
        </div>

        <div class="glass" style="padding: 2rem;">
            <h3>Detail for Participant ID: {{ participant_id }}</h3>
            <p style="color: var(--text-muted); margin-top: 1rem;">
                This view is a placeholder for the breakdown of SMART normalization, utility values, and Borda point assignment steps.
            </p>
            
            <div style="margin-top: 2rem; padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 8px;">
                <p><strong>Step 1: Normalization</strong></p>
                <p>Formula: (Cmax - Cout) / (Cmax - Cmin) ...</p>
                <br>
                <p><strong>Step 2: Utility Calculation</strong></p>
                <p>Formula: 100 * Normalization</p>
                <br>
                <p><strong>Step 3: Borda Points</strong></p>
                <p>Rank converted to points based on N-1 rules...</p>
            </div>
        </div>
    </AppLayout>
</template>
