<template>
  <!-- Question title -->
  <div class="flex justify-between items-center">
    <h3 class="font-bold">{{ index + 1 }}-{{ model.question }}</h3>
    <!-- <pre>{{model}}</pre> -->
    <!-- buttons add delete -->
    <div class="flex items-center">
      <button
        @click.prevent="addQuestion()"
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
        @click="deleteQuestion()"
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
        <option v-for="type in questionTypes" :key="type" :value="type">
          {{ type }}
        </option>
      </select>
    </div>
    <!-- decsription -->
    <div class="col-span-12">
      <label for="about" class="block text-sm font-medium text-gray-700">
        Description :
      </label>
      <div class="mt-1">
        <textarea
          v-model="model.description"
          @change="dataChange()"
          id="about"
          name="description"
          rows="3"
          class="
            shadow-sm
            focus:ring-indigo-500 focus:border-indigo-500
            mt-1
            block
            w-full
            sm:text-sm
            border border-gray-300
            rounded-md
          "
          placeholder="you@example.com"
        />
      </div>
    </div>
    <!--/ decsription -->
    <!-- Data options -->
    <div v-if="shouldHaveOptions()" class="col-span-12">
      <div class="mt-2 flex justify-between items-center mb-4">
        <h3>Options</h3>
        <button
          @click.prevent="addOption()"
          class="
            flex
            items-center
            bg-gray-700
            text-white
            sm:p-2
            rounded-md
            text-sm
            font-medium
            hover:bg-gray-500
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
          Add Option
        </button>
      </div>
      <div v-if="!model.data.options">You don't have any options yet !</div>
      <!-- options list -->
      <div
        v-for="(option, index) in model.data.options"
        :key="option.uuid"
        class="flex"
      >
      <span class="font-bold mr-2">{{index+1}}-</span>
      <input type="text"
      v-model="option.text"
      @change="dataChange"
      class="w-full mb-1 rounded-sm py-1 px-2 text-xs border border-gray-300 focus:border-indigo-500">
      <!-- delete option -->
      <button
          type="button"
          @click="removeOption(option)"
          class="
            h-6
            w-6
            rounded-full
            flex
            items-center
            justify-center
            border border-transparent
            transition-colors
            hover:border-red-100
          "
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-3 w-3 text-red-500"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      <!-- /delete option -->
      </div>
      <!-- /options list -->
    </div>
    <!-- /Data options -->
  </div>
</template>

<script setup>
import { ref,computed } from "vue";
import {v4 as uuidv4} from "uuid"
import store from "../../store"
const props = defineProps({
  question: Object,
  index: Number,
});
const emit = defineEmits(["change", "addQuestion", "deleteQuestion"]);
const model = ref(JSON.parse(JSON.stringify(props.question)));
const questionTypes = computed(()=>store.state.questionTypes);

function getOptions() {
  return model.value.data.options;
}
function setOptions(options) {
  model.value.data.options = options;
}
// Check if the question should have options
function shouldHaveOptions() {
  return ["select", "radio", "checkbox"].includes(model.value.type);
}
// Add option
function addOption() {
  setOptions([
    ...getOptions(),
    { uuid: uuidv4(), text: "" },
  ]);
  dataChange();
}
// Remove option
function removeOption(op) {
  setOptions(getOptions().filter((opt) => opt !== op));
  dataChange();
}
function typeChange() {
  if (shouldHaveOptions()) {
    setOptions(getOptions() || []);
  }
  dataChange();
}
// Emit the data change
function dataChange() {
  const data = JSON.parse(JSON.stringify(model.value));
  if (!shouldHaveOptions()) {
    delete data.data.options;
  }
  emit("change", data);
}
function addQuestion() {
  emit("addQuestion", props.index + 1);
}
function deleteQuestion() {
  emit("deleteQuestion", props.question);
}
</script>

<style>
</style>