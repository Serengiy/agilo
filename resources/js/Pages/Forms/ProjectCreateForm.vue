<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    name: ''
})

const projectStore = () => {
    // axios.post(route('project.store'), {project: project})
}

</script>

<template>
    <AppLayout>
        <div class="flex justify-center items-center h-full">
            <div>
                <h2 class="text-2xl text-center">Новый проект</h2>
                <form @submit.prevent="form.post(route('project.store'))" class="mt-5 flex flex-col gap-3">
                    <TextInput name="project" v-model="form.name" aria-placeholder="Project"></TextInput>
                    <div v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</div>
                    <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded-xl">Создать</button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
