<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

const project = usePage().props.project
const passwords = usePage().props.passwords
const message = ref('')
const isAdmin = usePage().props.auth.user.role
const user = usePage().props.auth.user

const hasAccess = () => {

    console.log(project.user_id)
    if(isAdmin){
        return true
    }
    return project.user_id === user.id
};

console.log(hasAccess())
const deletePassword = (password, index) =>{
    axios.delete(route('delete.password', password.id))
        .then(res=>{
            message.value = res.data.message
        })
    passwords.splice(index, 1)
}
</script>

<template>
    <AppLayout>
        <div class="flex justify-center mt-5 h-full">
            <div class="w-3/4">
                <h2 class="text-2xl text-center">Проект: {{project.name}}</h2>
                <div class="flex gap-4 justify-end my-3">
                    <a :href="route('create.password', {project: project.id})" class="text-sm bg-indigo-500 py-2 px-4 rounded-xl text-white">Добавить пароль</a>
                    <a v-if="hasAccess()" :href="route('project.user.access', project.id)" class="text-sm bg-indigo-500 py-2 px-4 rounded-xl text-white">Управление доступом</a>
                </div>
                <div v-if="message">
                    <p class="mt-3 text-sm text-red-600">{{message}}</p>
                </div>
                <div v-if="passwords.length > 0" class="flex justify-center  mt-3">
                    <table class="table-auto w-full">
                        <thead >
                        <tr>
                            <th>Логин</th>
                            <th>Пароль</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        </thead>
                        <tbody >
                        <tr v-for="(password, index) in passwords">
                            <td class="mt-5"><a>{{password.login}}</a></td>
                            <td class=""><a>{{password.password}}</a></td>
                            <td class="text-center">
                                <div class=" flex justify-center">
                                    <a  href="#" @click.prevent="" class="text-sky-500">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                            </svg>
                                        </i>
                                    </a>
                                </div>
                            </td>
                            <td class="text-sky-700 ">
                                <div class="flex justify-center">
                                    <a href="#" @click.prevent="deletePassword(password, index)" class="text-red-500">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="passwords.length <= 0" class="text-center text-3xl text-sky-700 mt-5">В этом проекте нет записей</div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
