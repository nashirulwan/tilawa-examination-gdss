<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    criteria: Array,
});

const form = useForm({
    code: '',
    name: '',
    weight: '',
});

const submit = () => {
    form.post('/criteria', {
        onSuccess: () => form.reset(),
    });
};

const deleteCriteria = (id) => {
    if (confirm('Are you sure?')) {
        useForm({}).delete(`/criteria/${id}`);
    }
};
</script>

<template>
    <AppLayout>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-weight: 700; margin: 0;">Criteria Management</h2>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- List -->
            <div class="glass" style="padding: 1.5rem;">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Weight</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="c in criteria" :key="c.id">
                            <td>{{ c.code }}</td>
                            <td>{{ c.name }}</td>
                            <td>{{ c.weight }}</td>
                            <td>
                                <button @click="deleteCriteria(c.id)" style="background: none; border: none; color: #ef4444; cursor: pointer;">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Add Form -->
            <div class="glass" style="padding: 1.5rem; height: fit-content;">
                <h3 style="margin-bottom: 1rem;">Add Criteria</h3>
                <form @submit.prevent="submit">
                    <div>
                        <label>Code (e.g., K5)</label>
                        <input v-model="form.code" type="text" required>
                    </div>
                    <div>
                        <label>Name</label>
                        <input v-model="form.name" type="text" required>
                    </div>
                    <div>
                        <label>Weight</label>
                        <input v-model="form.weight" type="number" required>
                    </div>
                    <button type="submit" class="btn-primary" style="width: 100%;" :disabled="form.processing">Add</button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
