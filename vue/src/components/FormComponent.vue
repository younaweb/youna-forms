<template>
  <div class="w-full sm:w-1/2 md:w-1/3 flex flex-col p-3">
    <div
      class="
        bg-white
        pt-4
        rounded-lg
        shadow-lg
        overflow-hidden
        flex-1 flex flex-col
      "
    >
      <div
        class="bg-contain bg-no-repeat bg-center h-48"
        :style="{
          'background-image': 'url(' + form.image_url + ')',
        }"
      ></div>
      <div class="p-4 flex-1 flex flex-col" style="">
        <h3 class="mb-4 text-2xl">{{ form.title }}</h3>
        <div class="mb-4 text-grey-darker text-sm flex-1">
          <p>
            {{ form.description }}
          </p>
        </div>
        <div class="flex items-center justify-end p-2 md:p-4 md:mx-4">
          <!-- public link -->
          <a
          :href="`/view/form/${form.slug}`"
          target="_blank"
            class="
              text-blue-500
              p-2
              cursor-pointer
              rounded-full
              hover:bg-blue-200
              transition
              duration-300
            "
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
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
              />
            </svg>
          </a>
          <!-- update -->
          <router-link
            :to="{ name: 'FormView', params: { id: form.id } }"
            class="
              text-green-500
              p-2
              cursor-pointer
              rounded-full
              hover:bg-green-200
              transition
              duration-300
            "
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
          </router-link>

          <a
            v-if="form.id"
            @click="emit('delete', form)"
            class="
              text-red-500
              p-2
              cursor-pointer
              rounded-full
              hover:bg-red-200
              transition
              duration-300
            "
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
</template>

<script setup>
const { form } = defineProps({ form: Object });
const emit = defineEmits(["delete"]);
</script>

<style>
</style>