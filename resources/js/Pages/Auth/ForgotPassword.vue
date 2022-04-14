<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-4 text-sm text-gray-800">
            <span class="text-semibold font-semibold">Forgot your password? </span>
            <br><br>No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="email" value="Email" :class="$formClasses.label" />
                <BreezeInput id="email" type="email" :class="$formClasses.textInput" v-model="form.email" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 mr-4">
                    Login Now?
                </Link>

                <BreezeButton :class="[(form.processing)?'opacity-25':'', $formClasses.submitBtn]" :disabled="form.processing">
                    Get Link <biorev-icon icon="external-link" class-name="w-4 h-4 mx-1" />
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
