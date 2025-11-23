<template>
  <section class="py-10 bg-gray-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">
        {{ isBangla ? 'সক্রিয় তহবিল সংগ্রহ প্রকল্প' : 'Active Fundraising Projects' }}
      </h2>

      <div class="relative overflow-hidden">
        <!-- Slides Wrapper -->
        <div
          class="flex transition-transform duration-700 ease-in-out"
          :style="{ transform: `translateX(-${currentIndex * (100 / visibleCount)}%)` }"
          @transitionend="handleTransitionEnd"
        >
          <div
            v-for="(project, index) in extendedProjects"
            :key="index + '-' + project.id"
            class="flex-shrink-0 px-3"
            :style="{ width: `${100 / visibleCount}%` }"
          >
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
              <div class="relative">
                <img :src="project.image" :alt="project.project_title" class="w-full h-56 object-cover" />
                <div class="absolute top-3 left-3 bg-orange-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                  {{ calculateProgress(project.collection_amount, project.target_amount) }} Funded
                </div>
              </div>

              <div class="p-6 flex flex-col space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 line-clamp-2">
                  {{ isBangla ? project.project_title_bn : project.project_title }}
                </h3>

                <p class="text-gray-600 text-sm leading-relaxed">
                  <span v-if="expandedProjectId === project.id">
                    {{ isBangla ? project.project_details_bn : project.project_details }}
                  </span>
                  <span v-else>
                    {{
                      (isBangla ? project.project_details_bn : project.project_details)?.length > 100
                        ? (isBangla
                            ? project.project_details_bn.slice(0, 100)
                            : project.project_details.slice(0, 100)) + "..."
                        : (isBangla ? project.project_details_bn : project.project_details)
                    }}
                  </span>
                  <button
                    v-if="(isBangla ? project.project_details_bn : project.project_details)?.length > 100"
                    @click="toggleDescription(project.id)"
                    class="text-blue-600 font-medium hover:underline ml-1"
                  >
                    {{ expandedProjectId === project.id ? (isBangla ? 'কম দেখান' : 'See less') : (isBangla ? 'বিস্তারিত দেখুন' : 'See more') }}
                  </button>
                </p>

                <div>
                  <div class="flex justify-between text-sm text-gray-500 mb-1">
                    <span>{{ isBangla ? 'সংগ্রহিত:' : 'Raised:' }} {{ formatCurrency(project.collection_amount) }}</span>
                    <span>{{ isBangla ? 'লক্ষ্য:' : 'Goal:' }} {{ formatCurrency(project.target_amount) }}</span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-3">
                    <div
                      class="bg-gradient-to-r from-green-400 to-blue-500 h-3 rounded-full transition-all duration-500"
                      :style="{ width: calculateProgress(project.collection_amount, project.target_amount) }"
                    ></div>
                  </div>
                </div>

                 <router-link
                  :to="`/project/${project.project_id}`"
                  class="px-8 py-3 bg-indigo-600 text-white font-semibold rounded-full hover:bg-indigo-700 transition duration-300 shadow-lg transform hover:scale-105 text-center"
                >
                   {{ isBangla ? 'বিস্তারিত দেখুন' : 'See Details' }}
                </router-link>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Arrows -->
        <div class="absolute top-1/2 left-0 right-0 flex justify-between items-center px-2 -translate-y-1/2 pointer-events-none">
          <button @click="prevSlide" class="pointer-events-auto bg-white shadow-lg p-3 rounded-full hover:bg-gray-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button @click="nextSlide" class="pointer-events-auto bg-white shadow-lg p-3 rounded-full hover:bg-gray-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </div>
   <br/>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center mt-5">
       <hr/>
        <router-link
          to="/project"
          class="px-8 py-3 bg-indigo-600 text-white font-semibold rounded-full hover:bg-indigo-700 transition duration-300 shadow-lg transform hover:scale-105 text-center"
          >
             {{ isBangla ? 'কার্যক্রম' : 'All Activities' }}
        </router-link>
      </div>
  </section>
      
</template>
<script setup>
import { ref, computed, onMounted, onUnmounted, inject, watch } from 'vue'
import axios from 'axios'

const i18n = inject('i18n')
const isBangla = computed(() => i18n.currentLang === 'bn')

const projects = ref([])
const expandedProjectId = ref(null)
const currentIndex = ref(0)
let interval = null

// Responsive visible count
const visibleCount = ref(3)

function updateVisibleCount() {
  const width = window.innerWidth
  if (width < 640) visibleCount.value = 1 // sm
  else if (width < 1024) visibleCount.value = 2 // md
  else visibleCount.value = 3 // lg+
}

onMounted(async () => {
  updateVisibleCount()
  window.addEventListener('resize', updateVisibleCount)
  
  try {
    const res = await axios.get('/api/active-project')
    projects.value = res.data
  } catch (err) {
    console.error(err)
  }
  
  startAutoSlide()
})

onUnmounted(() => {
  stopAutoSlide()
  window.removeEventListener('resize', updateVisibleCount)
})

// Clone slides for seamless loop
const extendedProjects = computed(() => {
  if (projects.value.length <= visibleCount.value) return projects.value
  return [...projects.value, ...projects.value.slice(0, visibleCount.value)]
})

function startAutoSlide() {
  stopAutoSlide()
  interval = setInterval(nextSlide, 4000)
}

function stopAutoSlide() {
  if (interval) clearInterval(interval)
}

function nextSlide() {
  currentIndex.value++
}

function prevSlide() {
  if (currentIndex.value === 0) {
    currentIndex.value = projects.value.length
  } else {
    currentIndex.value--
  }
}

// Continuous seamless loop
function handleTransitionEnd() {
  if (currentIndex.value >= projects.value.length) {
    currentIndex.value = 0
  }
}

function toggleDescription(id) {
  expandedProjectId.value = expandedProjectId.value === id ? null : id
}

function formatCurrency(amount) {
  amount = parseFloat(amount) || 0
  return '৳' + new Intl.NumberFormat('en-US').format(amount)
}

function calculateProgress(raised, goal) {
  raised = Number(raised) || 0
  goal = Number(goal) || 0
  if (goal <= 0) return '0%'
  const percent = (raised / goal) * 100
  return percent.toFixed(0) + '%'
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
