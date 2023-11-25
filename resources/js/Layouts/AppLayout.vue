<script setup>
import {ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";

const isAuth = ref(usePage().props.auth.user !== null)
const isAdmin = usePage().props.auth.user.role
const user = usePage().props.auth.user
const logout = () =>{
    axios.post(route('logout'))
        .then(window.location.href = route('login')).catch(res=>{
        console.log(res.errors)
    })
}
</script>

<template class="">
    <div class="">
        <div class="sticky">
            <nav class=" bg-sky-500 p-4 flex items-center justify-between ">
                <div>
                    <h1 class="text-white text-xl font-semibold">Password storage</h1>
                </div>
                <div class="flex gap-4">
                    <div v-if="isAuth" class="flex items-center space-x-4">
                        <div>
                            <button @click.prevent="logout" type="submit" class="text-white">Выйти</button>
                        </div>
                        <i class="fas fa-user-circle text-white text-2xl"></i>
                    </div>
                    <div v-if="!isAuth" class="flex items-center space-x-4">
                        <div>
                            <a :href="route('login')" type="submit" class="text-white">Войти</a>
                        </div>
                        <i class="fas fa-user-circle text-white text-2xl"></i>
                    </div>
                </div>
            </nav>
        </div>
        <div class="mx-auto max-w-5xl w-3/4 flex  overflow-hidden">
            <div>
                <aside class="bg-gray-800 text-white w-64 min-h-screen p-4">
            <nav>
                <ul class="space-y-2">
                    <li class="opcion-con-desplegable">
                        <div  class="flex items-center justify-between p-2 hover:bg-gray-700">
                            <div class="flex items-center">
                                <p>User: id: {{user.id}} email: {{user.email}}</p>
                            </div>
                        </div>
                    </li>
                    <li class="opcion-con-desplegable">
                        <a :href="route('admin.projects.index')" class="flex items-center justify-between p-2 hover:bg-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>Проекты</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </a>
                    </li>
                    <li v-if="isAdmin" class="opcion-con-desplegable">
                        <a :href="route('admin.users')" class="flex items-center justify-between p-2 hover:bg-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>Пользователи</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </a>
                    </li>
                    <li class="opcion-con-desplegable">
                        <a :href="route('home')" class="flex items-center justify-between p-2 hover:bg-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>Пароли</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            </aside>
            </div>
            <div class="w-full bg-gray-100 h-screen overflow-y-auto">
                <slot/>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
