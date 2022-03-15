<template>
  <!-- Question title -->
  <div class="flex justify-between items-center">
    <h3 class="font-bold">{{ index + 1 }}-{{ model.question }}</h3>
    <!-- <pre>{{model}}</pre> -->
    <!-- buttons add delete -->
    <div class="flex items-center">
      <button
        class="
          mr-2
          flex
          items-center
          bg-green-700
          text-white
          sm:p-2
          rounded-md
          sm:text-sm
          font-medium
          hover:bg-green-500
          transition
          duration-300
        "
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
        Add
      </button>
      <button
        class="
          flex
          items-center
          bg-red-700
          text-white
          sm:p-2
          rounded-md
          sm:text-sm
          font-medium
          hover:bg-red-500
          transition
          duration-300
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
          />
        </svg>
        delete
      </button>
    </div>
    <!-- /buttons add delete -->
  </div>
  <!-- /Question title -->

  <!--  -->
  <div class="grid grid-cols-12 gap-6 mt-4">
    <div class="md:col-span-9 col-span-12">
      <label for="question" class="block text-sm font-medium text-gray-700"
        >Question title:</label
      >
      <input
        v-model="model.question"
        type="text"
        name="question"
        id="question"
        @change="dataChange"
        class="
          mt-1
          focus:ring-indigo-500 focus:border-indigo-500
          block
          w-full
          shadow-sm
          sm:text-sm
          border-gray-300
          rounded-md
        "
      />
    </div>

    <div class="md:col-span-3 col-span-12">
      <label for="last-name" class="block text-sm font-medium text-gray-700"
        >Question type:</label
      >
      <select
        v-model="model.type"
         @change="typeChange"
        id="type"
        name="type"
       
        class="
          mt-1
          block
          w-full
          py-2
          px-3
          border border-gray-300
          bg-white
          rounded-md
          shadow-sm
          focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
          sm:text-sm
        "
      >
       <option v-for="type in questionTypes" :key="type" :value="type" >
          {{ type }}
        </option>
      </select>
    </div>
     <div class="col-span-12">
                <label for="about" class="block text-sm font-medium text-gray-700"> Description : </label>
                <div class="mt-1">
                  <textarea 
                  v-model="model.description"
                  id="about" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="you@example.com" />
                </div>
              </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
const props = defineProps({
  question: Object,
  index: Number,
});
const emit = defineEmits(["change", "addQuestion", "deleteQuestion"]);
const model = ref(JSON.parse(JSON.stringify(props.question)));
const questionTypes=['Text','Select','TextArea','List'];
</script>

<style>
</style>