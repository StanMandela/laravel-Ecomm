<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Products</h1>
    <button type="submit"
    @click="showProductModal"
            class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Add new Product
    </button>
  </div>
<ProductsTable />
<ProductsModal v-model="showModal" :product="ProductsModel"/>
</template>

<script setup>
import {ref} from "vue";
import ProductsModal from './ProductsModal.vue';
import ProductsTable from './ProductsTable.vue';

const showModal= ref(false)

function showProductModal(){
  showModal.value= true

 }
 const ProductsModel = ref({
    id:'',
    title:'',
    image:'',
    description:'',
    price:''

 })

</script>

<style scoped>

</style>