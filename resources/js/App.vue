<template>
  <div class="min-h-screen flex flex-col">
    <Loader v-if="loading" />
    <Header />
    <main class="flex-grow p-0 bg-white">
      <router-view @route-change="simulateLoad"/>
    </main>
    <Footer />
  </div>
</template>

<script>
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import Loader from './components/Loader.vue'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default {
  components: { Header, Footer, Loader },
  setup() {
    const loading = ref(true)
    const router = useRouter()

    const simulateLoad = () => {
      loading.value = true
      setTimeout(() => {
        loading.value = false
      }, 800) 
    }

    router.beforeEach((to, from, next) => {
      loading.value = true
      next()
    })
    router.afterEach(() => {
      setTimeout(() => (loading.value = false), 600) 
    })

    return { loading, simulateLoad }
  }
}
</script>
