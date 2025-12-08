<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <div class="layout-container">
        <aside v-if="user" class="sidebar glass">
            <div style="margin-bottom: 2rem;">
                <h1 style="font-size: 1.5rem; font-weight: 700; background: linear-gradient(to right, #4f46e5, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">MTQ System</h1>
            </div>
            <nav>
                <Link href="/dashboard" class="nav-link" :class="{ 'active': $page.url === '/dashboard' }">
                    Dashboard
                </Link>
                
                <template v-if="user.role === 'committee'">
                    <Link href="/users" class="nav-link" :class="{ 'active': $page.url.startsWith('/users') }">Users</Link>
                    <Link href="/participants" class="nav-link" :class="{ 'active': $page.url.startsWith('/participants') }">Participants</Link>
                    <Link href="/criteria" class="nav-link" :class="{ 'active': $page.url.startsWith('/criteria') }">Criteria</Link>
                    <Link href="/reports" class="nav-link" :class="{ 'active': $page.url.startsWith('/reports') }">Reports</Link>
                </template>
                
                <template v-else>
                    <Link href="/assessments" class="nav-link" :class="{ 'active': $page.url.startsWith('/assessments') }">Rate Participants</Link>
                    <a href="#" class="nav-link">My Profile</a>
                </template>
                
                <Link href="/logout" method="post" as="button" class="nav-link" style="margin-top: auto; background:none; border:none; width:100%; cursor:pointer; text-align: left;">
                    Logout
                </Link>
            </nav>
        </aside>

        <main class="content">
            <slot />
        </main>
    </div>
</template>
