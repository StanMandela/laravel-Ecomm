
<template>
   
   <GuestLayout title="Reset Password">
        <form class="space-y-6" action="#" method="POST">
          <div>
            <div class="mt-2">
              <input id="email" placeholder="New Password " name="email" type="password" autocomplete="email" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            
              <input id="email2" placeholder="Repeat Password" name="email2" type="password" autocomplete="email" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
  
          <div class="flex items-center justify-between">
        <div class="text-sm">
          <router-link :to="{name: 'login'}" class="font-medium text-indigo-600 hover:text-indigo-500">
            Go back to Login
          </router-link>
        </div>
      </div>
  
      <div>
        <button type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            </span>
          Submit
        </button>
      </div>
        </form>
  </GuestLayout>
        
   
  </template>
   <script setup>
   import GuestLayout from "../components/GuestLayout.vue";
   </script>
<style scoped>

</style>