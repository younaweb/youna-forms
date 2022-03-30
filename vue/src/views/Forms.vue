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
    <div v-if="forms.loading" class="flex justify-center">Loading...</div>
<div v-else-if="forms.data"  >
    <div class="flex flex-wrap -m-3"> 
    
   <form-component  v-for="(form,index) in forms.data"
      :key="form.id"
      :form="form"
      class="opacity-0 animate-fade-in-down"
      :style="{ animationDelay: `${index * 0.2}s` }"
      @delete="deleteForm(form.id)"
      />
    </div>
      <div class="flex justify-center mt-5">
        <nav
          class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
          aria-label="Pagination"
        >
          <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
          <a
            v-for="(link, i) in forms.links"
            :key="i"
            :disabled="!link.url"
            href="#"
            @click="getForPage($event, link)"
            aria-current="page"
            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
            :class="[
              link.active
                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
              i === 0 ? 'rounded-l-md bg-gray-100 text-gray-700' : '',
              i === forms.links.length - 1 ? 'rounded-r-md' : '',
            ]"
            v-html="link.label"
          >
          </a>
        </nav>
      </div>
</div>
       <div v-else class="text-gray-600 text-center py-16">
      Your don't have forms yet
    </div>
  </page-component>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import FormComponent from "../components/FormComponent.vue";
import store from "../store";
import { computed } from "vue";
import { notify } from "notiwind"




store.dispatch('getAllForms');
const forms = computed(() => store.state.forms);

function deleteForm(id){
  if(confirm('Are you sure to delete this form?')){
    store.dispatch('deleteForm',id)
    .then(()=>{
      store.commit('syncForms',id);
           notify({
       group: "foo",
       title: "Delete",
       type:"error",
        text: "Your Form was deleted succesfully 👌"
     }, 4000) 
    })
  }
}

// pagination 
function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  }
  store.dispatch("getAllForms", { url: link.url });
}

</script>

<style></style>
