<template>
  <div class="p-3 flex justify-center bg-white">
    <!-- Card 2 -->
    <card class="border-gray-300 border-2 rounded-xl py-7 px-5">
    <div v-if="form.loading" class="flex justify-center">Loading...</div>
    <form @submit.prevent="submitForm" v-else >
      <div class="grid grid-cols-6 gap-3">
        <!-- Description -->
        <div class="col-span-4">
          <p class="text-gray-700 font-bold">{{ form.data.title }}</p>
          <p class="text-gray-500 mt-4">{{ form.data.description }}</p>
        </div>

        <!-- Image -->
        <div class="col-span-2 shadow-lg">
          <img :src="form.data.image_url" />
        </div>

        <!-- <pre>{{form.data.questions}} </pre> -->
      </div>
              <hr class="my-3" />

      <div
        v-if="formFinished"
        class="py-8 px-6 bg-emerald-400 text-white w-[600px] mx-auto"
      >
        <div class="text-xl mb-3 font-semibold">
          Thank you for participating in this form.
        </div>
        <button
          @click="submitAnotherResponse"
          type="button"
          class="
            inline-flex
            justify-center
            py-2
            px-4
            border border-transparent
            shadow-sm
            text-sm
            font-medium
            rounded-md
            text-white
            bg-indigo-600
            hover:bg-indigo-700
            focus:outline-none
            focus:ring-2
            focus:ring-offset-2
            focus:ring-indigo-500
          "
        >
          Submit another response
        </button>
      </div>
      <div v-else>
        <div
          v-for="(question, index) in form.data.questions"
          :key="question.id"
        >
          <AnswerView
            v-model="answers[question.id]"
            :question="question"
            :index="index"
          />
        </div>
           <button
          type="submit"
          class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Submit
        </button>
      </div>
    </form>
    </card>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
// import store from  "../store";
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import AnswerView from "../components/Answer/AnswerView.vue";
const route = useRoute();
const store = useStore();
const form = computed(() => store.state.currentForm);
store.dispatch("viewCurrentForm", route.params.slug).then((res) => {});

const formFinished = ref(false);
const answers = ref({});
function submitForm() {
  console.log(JSON.stringify(answers.value, undefined, 2));
  console.log('form::::',form.value);
  store
    .dispatch("saveFormAnswer", {
      formId: form.value.data.id,
      answers: answers.value,
    })
    .then((response) => {
      if (response.status === 201) {
        formFinished.value = true;
      }
    });
}
function submitAnotherResponse() {
  answers.value = {};
  formFinished.value = false;
}
</script>

