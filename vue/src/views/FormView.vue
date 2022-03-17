<template>
    <page-component>
        <template v-slot:header>
            <h1 class="text-3xl font-bold text-gray-900">
                {{ route.params.id ? model.title : "Create Form" }}
            </h1>
            <button
                v-if="route.params.id"
                @click="deleteForm(model)"
                class="bg-red-500 flex text-white px-32 py-3 rounded-md text-1xl font-medium hover:bg-red-700 transition duration-300"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
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
                delete form
            </button>
        </template>
<!-- <pre>{{model}}</pre> -->
        <!-- form -->
        <form action="" class="w-2/3 mx-auto" @submit.prevent="saveForm">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <!-- image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Photo
                        </label>
                        <div class="mt-1 flex items-center">
                            <img
                                v-if="model.image_url"
                                :src="model.image_url"
                                class="inline-block h-12 w-12 overflow-hidden bg-gray-100"
                                alt=""
                            />
                            <span
                                v-else
                                class="inline-block h-12 w-12 overflow-hidden bg-gray-100"
                            >
                                <svg
                                    class="h-full w-full text-gray-300"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
                                    />
                                </svg>
                            </span>
                            <button
                                type="button"
                                class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 relative"
                            >
                                <input
                                    type="file"
                                    @change="chooseImage"
                                    class="absolute left-0 top-0 right-0 bottom-0 opacity-0"
                                />
                                Change
                            </button>
                        </div>
                    </div>
                    <!-- end image -->
                    <!-- title -->
                    <div class="col-span-6">
                        <label
                            for="title"
                            class="block text-sm font-medium text-gray-700"
                            >Title</label
                        >
                        <input
                            type="text"
                            name="title"
                            id="title"
                            autocomplete="title"
                            v-model="model.title"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>
                    <!-- end title -->
                    <!-- description -->
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Description
                        </label>
                        <div class="mt-1">
                            <textarea
                                id="description"
                                name="description"
                                v-model="model.description"
                                rows="3"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                placeholder="tape description here"
                            />
                        </div>
                    </div>
                    <!-- end description -->
                    <!-- date expiration -->
                    <div class="col-span-6">
                        <label
                            for="title"
                            class="block text-sm font-medium text-gray-700"
                            >Date</label
                        >
                        <input
                            type="date"
                            name="title"
                            id="title"
                            v-model="model.expire_date"
                            autocomplete="title"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>
                    <!-- end date expiration -->
                    <!-- active -->
                    <div class="col-span-6">
                        <input
                            id="active"
                            name="active"
                            type="checkbox"
                            v-model="model.status"
                            class="focus:ring-indigo-500 h-5 w-5 text-indigo-600 border-gray-300 rounded"
                        />
                        <label
                            for="active"
                            class="text-sm font-medium text-gray-700 ml-2"
                            >Active</label
                        >
                    </div>

                    <!-- end active -->
                    <!-- start questions -->
                    <hr />
                    <div class="flex justify-between">
                        <h3 class="text-3xl">Questions</h3>
                        <button
                         @click.prevent="addQuestion()"
                            class="bg-gray-700 text-white  sm:p-2 rounded-md  sm:text-sm font-medium hover:bg-gray-500 transition duration-300"
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
                             Add Question 
                        </button>
                    </div>
                    <!-- end questions -->
                        <div v-if="!model.questions" class="text-gray-500 text-center">No Questions Yet !!</div>
                        <div v-else v-for="(question,index) in model.questions" :key="question.id">
                        <QuestionEditor 
                        :question="question"
                        :index="index"
                        @change="changeQuestion"
                        @addQuestion="addQuestion"
                        @deleteQuestion="deleteQuestion"
                        />
                        <hr class="mt-4"/>
                        </div>
                        
                        
                        
                    <!-- save -->
                        <hr>
                    <div class="px-4 py-3 text-right sm:px-6">
                        <button
                            type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Save
                        </button>
                    </div>
                    <!-- end save -->
                </div>
            </div>
        </form>
    </page-component>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import QuestionEditor from "../components/question/QuestionEditor.vue";
import { v4 as uuidv4 } from "uuid";
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import store from "../store";
const route = useRoute();
const router = useRouter();

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

if (route.params.id) {
    model.value = store.state.forms.find((s) => s.id == route.params.id);
    console.log(model.value);
}
function deleteForm(form){
  if(confirm('Are you sure to delete this form?')){
      store.dispatch('deleteForm',form).then(()=>{
          router.push({
              name:'forms'
          })
      });
  }
}
function chooseImage(ev) {
  const file = ev.target.files[0];
  const reader = new FileReader();
  reader.onload = () => {
    // The field to send on backend and apply validations
    model.value.image = reader.result;
    // The field to display here
    model.value.image_url = reader.result;
    ev.target.value = "";
  };
  reader.readAsDataURL(file);
}
function addQuestion(index) {
  const newQuestion = {
    id: uuidv4(),
    type: "text",
    question: "",
    description: null,
    data: {},
  };
  model.value.questions.splice(index, 0, newQuestion);
}
function deleteQuestion(question) {
  model.value.questions = model.value.questions.filter((q) => q !== question);
}

function saveForm() {
    store.dispatch('saveFormInfo',model.value)
    .then((response)=>{
        router.push({
            name:'FormView',
            params:{id:response.data.id}
        })
    })
    .catch();
}


</script>

<style></style>
