<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    name: '',
    email: ''
})
</script>

<template>
    <AppLayout>
        <div class="flex justify-center items-center h-full">
            <div>
                <h2 class="text-2xl text-center">Новый пользователь</h2>
                <form @submit.prevent="form.post(route('admin.user.store'))" class="mt-5 flex flex-col gap-3">
                    <TextInput name="name" v-model="form.name" placeholder="name"></TextInput>
                    <div v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</div>
                    <TextInput name="email" v-model="form.email" placeholder="email"></TextInput>
                    <div v-if="form.errors.email" class="text-sm text-red-600">{{ form.errors.email }}</div>
                    <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded-xl">Создать</button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
