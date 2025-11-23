<template>
  <div class="max-w-7xl mx-auto px-4 py-10">
    <!-- Section Title -->
    <div class="mb-6 text-center">
      <h3 class="text-3xl font-bold text-gray-800">
        {{ isBangla ? 'প্রোজেক্টসমূহ' : 'Projects' }}
      </h3>
    </div>

    <!-- Responsive Card Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <div
        v-for="(item, index) in projects"
        :key="item.project_id || index"
        class="bg-white rounded-xl shadow-md overflow-hidden transform transition hover:scale-[1.02] hover:shadow-lg"
      >
        <div class="overflow-hidden h-52">
          <img
            :src="item.image"
            :alt="displayTitle(item)"
            class="w-full h-full object-cover transition duration-500 hover:scale-105"
          />
        </div>
        <div class="p-5">
          <p class="text-sm text-gray-500 mb-1">
            {{ formatDate(item.created_at) }}
          </p>
          <h4 class="text-lg font-semibold text-green-700 mb-2">
            {{ displayTitle(item) }}
          </h4>
          <p class="text-gray-600 text-sm mb-4">
            {{ displayDetails(item) }}
          </p>
          <router-link
            :to="`/project/${item.project_id}`"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg transition duration-300 inline-block"
          >
            {{ isBangla ? 'বিস্তারিত দেখুন' : 'Details' }}
          </router-link>
        </div>
      </div>
    </div>
<br/>
<hr/>
<br/>
     <!-- 🔹 Category Section -->
<div class="w-full text-center mb-8">
  <h2 class="text-xl font-semibold mb-4 text-green-700">
    {{ isBangla ? 'ক্যাটাগরি' : 'Category' }}
  </h2>
  <ul class="flex flex-wrap justify-center gap-2">
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
</div>
 <div 
    v-if="loadingCategory" 
    class="absolute inset-0 flex items-center justify-center bg-white/60 backdrop-blur-sm rounded-lg z-10"
  >
    <svg class="animate-spin h-10 w-10 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
    </svg>
  </div>
<!-- 🔹 Filtered Projects Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
  <div
    v-for="(item, index) in filteredProjects"
    :key="item.project_id || index"
    class="bg-white rounded-xl shadow-md overflow-hidden transform transition hover:scale-[1.02] hover:shadow-lg"
  >
    <div class="overflow-hidden h-52">
      <img
        :src="item.image"
        :alt="displayTitle(item)"
        class="w-full h-full object-cover transition duration-500 hover:scale-105"
      />
    </div>
    <div class="p-5">
      <p class="text-sm text-gray-500 mb-1">
        {{ formatDate(item.created_at) }}
      </p>
      <h4 class="text-lg font-semibold text-green-700 mb-2">
        {{ displayTitle(item) }}
      </h4>
      <p class="text-gray-600 text-sm mb-4">
        {{ displayDetails(item) }}
      </p>
      <router-link
        :to="`/project/${item.project_id}`"
        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg transition duration-300 inline-block"
      >
        {{ isBangla ? 'বিস্তারিত দেখুন' : 'Details' }}
      </router-link>
    </div>
  </div>
</div>


  </div>
</template>

<script setup>
import { ref, computed, inject, onMounted } from 'vue'
import axios from 'axios'

const i18n = inject('i18n', null)

const currentLang = computed(() => {
  if (i18n && typeof i18n.currentLang !== 'undefined') return i18n.currentLang
  return 'en'
})

const isBangla = computed(() => currentLang.value === 'bn')
const projects = ref([])
const completeprojects = ref([])
const loadingCategory  = ref(false)
const categories = ref([])
const selectedCategory = ref(null)

const fetchProjects = async () => {
  try {
    const res = await axios.get('/api/project')
    projects.value = Array.isArray(res.data) ? res.data : []
  } catch (err) {
    console.error('Error fetching projects:', err)
    projects.value = []
  }
}

const fetchcompleteProjects = async () => {
  try {
    const res = await axios.get('/api/complete-project')
    completeprojects.value = Array.isArray(res.data) ? res.data : []
  } catch (err) {
    console.error('Error fetching complete projects:', err)
    completeprojects.value = []
  }
}

const displayTitle = (item) => {
  if (isBangla.value && item.project_title_bn) return item.project_title_bn
  if (item.project_title) return item.project_title

  const fallback = item.project_title_bn || item.project_title || ''
  return fallback ? fallback.slice(0, 2).toUpperCase() : 'PR'
}

const displayDetails = (item) => {
  const raw = isBangla.value ? (item.project_details_bn || item.project_details) : (item.project_details)
  return truncate(raw || '', 100)
}

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

    const selectCategory =  async(category) => {
      if (selectedCategory.value?.category_id === category.category_id) return
      selectedCategory.value = category
      loadingCategory.value = true
        await new Promise(resolve => setTimeout(resolve, 500))
      loadingCategory.value = false
    }

  const filteredProjects = computed(() => {
    if (!selectedCategory.value || completeprojects.value.length === 0) return []

    return completeprojects.value.filter(
       (p) => Number(p.category_id) === Number(selectedCategory.value.category_id)
    )
  })


const truncate = (text, maxLength) => {
  if (!text) return ''
  return text.length > maxLength ? text.substring(0, maxLength) + '...' : text
}

const formatDate = (date) => {
  if (!date) return ''
  try {
    const options = { day: '2-digit', month: 'long', year: 'numeric' }
    return new Date(date).toLocaleDateString('en-GB', options)
  } catch {
    return date
  }
}

onMounted(() => {
  fetchProjects()
  fetchcompleteProjects()
  fetchCategories()
})
</script>
