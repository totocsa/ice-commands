<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import IceLayout from '@IceDatabaseTranslationLocally/Layouts/IceLayout.vue'
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import LocalTranslationHeader from '@IceDatabaseTranslationLocally/Components/LocalTranslation/LocalTranslationHeader.vue'

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};

const titleArray = ['Authentication', 'Forgot password']
</script>

<template>

    <Head title="Forgot Password" />

    <IceLayout :title="titleArray" :authUser="$page.props.auth.user">
        <template #header>
            <LocalTranslationHeader :titleArray="titleArray" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <AuthenticationCard>
                        <div class="mb-4 text-sm text-gray-600">
                            Forgot your password? No problem. Just let us know your email address and we will email you
                            a
                            password reset link that will allow you to choose a new one.
                        </div>

                        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                            {{ status }}
                        </div>

                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full"
                                    required autofocus autocomplete="username" />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Email Password Reset Link
                                </PrimaryButton>
                            </div>
                        </form>
                    </AuthenticationCard>
                </div>
            </div>
        </div>
    </IceLayout>
</template>
