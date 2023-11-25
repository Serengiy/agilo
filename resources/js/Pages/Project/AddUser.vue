<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import {usePage} from "@inertiajs/vue3";
const project = usePage().props.project
const users = usePage().props.users

const toggleUser = (project, user) =>{
    let checkbox = event.target.checked
    axios.post(route('project.toggle',[project, user]))
        .then()
}

</script>

<template>
    <AppLayout>
        <div class="flex justify-center mt-5 h-full">
            <div class="w-3/4">
                <h2 class="text-2xl text-center">Проект: {{project.name}}</h2>
                <p class="mt-3">Пользователи:</p>
                <div class="flex  justify-center mt-5">
                    <table class="table-auto">
                        <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Доступ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users">
                            <td class="text-sky-700">{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input @change="toggleUser(project.id, user.id)"  type="checkbox" :checked="user.isAttached" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
