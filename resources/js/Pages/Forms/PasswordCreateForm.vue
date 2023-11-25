<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import MySelect from "@/Components/MySelect.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";

const projects = usePage().props.projects
const project = usePage().props.project

const note = ref('')
const digitsCount = ref(11)

const password = ref(usePage().props.password).value

const form = useForm({
    id: password.id ?? null,
    project: password.project ? password.project.name : project ? project.name : null,
    login: password.login ?? null,
    password: password.password ?? null
})

const generatePassword = () =>{
    axios.get(route('generate.password', {digits: digitsCount.value}))
        .then(res => {
          note.value = 'Для изменений нажмите кнопку "Сохранить"'
            form.password = res.data.password
        })
}

const setProject = (el) =>{
    form.project = el
    // console.log(el)
}

const updateOrCreatePassword = () =>{
    form.post(route('store.password'), {
        onError: () => {
            console.log(form.errors)
        }
    })
}

</script>

<template>
    <AppLayout>
        <div class="flex justify-center items-center h-full">
            <form @submit.prevent="updateOrCreatePassword" >
                <h2 class="text-center text-2xl">Создание/Редактирование пароля</h2>
              <p>Проект: </p>
              <div class="mt-5">
                <MySelect @selectedEvent="setProject" :value="form.project" :data="projects.map(project=>project.name)"></MySelect>
              </div>
                <div class="mt-5">
                    <InputLabel>Логин</InputLabel>
                    <TextInput v-model="form.login" name="login" placeholder="Login" class="w-full"></TextInput>
                    <InputLabel class="mt-3">Пароль</InputLabel>
                    <TextInput v-model="form.password" name="password" placeholder="Password" class="w-full "></TextInput>
                  <div v-if="note">
                    <p class="text-sm text-red-600">{{note}}</p>
                  </div>
                    <h4 class="text-center mt-5 text-lg"> Сгенерировать пароль</h4>
                    <div class="mt-3 flex items-end justify-between">
                        <div class="">
                            <InputLabel>Кол-во символов</InputLabel>
                            <TextInput v-model="digitsCount" min="6" type="number" placeholder="Кол-во символов"></TextInput>
                        </div>
                        <div class="">
                            <a href="#" @click.prevent="generatePassword" class="bg-indigo-500 text-white py-2 px-4 rounded-xl">Generate</a>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded-xl">Сохранить</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
