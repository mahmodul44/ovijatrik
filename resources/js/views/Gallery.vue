<template>
  <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col md:flex-row gap-6">
    <!-- Sidebar -->
    <aside class="w-full md:w-1/4">
      <h2 class="text-xl font-semibold mb-4 text-green-700">
        {{ isBangla ? 'ক্যাটাগরি' : 'Category' }}
      </h2>
      <ul class="space-y-2">
        <li 
          v-for="category in categories"
          :key="category.category_id"
          @click="selectCategory(category)"
          :class="[ 
            'cursor-pointer px-4 py-2 rounded transition-all',
            selectedCategory?.category_id === category.category_id
              ? 'bg-green-700 text-white'
              : 'bg-green-100 text-green-800 hover:bg-green-200'
          ]"
        >
          {{ isBangla ? category.category_name_bn : category.category_name }}
        </li>
      </ul>
    </aside>

    <!-- Gallery Grid -->
    <section class="w-full md:w-3/4">
      <h2 class="text-2xl font-bold text-center text-green-800 mb-4">
        {{ isBangla ? selectedCategory?.category_name_bn : selectedCategory?.category_name || (isBangla ? 'গ্যালারি' : 'Gallery') }}
      </h2>

      <!-- Loader -->
      <div v-if="loading" class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-green-700 border-solid"></div>
      </div>

      <!-- Image Grid -->
      <div v-if="images.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div 
          v-for="(img, i) in images"
          :key="i"
          class="relative group cursor-pointer"
          @click="openModal(img)"
        >
          <img :src="img.image" class="w-full h-48 object-cover rounded" />
          <div 
            class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center 
                   text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition">
            {{ isBangla ? 'প্রিভিউ' : 'Preview' }}
          </div>
        </div>
      </div>

      <!-- No Images Message -->
      <div v-else class="text-center text-gray-500 py-6">
        {{ isBangla ? 'এই ক্যাটাগরিতে কোনো ছবি নেই।' : 'There are no images in this category.' }}
      </div>
    </section>

    <!-- Preview Modal -->
    <div 
      v-if="previewImage" 
      class="fixed inset-0 bg-black bg-opacity-70 z-50 flex justify-center items-center" 
      @click.self="previewImage = null"
    >
      <div class="bg-white rounded shadow-lg max-w-3xl w-full p-4">
        <img :src="previewImage.image" class="w-full max-h-[80vh] object-contain" />
        <p class="text-center mt-2 text-lg text-gray-700">{{ previewImage.caption }}</p>
        <button 
          class="mt-4 px-4 py-2 bg-red-500 text-white rounded mx-auto block hover:bg-red-600 transition"
          @click="previewImage = null"
        >
          {{ isBangla ? 'বন্ধ করুন' : 'Close' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { ref, onMounted, computed, inject } from 'vue'

export default {
  name: 'Gallery',
  setup() {
    const i18n = inject('i18n')
    const isBangla = computed(() => i18n.currentLang === 'bn')

    // 🔹 State variables
    const loading = ref(false)
    const categories = ref([])
    const selectedCategory = ref(null)
    const images = ref([])
    const previewImage = ref(null)

    // 🔹 Fetch all categories
    const fetchCategories = async () => {
      try {
        const res = await axios.get('/api/gallery-categories')
        categories.value = res.data
        if (res.data.length > 0) {
          selectCategory(res.data[0])
        }
      } catch (error) {
        console.error('Error fetching categories:', error)
      }
    }

    // 🔹 Fetch images by selected category
    const selectCategory = async (category) => {
      selectedCategory.value = category
      loading.value = true
      try {
        const res = await axios.get(`/api/gallery/${category.category_id}`)
        images.value = res.data
      } catch (err) {
        console.error('Error fetching images:', err)
      } finally {
        loading.value = false
      }
    }

    // 🔹 Open modal preview
    const openModal = (img) => {
      previewImage.value = img
    }

    // 🔹 Lifecycle
    onMounted(fetchCategories)

    return {
      i18n,
      isBangla,
      categories,
      selectedCategory,
      images,
      previewImage,
      selectCategory,
      openModal,
      loading
    }
  }
}
</script>

<style scoped>
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
.animate-spin {
  animation: spin 1s linear infinite;
}
</style>
