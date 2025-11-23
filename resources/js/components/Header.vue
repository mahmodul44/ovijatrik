<template>
  <div>
   <!-- Popup Alert -->
  <transition name="slide-fade">
    <div
      v-if="showToast"
      class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-green-700 text-white px-5 py-3 rounded-lg shadow-lg flex items-center space-x-2 z-50"
    >
      <i class="fas fa-check-circle text-white text-xl"></i>
      <span class="font-medium">{{ toastMessage }}</span>
    </div>
  </transition>

    <!-- Header -->
    <header class="bg-white shadow sticky top-0 z-40">
      <div class="flex justify-between items-center p-4 md:p-3 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="relative">
              <img src="./logo.png" alt="Logo" class="h-12 w-auto" />
          </div>
          <div class="flex flex-col">
        <h1 class="text-xl md:text-2xl font-bold text-green-700">{{ i18n.currentLang === 'bn' ? 'অভিযাত্রিক' : 'Ovijatrik' }}</h1>
        <p class="text-xs md:text-sm text-gray-500">{{ i18n.currentLang === 'bn' ? 'হাসিমুখের খুঁজে অভিযাত্রা' : 'A journey in search of a smile' }}</p>
      </div>
        </div>

        <div class="flex items-center space-x-4">
          <div class="hidden sm:flex space-x-3">
            <a href="#" class="text-blue-600 hover:text-blue-800 transition-colors"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-red-500 hover:text-red-700 transition-colors"><i class="fab fa-youtube"></i></a>
            <a href="#" class="text-green-600 hover:text-green-800 transition-colors"><i class="fas fa-phone-alt"></i></a>
          </div>

          <!-- Language Buttons -->
          <div class="flex items-center">
            <button
              @click="changeLanguage('bn')"
              :class="{
                'bg-indigo-600 text-white shadow-md': i18n.currentLang === 'bn',
                'bg-white text-indigo-600 border border-indigo-300 hover:bg-indigo-50': i18n.currentLang !== 'bn'
              }"
              class="px-4 py-1.5 text-sm font-semibold rounded-l-lg transition duration-300 border-r-0"
            >
              বাংলা
            </button>
            <button
              @click="changeLanguage('en')"
              :class="{
                'bg-indigo-600 text-white shadow-md': i18n.currentLang === 'en',
                'bg-white text-indigo-600 border border-indigo-300 hover:bg-indigo-50': i18n.currentLang !== 'en'
              }"
              class="px-4 py-1.5 text-sm font-semibold rounded-r-lg transition duration-300 border-l-0"
            >
              EN
            </button>
          </div>

          <button @click="toggleMenu" class="md:hidden">
            <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Navbar -->
      <nav class="bg-green-700 text-white text-sm md:text-base">
        <ul
          :class="[ 'md:flex md:justify-center space-y-2 md:space-y-0 md:space-x-6 px-4 md:py-2',
          isMenuOpen ? 'block py-2' : 'hidden md:flex' ]"
        >
          <li><router-link to="/" @click="closeMenu" class="hover:bg-green-800 px-3 py-1 rounded transition-colors">{{ i18n.t('home') }}</router-link></li>
          <li><router-link to="/about" @click="closeMenu" class="hover:bg-green-800 px-3 py-1 rounded transition-colors">{{ i18n.t('about') }}</router-link></li>
          <li><router-link to="/project" @click="closeMenu" class="hover:bg-green-800 px-3 py-1 rounded transition-colors">{{ i18n.t('project') }}</router-link></li>
          <li><router-link to="/volunteer" @click="closeMenu" class="hover:bg-green-800 px-3 py-1 rounded transition-colors">{{ i18n.t('volunteer') }}</router-link></li>
          <li><router-link to="/blog" @click="closeMenu" class="hover:bg-green-800 px-3 py-1 rounded transition-colors">{{ i18n.t('blog') }}</router-link></li>
          <li><router-link to="/gallery" @click="closeMenu" class="hover:bg-green-800 px-3 py-1 rounded transition-colors">{{ i18n.t('gallery') }}</router-link></li>
          <li><router-link to="/contact" @click="closeMenu" class="hover:bg-green-800 px-3 py-1 rounded transition-colors">{{ i18n.t('contact') }}</router-link></li>
        </ul>
      </nav>
    </header>
  </div>
</template>

<script setup>
import { ref, inject } from 'vue'

const i18n = inject('i18n')
const isMenuOpen = ref(false)
const showToast = ref(false)
const toastMessage = ref('')

const toggleMenu = () => (isMenuOpen.value = !isMenuOpen.value)
const closeMenu = () => (isMenuOpen.value = false)

// Language Change Function
const changeLanguage = (lang) => {
  if (i18n.currentLang !== lang) {
    i18n.toggleLang(lang)
    toastMessage.value = lang === 'bn' ? '✅ আপনি এখন বাংলা ভাষায় আছেন' : '✅ You are now using English'
    showToast.value = true
    setTimeout(() => (showToast.value = false), 2500)
  }
}
</script>

<style scoped>
/* Active menu style */
nav a.router-link-exact-active {
  background-color: #14532d;
}

/* Popup animation */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.5s ease;
}
.slide-fade-enter-from {
  opacity: 0;
  transform: translateY(20px);
}
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(20px);
}
</style>
