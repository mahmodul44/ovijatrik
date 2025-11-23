<template>
  <div class="max-w-3xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-center mb-6 text-green-700">স্বেচ্ছাসেবক নিবন্ধন</h2>
    <form @submit.prevent="submitForm" class="bg-white p-6 rounded-xl shadow space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block font-medium">নাম *</label>
          <input v-model="form.name" type="text" class="form-input" placeholder="আপনার নাম লিখুন" required />
        </div>
        <div>
          <label class="block font-medium">লিঙ্গ</label>
          <div class="flex gap-4 mt-2">
            <label><input type="radio" value="পুরুষ" v-model="form.gender" /> পুরুষ</label>
            <label><input type="radio" value="মহিলা" v-model="form.gender" /> মহিলা</label>
          </div>
        </div>
        <div>
          <label class="block font-medium">মোবাইল নম্বর *</label>
          <input v-model="form.phone" type="tel" class="form-input" placeholder="01XXXXXXXXX" required />
        </div>
        <div>
          <label class="block font-medium">বিকল্প মোবাইল নম্বর</label>
          <input v-model="form.alt_phone" type="tel" class="form-input" placeholder="01XXXXXXXXX" />
        </div>
        <div>
          <label class="block font-medium">ইমেইল *</label>
          <input v-model="form.email" type="email" class="form-input" placeholder="example@email.com" required />
        </div>
        <div>
          <label class="block font-medium">ফেসবুক প্রোফাইল লিংক</label>
          <input v-model="form.fb_link" type="url" class="form-input" placeholder="https://facebook.com/yourID" />
        </div>
        <div>
          <label class="block font-medium">জাতীয় পরিচয়পত্র নম্বর</label>
          <input v-model="form.nid" type="text" class="form-input" />
        </div>
        <div>
          <label class="block font-medium">শিক্ষাগত যোগ্যতা</label>
          <input v-model="form.education" type="text" class="form-input" placeholder="SSC, HSC, Honours" />
        </div>
        <div>
          <label class="block font-medium">পেশা</label>
          <input v-model="form.occupation" type="text" class="form-input" placeholder="ছাত্র, চাকুরীজীবী" />
        </div>
        <div>
          <label class="block font-medium">আপনি কী প্রবাসি?</label>
          <select v-model="form.is_foreign" class="form-input">
            <option value="না">না</option>
            <option value="হ্যাঁ">হ্যাঁ</option>
          </select>
        </div>
        <div v-if="form.is_foreign === 'হ্যাঁ'">
          <label class="block font-medium">দেশ</label>
          <input v-model="form.foreign_country" type="text" class="form-input" placeholder="বিদেশের দেশ" />
        </div>
        <div v-if="form.is_foreign === 'হ্যাঁ'">
          <label class="block font-medium">অবস্থান</label>
          <input v-model="form.foreign_location" type="text" class="form-input" placeholder="বিদেশের শহর/অঞ্চল" />
        </div>
        <div>
          <label class="block font-medium">ঠিকানা *</label>
          <textarea v-model="form.address" class="form-input" rows="2" required></textarea>
        </div>
        <div class="md:col-span-2">
          <label class="block font-medium">যে কোনো বিশেষ দক্ষতা *</label>
          <textarea v-model="form.skills" class="form-input" rows="2" required></textarea>
        </div>
        <div class="md:col-span-2">
          <label class="block font-medium">কোন সেবা প্রদান করতে আগ্রহী?</label>
          <textarea v-model="form.interest" class="form-input" rows="2"></textarea>
        </div>
      </div>
      <div class="text-center mt-6">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">জমা দিন</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

const form = reactive({
  name: '',
  gender: '',
  phone: '',
  alt_phone: '',
  email: '',
  fb_link: '',
  nid: '',
  education: '',
  occupation: '',
  is_foreign: 'না',
  foreign_country: '',
  foreign_location: '',
  address: '',
  skills: '',
  interest: '',
})

const submitForm = () => {
  console.log('Submitting form:', form)
  // axios.post('/api/volunteer-register', form).then(...) 
}
</script>

<style scoped>
.form-input {
  @apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500;
}
</style>
