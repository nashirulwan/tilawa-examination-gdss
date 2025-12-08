<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    criteria: Array,
});

const form = useForm({
    code: '',
    name: '',
    weight: '',
});

const editingId = ref(null);
const editForm = useForm({
    code: '',
    name: '',
    weight: '',
});

const submit = () => {
    form.post('/criteria', {
        onSuccess: () => form.reset(),
    });
};

const startEdit = (c) => {
    editingId.value = c.id;
    editForm.code = c.code;
    editForm.name = c.name;
    editForm.weight = c.weight;
};

const updateCriteria = (id) => {
    editForm.put(`/criteria/${id}`, {
        onSuccess: () => {
            editingId.value = null;
        }
    });
};

const cancelEdit = () => {
    editingId.value = null;
};

const deleteCriteria = (id) => {
    if (confirm('Are you sure?')) {
        router.delete(`/criteria/${id}`);
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
                            <template v-if="editingId === c.id">
                                <td><input v-model="editForm.code" type="text" style="width: 60px; padding: 4px;"></td>
                                <td><input v-model="editForm.name" type="text" style="width: 100%; padding: 4px;"></td>
                                <td><input v-model="editForm.weight" type="number" style="width: 80px; padding: 4px;"></td>
                                <td>
                                    <button @click="updateCriteria(c.id)" style="color: #10b981; background: none; border: none; cursor: pointer; margin-right: 0.5rem;">Save</button>
                                    <button @click="cancelEdit" style="color: #6b7280; background: none; border: none; cursor: pointer;">Cancel</button>
                                </td>
                            </template>
                            <template v-else>
                                <td>{{ c.code }}</td>
                                <td>{{ c.name }}</td>
                                <td>{{ c.weight }}</td>
                                <td style="display: flex; gap: 0.5rem;">
                                    <button @click="startEdit(c)" style="padding: 6px 12px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border-radius: 6px; border: none; cursor: pointer; font-size: 0.8rem;">Edit</button>
                                    <button @click="deleteCriteria(c.id)" style="padding: 6px 12px; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.8rem;">Delete</button>
                                </td>
                            </template>
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
