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
    <div
      class="w-full sm:w-1/2 md:w-1/3 flex flex-col p-3"
      v-for="form in forms"
      :key="form.id"
    >
      <div class="bg-white pt-4 rounded-lg shadow-lg overflow-hidden flex-1 flex flex-col">
        <div
          class="bg-contain bg-no-repeat bg-center h-48"
          :style="{
            'background-image': 'url('+form.image+')'}
          "
        ></div>
        <div class="p-4 flex-1 flex flex-col" style="">
          <h3 class="mb-4 text-2xl">{{ form.title }}</h3>
          <div class="mb-4 text-grey-darker text-sm flex-1">
            <p>
              {{ form.description }}
            </p>
          </div>
          <div class="flex items-center justify-end p-2 md:p-4 md:mx-4">
            <a
              class="text-green-500 p-2 cursor-pointer rounded-full hover:bg-green-200 transition duration-300"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                />
              </svg>
            </a>
            <a
              class="text-red-500 p-2 cursor-pointer rounded-full hover:bg-red-200 transition duration-300"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8"
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
            </a>
          </div>
        </div>
      </div>
    </div>
    </div>
  </page-component>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import store from "../store";
import { computed } from "vue";

const forms = computed(() => store.state.forms);
</script>

<style></style>
