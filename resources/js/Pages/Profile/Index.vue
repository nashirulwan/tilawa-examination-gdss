<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';

defineProps({
    user: Object
});
</script>

<template>
    <AppLayout>
        <h2 style="margin-bottom: 2rem; font-weight: 700;">My Profile</h2>
        
        <div class="glass" style="padding: 2rem; max-width: 600px;">
            <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; color: white;">
                    {{ user.name.charAt(0).toUpperCase() }}
                </div>
                <div>
                    <h3 style="margin: 0 0 0.25rem 0;">{{ user.name }}</h3>
                    <p style="margin: 0; color: var(--text-muted);">{{ user.email }}</p>
                </div>
            </div>
            
            <div style="border-top: 1px solid var(--glass-border); padding-top: 1.5rem;">
                <div style="display: grid; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">Role</span>
                        <span style="font-weight: 600; text-transform: capitalize;">{{ user.role }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">Status</span>
                        <span :style="{ fontWeight: 600, color: user.is_active ? '#10b981' : '#ef4444' }">
                            {{ user.is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">Member Since</span>
                        <span style="font-weight: 600;">{{ new Date(user.created_at).toLocaleDateString() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
