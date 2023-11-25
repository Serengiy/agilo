<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import {r} from "../../../../public/build/assets/app-6316c137.js";
const users =usePage().props.users
const modalIsOn = ref(false)
const userToDelete = ref({
    index: null,
    id:null
})
const message = ref('')
const modalCall = (user, index) =>{
    userToDelete.value.id = user.id
    userToDelete.value.index = index
    modalIsOn.value = true
}

const deleteUser = () => {
    axios.delete(route('user.delete', userToDelete.value.id))
        .then(res => {
            users.splice(userToDelete.value.index, 1)
            message.value = res.data.message
            modalIsOn.value = false
            console.log(message.value)
        })
}
</script>

<template>
    <AppLayout>
        <Modal :show="modalIsOn" @close="modalIsOn = false">
            <div class="py-5 text-center">
                <div class="flex justify-center">
                    <h2 class=" text-2xl text-center w-96">Вы уверены, что хотите удалить пользователя?</h2>
                </div>
                <div class="flex justify-center gap-6 mt-5">
                    <button @click.prevent="modalIsOn=false" class="py-2 px-4 bg-sky-700 rounded-xl text-white">Отмена</button>
                    <button @click.prevent="deleteUser" class="py-2 px-4 bg-red-700 rounded-xl text-white">Удалить</button>
                </div>
            </div>
        </Modal>
        <div class="p-4">
            <p class="text-3xl text-center">Пользователи</p>
        </div>
        <div class="text-right px-4">
            <a :href="route('create.user.form')" class="bg-indigo-500 py-2 px-4 rounded-xl text-white">Добавить пользователя</a>
        </div>
        <div v-if="message" class="text-center text-red-700 my-3">
            {{message}}
        </div>
        <div class="flex justify-center mt-5">
            <table class="table-auto w-3/4">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(user, index) in users">

                    <td><a class="text-sky-700" :href="route('user.show', user.id)">{{user.name}}</a></td>
                    <td>{{user.email}}</td>
                    <td>
                        <div class="flex justify-center">
                            <a href="#" @click.prevent="modalCall(user, index)" class="text-red-500">
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
    </AppLayout>
</template>

<style scoped>

</style>
