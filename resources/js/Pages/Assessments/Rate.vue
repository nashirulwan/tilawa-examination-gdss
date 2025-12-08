<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    participant: Object,
    criteria: Array,
    assessments: Object,
});

// Initialize form dynamically based on criteria
const initialForm = {};
props.criteria.forEach(c => {
    initialForm[`criteria_${c.id}`] = props.assessments[c.id] ? props.assessments[c.id].value : null;
});

const form = useForm(initialForm);

const submit = () => {
    form.post(`/assessments/${props.participant.id}`);
};
</script>

<template>
    <AppLayout>
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-weight: 700; margin: 0;">Rate: {{ participant.name }}</h2>
                <Link href="/assessments" style="color: var(--text-muted); text-decoration: none;">Back to List</Link>
            </div>

            <div class="glass" style="padding: 2rem;">
                <form @submit.prevent="submit">
                    <div style="display: grid; gap: 2rem;">
                        <div v-for="c in criteria" :key="c.id" style="border-bottom: 1px solid var(--glass-border); padding-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                                <label style="font-weight: 600; font-size: 1.1rem;">{{ c.name }} ({{ c.code }})</label>
                                <span style="background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Weight: {{ c.weight }}</span>
                            </div>

                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                                <label v-for="sc in c.sub_criteria" :key="sc.id" 
                                    style="display: flex; align-items: center; padding: 1rem; border: 1px solid var(--glass-border); border-radius: 8px; cursor: pointer; transition: 0.2s;"
                                    :style="{ borderColor: form[`criteria_${c.id}`] == sc.value ? 'var(--primary)' : 'var(--glass-border)', background: form[`criteria_${c.id}`] == sc.value ? 'rgba(79, 70, 229, 0.1)' : 'transparent' }"
                                >
                                    <input type="radio" 
                                        :name="`criteria_${c.id}`" 
                                        :value="sc.value" 
                                        v-model="form[`criteria_${c.id}`]"
                                        style="width: auto; margin-right: 0.5rem;"
                                        required>
                                    <div>
                                        <div style="font-weight: 500;">{{ sc.name }}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">Value: {{ sc.value }}</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 2rem; text-align: right;">
                        <button type="submit" class="btn-primary" style="font-size: 1.1rem; padding: 1rem 3rem;" :disabled="form.processing">Submit Assessment</button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
