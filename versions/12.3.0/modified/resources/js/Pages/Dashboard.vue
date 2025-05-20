<script setup>
import { Link } from '@inertiajs/vue3';
import IceLayout from '@IceDatabaseTranslationLocally/Layouts/IceLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import ControllerMenu from "@IceIcseusd/Components/totocsa/Icseusd/ControllerMenu.vue"
import LocalTranslation from '@IceDatabaseTranslationLocally/Components/totocsa/LocalTranslation/LocalTranslation.vue';

const props = defineProps({
    userRoles: Object,
});

const controllerMenuLink = ["inline-block", "m-1", "first:ml-0", "last:mr-0", "px-2", "py-1", "rounded"]
const controllerMenuLinkActive = controllerMenuLink.concat(["bg-gray-200"])
</script>

<template>
    <IceLayout title="Dashboard" :authUser="$page.props.auth.user">
        <template #header>
            <ControllerMenu :userRoles="props.userRoles" groupName="default" active="dashboard">
                <Link :href="route('appRoot')" :class="controllerMenuLink">
                <LocalTranslation category="ControllerMenu-item" subtitle="Welcome" />
                </Link>

                <Link id="dashboard" :href="route('dashboard')" :class="controllerMenuLinkActive">
                <LocalTranslation category="ControllerMenu-item" subtitle="Dashboard" />
                </Link>

                <Link :href="route('profile.show')" :class="controllerMenuLink">
                <LocalTranslation category="ControllerMenu-item" subtitle="Profile" />
                </Link>
            </ControllerMenu>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </IceLayout>
</template>
