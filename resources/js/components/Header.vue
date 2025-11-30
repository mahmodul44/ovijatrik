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
      <div class="flex justify-between items-center p-4 md:p-5 bg-white border-b border-gray-200 shadow-sm">

  <!-- Left: Logo + Title -->
  <div class="flex items-center space-x-4">
    <img src="./logo.png" alt="Logo" class="h-11 w-auto object-contain" />

    <div>
      <h1 class="text-2xl font-bold text-green-700 leading-tight">
        {{ i18n.currentLang === 'bn' ? 'অভিযাত্রিক' : 'Ovijatrik' }}
      </h1>
      <p class="text-sm text-gray-500">
        {{ i18n.currentLang === 'bn' ? 'হাসিমুখের খুঁজে অভিযাত্রা' : 'A journey in search of a smile' }}
      </p>
    </div>
  </div>

  <!-- Right: Social + Language + Mobile Menu -->
  <div class="flex items-center space-x-5">

    <!-- Social Icons (SVG) -->
    <div class="hidden sm:flex items-center space-x-3">

      <!-- Facebook -->
      <a href="#"
        class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
          <path
            d="M22 12a10 10 0 1 0-11.5 9.9v-7H8v-3h2.5V9.5A3.5 3.5 0 0 1 14.4 6h2.6v3h-2.6c-.5 0-1 .5-1 1V12H17l-.5 3h-2.7v7A10 10 0 0 0 22 12z" />
        </svg>
      </a>

      <!-- YouTube -->
      <a href="#"
        class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path
            d="M19.6 7.2c-.2-1-1-1.8-2-2C15.8 5 12 5 12 5s-3.8 0-5.6.2c-1 .2-1.8 1-2 2C4 9 4 12 4 12s0 3 .4 4.8c.2 1 1 1.8 2 2 1.8.2 5.6.2 5.6.2s3.8 0 5.6-.2c1-.2 1.8-1 2-2C20 15 20 12 20 12s0-3-.4-4.8zM10 15.5V8.5l6 3.5-6 3.5z" />
        </svg>
      </a>

      <!-- Phone -->
      <a href="#"
        class="w-9 h-9 flex items-center justify-center rounded-full bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-all duration-300 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
          <path
            d="M6.6 2A2.6 2.6 0 0 0 4 4.6C4 14.4 9.6 20 19.4 20a2.6 2.6 0 0 0 2.6-2.6v-1.8a1 1 0 0 0-.9-1l-4.4-.5a1 1 0 0 0-1 .5l-1.4 2.2a12 12 0 0 1-5.5-5.6l2.2-1.4a1 1 0 0 0 .5-1L10.4 4a1 1 0 0 0-1-.9H6.6z" />
        </svg>
      </a>

    </div>

    <!-- Language Switch -->
    <div class="flex border border-indigo-300 rounded-lg overflow-hidden">
      <button
        @click="changeLanguage('bn')"
        :class="i18n.currentLang === 'bn'
          ? 'bg-indigo-600 text-white'
          : 'bg-white text-indigo-600 hover:bg-indigo-50'"
        class="px-4 py-1.5 text-sm font-semibold transition">
        বাংলা
      </button>

      <button
        @click="changeLanguage('en')"
        :class="i18n.currentLang === 'en'
          ? 'bg-indigo-600 text-white'
          : 'bg-white text-indigo-600 hover:bg-indigo-50'"
        class="px-4 py-1.5 text-sm font-semibold transition">
        EN
      </button>
    </div>

    <!-- Mobile Menu -->
    <button @click="toggleMenu" class="md:hidden p-2 rounded-lg border border-green-700">
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
