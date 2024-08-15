<template>
  <GuestLayout title="Sign in to your account">
    <form class="space-y-6" method="POST" @submit.prevent="login">
      <div>
        <div v-if="errorMsg" class="flex items-center justify-center py-3 bg-red-500 text-white rounded">
          {{ errorMsg }}
        </div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
        <div class="mt-2">
          <input
            id="email"
            name="email"
            type="email"
            v-model="user.email"
            autocomplete="email"
            required
            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          />
        </div>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
        <div class="mt-2">
          <input
            id="password"
            name="password"
            type="password"
            v-model="user.password"
            autocomplete="current-password"
            required
            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          />
        </div>
      </div>

      <div class="flex items-center">
        <input
          id="remember-me"
          name="remember-me"
          type="checkbox"
          v-model="user.remember"
          class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
        />
        <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
      </div>

      <div class="text-sm">
        <router-link :to="{ name: 'requestPassword' }" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</router-link>
      </div>

      <div>
        <button
          type="submit"
          :disabled="loading"
          class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          :class="{
            'cursor-not-allowed':loading,
            'hover:bg-indigo-500':loading
            }"
        >
        <svg
            v-if="loading"
            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            ></circle>
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
          </svg>
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true"/>
            </span>
          Sign in
        </button>
      </div>
    </form>
  </GuestLayout>
</template>

<script setup>
import { ref } from 'vue';
import GuestLayout from '../components/GuestLayout.vue';
import store from '../store';
import router from '../router';

let loading = ref(false);
let errorMsg = ref("");

const user = ref({
  email: '',
  password: '',
  remember: false // Ensure this matches the model used in the form
});

function login() {
  loading.value= true;

  console.log('Submitting with user data:', user.value); // Debugging line
  store.dispatch('login', user.value)
    .then(() => {

     // console.log('Login successful, redirecting...'); // Debugging line
     loading.value= false
      router.push({ name: 'app.dashboard' });
    })
    .catch(error => {
      loading.value= false
     // console.error('Login error:', error.response?.data); // Detailed logging
      errorMsg.value = error.response?.data.message;

    });
}
</script>
