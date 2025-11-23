<template>
  <section>
    <!-- Banner Section -->
    <div
      class="relative bg-cover bg-center h-60 flex items-center justify-center text-white"
      :style="{ backgroundImage: `url('/uploads/banners/contact.jpg')` }"
    >
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>
      <h1 class="relative text-3xl md:text-4xl font-bold">
        {{ isBangla ? 'যোগাযোগ করুন' : 'Contact' }}
      </h1>
    </div>

    <!-- Contact Section -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid md:grid-cols-2 gap-10">
      <!-- Contact Form -->
      <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
          {{ isBangla ? 'যোগাযোগ ফর্ম' : 'Contact Form' }}
        </h2>
        <form @submit.prevent="submitForm" class="space-y-4">
          <div>
            <label class="block font-medium text-gray-700">
              {{ isBangla ? 'নাম' : 'Your Name' }} *
            </label>
            <input
              v-model="form.name"
              type="text"
              required
              class="form-input"
              :placeholder="isBangla ? 'আপনার নাম লিখুন' : 'Type your name'"
            />
            <p v-if="errors.name" class="text-red-600 text-sm">{{ errors.name[0] }}</p>
          </div>

          <div>
            <label class="block font-medium text-gray-700">
              {{ isBangla ? 'ইমেইল' : 'Your Email' }} *
            </label>
            <input
              v-model="form.email"
              type="email"
              required
              class="form-input"
              :placeholder="isBangla ? 'example@email.com' : 'Type your email'"
            />
            <p v-if="errors.email" class="text-red-600 text-sm">{{ errors.email[0] }}</p>
          </div>

          <div>
            <label class="block font-medium text-gray-700">
              {{ isBangla ? 'বিষয়' : 'Subject' }} *
            </label>
            <input
              v-model="form.subject"
              type="text"
              required
              class="form-input"
              :placeholder="isBangla ? 'বিষয় লিখুন' : 'Type subject'"
            />
            <p v-if="errors.subject" class="text-red-600 text-sm">{{ errors.subject[0] }}</p>
          </div>

          <div>
            <label class="block font-medium text-gray-700">
              {{ isBangla ? 'মেসেজ' : 'Message' }} *
            </label>
            <textarea
              v-model="form.message"
              required
              rows="4"
              class="form-input"
              :placeholder="isBangla ? 'আপনার মেসেজ লিখুন' : 'Type your message'"
            ></textarea>
            <p v-if="errors.message" class="text-red-600 text-sm">{{ errors.message[0] }}</p>
          </div>

          <div class="pt-4">
            <button
              type="submit"
              class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md shadow flex items-center justify-center space-x-2"
            >
              <span>{{ isBangla ? 'পাঠান' : 'Send' }}</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </button>
          </div>

          <div v-if="success" class="text-green-600 text-center pt-2 font-medium">
            {{ isBangla ? 'আপনার মেসেজ সফলভাবে পাঠানো হয়েছে।' : 'Your message has been sent successfully.' }}
          </div>
        </form>
      </div>

      <!-- Map and Info -->
      <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
          {{ isBangla ? 'আমাদের ঠিকানা' : 'Our Location' }}
        </h2>

        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.838102367495!2d90.40306537491996!3d23.750858588802658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8ba00f6b3f9%3A0x89359de03a80ffb3!2sAS%20Sunnah%20Foundation!5e0!3m2!1sen!2sbd!4v1695658969999!5m2!1sen!2sbd"
          width="100%"
          height="250"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          class="rounded-lg shadow"
        ></iframe>

        <div class="mt-6 space-y-4 text-gray-700">
          <div class="flex items-start space-x-2">
            <i class="fa-solid fa-phone text-green-600 mt-1"></i>
            <p><strong>{{ isBangla ? 'ফোন:' : 'Phone:' }}</strong> {{ isBangla ? '+৮৮০১৯২৫৪৮৬৪:' : '+8809610-001089' }} </p>
          </div>
          <div class="flex items-start space-x-2">
            <i class="fa-solid fa-location-dot text-green-600 mt-1"></i>
            <p><strong>{{ isBangla ? 'ঠিকানা:' : 'Location:' }}</strong> Plot-70, Road-3, Block-C, Aftabnagar, Dhaka-1212</p>
          </div>
          <div class="flex items-start space-x-2">
            <i class="fa-solid fa-envelope text-green-600 mt-1"></i>
            <p><strong>{{ isBangla ? 'ইমেইল:' : 'Email:' }}</strong> contact@assunnahfoundation.org</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, inject } from 'vue'
import axios from 'axios'

const i18n = inject('i18n')
const isBangla = computed(() => i18n.currentLang === 'bn')

const form = ref({
  name: '',
  email: '',
  subject: '',
  message: ''
})
const success = ref('')
const errors = ref({})

async function submitForm() {
  success.value = ''
  errors.value = {}

  try {
    const response = await axios.post('/api/contact-submit', form.value)
    success.value = response.data.message
    form.value = { name: '', email: '', subject: '', message: '' }
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors
    }
  }
}
</script>

<style scoped>
.form-input {
  @apply w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400;
}
</style>
