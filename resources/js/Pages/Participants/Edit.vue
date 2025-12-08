<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    participant: Object,
    periods: Array,
});

const form = useForm({
    name: props.participant.name,
    gender: props.participant.gender,
    department: props.participant.department,
    period_id: props.participant.period_id,
    is_active: props.participant.is_active ?? true
});

const submit = () => {
    form.put(`/participants/${props.participant.id}`);
};
</script>

<template>
    <AppLayout>
        <div style="max-width: 600px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="margin: 0;">Edit Participant</h2>
                <Link href="/participants" style="color: var(--text-muted); text-decoration: none;">← Back</Link>
            </div>
            <div class="glass" style="padding: 2rem;">
                <form @submit.prevent="submit">
                    <div>
                        <label>Name</label>
                        <input v-model="form.name" type="text" required>
                    </div>
                    <div>
                        <label>Department</label>
                        <input v-model="form.department" type="text" required>
                    </div>
                    <div>
                        <label>Gender</label>
                        <select v-model="form.gender" style="width: 100%; padding: 12px; margin-bottom: 1rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div>
                        <label>Period</label>
                        <select v-model="form.period_id" style="width: 100%; padding: 12px; margin-bottom: 1rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; border-radius: 8px;" required>
                            <option v-for="period in periods" :key="period.id" :value="period.id">{{ period.year }}</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input v-model="form.is_active" type="checkbox" style="margin-right: 0.5rem; width: auto;">
                            Active
                        </label>
                    </div>
                    <button type="submit" class="btn-primary" :disabled="form.processing">Update Participant</button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
