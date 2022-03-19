<template>
  <page-component>
    <template v-slot:header>
      <h1 class="text-3xl font-bold text-gray-900">Forms</h1>
      <router-link
        :to="{ name: 'FormCreate' }"
        class="bg-blue-500 text-white xl:px-32 md:px-15 sm:px-4 py-3 rounded-md md:text-xl sm:text-sm font-medium hover:bg-blue-700 transition duration-300"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4 -mt-1 inline-block"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 4v16m8-8H4"
          />
        </svg>
        <span class="sm:hidden md:inline">
        New Form
        </span>
      </router-link>
    </template>
    <div class="flex flex-wrap -m-3"> 
   <form-component  v-for="form in forms.data"
      :key="form.id"
      :form="form"
      @delete="deleteForm(form.id)"
      />
    </div>
  </page-component>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import FormComponent from "../components/FormComponent.vue";
import store from "../store";
import { computed } from "vue";

store.dispatch('getAllForms');
const forms = computed(() => store.state.forms);

function deleteForm(id){
  if(confirm('Are you sure to delete this form?')){
    store.dispatch('deleteForm',id)
    .then(()=>{
      store.commit('syncForms',id);
    })
  }
}
</script>

<style></style>
