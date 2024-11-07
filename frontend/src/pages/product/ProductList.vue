<script setup>
import { RouterLink } from 'vue-router';
import ProductApi from '../../api/ProductApi';
import { onMounted, ref } from 'vue';

const products = ref([]);
const message = ref(null);
onMounted(() => {
    getProduct();
});

const getProduct = async () =>{
    const res = await ProductApi.index();
    if (res.success){
        products.value = res.data.data;
    }
}

const productDelete = async (id) =>{
    const res = await ProductApi.delete(id);
    if (res.success) {
        message.value = 'Product deleted successfully!';
        getProduct();
    }
}
</script>

<template>
    <div>
        <div v-if="message" class="alert-message">
            <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                <p class="font-bold">{{message}}</p>
            </div>
        </div>
          <div class="max-w-7xl mx-auto mt-5">
          <div class="flex justify-between ">
                <div class="text-lg text-gray-500">
                    <h1>All Products</h1>
                </div>
                <div>
                    <RouterLink  to='/' class="mr-2 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mb-4">
                        Products
                    </RouterLink>
                    <RouterLink  to='/create' class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mb-4">
                        Add
                    </RouterLink>
                </div>
            </div>
              <div class="flex flex-col mt-2">
                  <div class="overflow-x-auto shadow-md sm:rounded-lg">
                      <div class="inline-block min-w-full align-middle">
                          <div class="overflow-hidden ">
                              <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                                  <thead class="bg-gray-100 dark:bg-gray-700">
                                      <tr>
                                          <th scope="col" class="p-4">
                                              <div class="flex items-center">
                                                  <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
                                                  <label for="checkbox-all" class="sr-only">checkbox</label>
                                              </div>
                                          </th>
                                          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                              Name
                                          </th>
                                          <th scope="col" class="p-4">
                                              <span class="sr-only">Actions</span>
                                          </th>
                                      </tr>
                                  </thead>
                                  <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                      <tr v-for="(product) in products" :key="product.id" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                          <td class="p-4 w-4">
                                              <div class="flex items-center">
                                                  <input id="checkbox-table-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
                                                  <label for="checkbox-table-1" class="sr-only">checkbox</label>
                                              </div>
                                          </td>
                                          <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                <span class='ml-2'>{{product.name}}</span>
                                            </div>
                                          </td> 
                                          <td class="py-8 px-6 text-sm font-medium float-right whitespace-nowrap flex my-auto">
                                            <!-- <RouterLink :to="{ name: 'edit', params: { id: product.id }}" class="text-blue-600 dark:text-blue-500 hover:underline">Edit</RouterLink> -->
                                            <!-- <RouterLink :to='`/edit/${product.id}`' class="text-blue-600 dark:text-blue-500 hover:underline">Edit</RouterLink> -->
                                            <RouterLink :to="'/edit/' + product.id" class="text-blue-600 dark:text-blue-500 hover:underline">Edit</RouterLink>
                                              <button @click.prevent="productDelete(product.id)" class="ml-2 text-blue-600 dark:text-blue-500 hover:underline ">Delete</button>
                                          </td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
</template>

