<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import MySelect from "@/Components/MySelect.vue";

const passwords = ref(usePage().props.passwords)
const projects = usePage().props.projects

const search = (el) =>{
    axios.get(route('home', {projects: el ?? 'none'}))
        .then(res =>{
            // console.log(res.data.passwords)
            passwords.value = res.data.passwords
        })
}

</script>
<template>
    <AppLayout>
            <div class="p-4">
                <p class="text-3xl text-center">Passwords</p>
            </div>
            <div class="text-right px-4 flex justify-between">
                <MySelect class="w-96" @clear="search"  @selectedEvent="search" :data="projects.map(project=>project.name)" :mode="'tags'"></MySelect>
                <a :href="route('create.password')" class="bg-indigo-500 py-2 px-4 rounded-xl text-white">Добавить пароль</a>
            </div>
            <div class="flex justify-center mt-5 mb-5 ">
                <table class="table-auto w-3/4">
                    <thead>
                    <tr>
                        <th>Проекты</th>
                        <th>Логин</th>
                        <th>Пароль</th>
                        <th>Редактировать</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="password in passwords">
                        <td><a class="text-sky-700" :href="route('project.show', password.project.id)">{{password.project.name}}</a></td>
                        <td class="">{{password.login}}</td>
                        <td>{{password.password}}</td>
                        <td class="text-center">
                            <div class=" flex justify-center">
                                <a  :href="route('create.password', {password:password.id})" class="text-sky-500">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
    </AppLayout>
</template>

<style scoped>

</style>
