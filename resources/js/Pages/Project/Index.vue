<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
const projects =usePage().props.projects
const modalIsOn = ref(false)
const projectToDelete = ref({
  index: null,
  id:null
})
const message = ref('')
const modalCall = (project, index) =>{
  projectToDelete.value.id = project.id
  projectToDelete.value.index = index
  modalIsOn.value = true
}

const deleteProject = () =>{
  axios.delete(route('project.destroy', projectToDelete.value.id))
      .then(res => {
        projects.splice(projectToDelete.value.index, 1)
        message.value = res.data.message
        modalIsOn.value = false
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
            <button @click.prevent="deleteProject" class="py-2 px-4 bg-red-700 rounded-xl text-white">Удалить</button>
          </div>
        </div>
      </Modal>
        <div class="p-4">
            <p class="text-3xl text-center">Проекты</p>
        </div>
        <div class="text-right px-4">
            <a :href="route('create.project.form')" class="bg-indigo-500 py-2 px-4 rounded-xl text-white">Добавить проект</a>
        </div>
        <div class="flex justify-center mt-5">
            <table class="table-auto w-3/4">
                <thead>
                <tr>
                    <th>Компания</th>
                    <th>Кол-во паролей</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(project, index) in projects">
                    <td class="text-sky-700"><a  :href="route('project.show', project.id)">{{project.name}}</a></td>
                    <td class="text-center">{{project.passwords_count}}</td>
                    <td class="text-sky-700 ">
                      <div class="flex justify-center">
                        <a href="#" @click.prevent="modalCall(project, index)" class="text-red-500">
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
