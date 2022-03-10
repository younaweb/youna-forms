<template>
 <page-component>
 <template v-slot:header>
 <h1  class="text-3xl font-bold text-gray-900">
 {{route.params.id? model.title:'Create Form'}}
 </h1>
<button v-if="route.params.id" class="bg-red-500 flex text-white px-32 py-3 rounded-md text-1xl font-medium hover:bg-red-700 transition duration-300">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
</svg>
delete form
</button>
 </template>
 </page-component>
</template>

<script setup>
import PageComponent from '../components/PageComponent.vue'
import { ref } from 'vue';
import { useRouter,useRoute} from 'vue-router'
const route=useRoute()
const router=useRouter()

// Create empty survey
let model = ref({
  title: "",
  slug: "",
  status: false,
  description: null,
  image: null,
  image_url: null,
  expire_date: null,
  questions: [],
});

</script>

<style>

</style>