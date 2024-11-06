<script setup>
import { RouterLink } from 'vue-router';
import CategoryApi from '../../api/CategoryApi';
import { onMounted, watch, ref } from 'vue';
import ProductApi from '../../api/ProductApi';

const props = defineProps({
  id: {
    required: true,
    type: String,
  },
});

// console.log('props', props.id)
const categories = ref([]);
const product = ref({
  name: '',
  sku: '',
  quantity: 0,
  price: '',
  // description: '',
  cat_id: ''
});
const message = ref(null);
const error = ref(null);
const loading = ref(false);

onMounted(() => {
  getCategory();
  if (props.id) {
    showProduct(props.id);
  } else {
    generateSku(); // Generate SKU for new products only
  }
  if (!props.id){
    generateSku();
  }
});

// watch(props.id, (id) => {
//   if (id) {
//     showProduct(id);
//   }
// });

const getCategory = async () => {
  const res = await CategoryApi.index();
  if (res.success) {
    categories.value = res.data.data;
  }
};

const showProduct = async (id) => {
  const res = await ProductApi.show(id);
console.log('res', res)
  if (res.success) {
    product.value = res.data.data;
  }
};

const generateSku = () => {
  const timestamp = Date.now().toString().slice(-4);
  const randomNum = Math.floor(1000 + Math.random() * 9000);
  product.value.sku = `SKU-${timestamp}-${randomNum}`;
};


const handleSubmit = async () => {
  loading.value = true;
  const res = await ProductApi.save(product.value);
  if (res.success) {
    message.value = 'Product saved successfully!';
  } else {
    error.value = res.response.data.errors;
  }
  loading.value = false;
};
</script>

<template>
  <div v-if="message" class="alert-message">
    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
      <p class="font-bold">{{ message }}</p>
    </div>
  </div>
  <div v-if="error" class="alert-message">
    <div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
      <p class="font-bold">Product saving errors:</p>
      <ul>
        <li v-for="(error, index) in error" :key="index" class="text-sm">{{ error }}</li>
      </ul>
    </div>
  </div>

  <section class="max-w-7xl p-6 mx-auto">
    <form @submit.prevent="handleSubmit">
      <div class="grid grid-cols-2">
        <div>
          <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">{{ id ? 'Edit' : 'Add' }} Item</h2>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
            <span v-if="loading">Submitting...</span>
            <span v-else>Submit</span>
          </button>
        </div>
      </div>

      <div class="mt-4 flex gap-6">
        <div class="w-7/12 gap-4">
          <div>
            <label class="text-gray-700 dark:text-gray-200" for="name">Name</label>
            <input id="name" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:ring"
              v-model="product.name" />
          </div>

          <!-- <div class="mt-2">
            <label class="text-gray-700 dark:text-gray-200" for="description">Description</label>
            <textarea id="description" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:ring"
              v-model="product.description" />
          </div> -->
        </div>

        <div class="w-5/12 gap-4">
          <div>
            <label class="text-gray-700 dark:text-gray-200" for="inventory_id">Category</label>
            <select id="inventory_id" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:ring"
              v-model="product.cat_id">
              <option value="">--Select Category--</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>

          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="quantity">Quantity</label>
            <input id="quantity" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:ring"
              v-model="product.quantity" />
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="quantity">Sku</label>
            <input id="sku" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:ring"
              v-model="product.sku" />
          </div>
          <div class="mt-4">
            <label class="text-gray-700 dark:text-gray-200" for="quantity">Price</label>
            <input id="price" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:ring"
              v-model="product.price" />
          </div>
        </div>
      </div>
    </form>
  </section>
</template>

<style scoped>
.alert-message {
  margin-bottom: 1rem;
}
</style>
