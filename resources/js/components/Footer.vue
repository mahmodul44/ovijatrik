<template>
  <footer class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 py-12">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Organization Info -->
        <div>
          <div class="flex items-center mb-4">
            <Heart class="text-orange-400 mr-2" size="28" />
            <h3 class="text-xl font-bold">Ovijatrik</h3>
          </div>
          <p class="text-gray-400 mb-4">
            {{ i18n?.currentLang === 'bn'
              ? 'বিশ্বজুড়ে কমিউনিটিতে স্থায়ী ইতিবাচক পরিবর্তন আনার জন্য শিক্ষা, স্বাস্থ্যসেবা এবং টেকসই উন্নয়নের মাধ্যমে কাজ করে।'
              : 'Dedicated to creating lasting positive change in communities worldwide through education, healthcare, and sustainable development.' }}
          </p>
          <div class="flex space-x-4">
            <Facebook class="text-gray-400 hover:text-white cursor-pointer transition-colors" size="20" />
            <Twitter class="text-gray-400 hover:text-white cursor-pointer transition-colors" size="20" />
            <Instagram class="text-gray-400 hover:text-white cursor-pointer transition-colors" size="20" />
            <Linkedin class="text-gray-400 hover:text-white cursor-pointer transition-colors" size="20" />
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="text-lg font-semibold mb-4">
            {{ i18n?.currentLang === 'bn' ? 'দ্রুত লিঙ্কসমূহ' : 'Quick Links' }}
          </h4>
          <ul class="space-y-2">
            <li><a href="#home" class="text-gray-400 hover:text-white transition-colors">{{ i18n?.currentLang === 'bn' ? 'হোম' : 'Home' }}</a></li>
            <li><a href="#campaigns" class="text-gray-400 hover:text-white transition-colors">{{ i18n?.currentLang === 'bn' ? 'প্রচারণা' : 'Campaigns' }}</a></li>
            <li><a href="#activities" class="text-gray-400 hover:text-white transition-colors">{{ i18n?.currentLang === 'bn' ? 'কার্যক্রম' : 'Activities' }}</a></li>
            <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">{{ i18n?.currentLang === 'bn' ? 'আমাদের সম্পর্কে' : 'About Us' }}</a></li>
            <li><a href="#volunteer" class="text-gray-400 hover:text-white transition-colors">{{ i18n?.currentLang === 'bn' ? 'স্বেচ্ছাসেবক' : 'Volunteer' }}</a></li>
          </ul>
        </div>

        <!-- Programs -->
        <div>
          <h4 class="text-lg font-semibold mb-4">{{ i18n?.currentLang === 'bn' ? 'আমাদের প্রোগ্রাম' : 'Our Programs' }}</h4>
          <ul class="space-y-2">
            <li><a href="#education" class="text-gray-400 hover:text-white transition-colors">{{ i18n?.currentLang === 'bn' ? 'শিক্ষা' : 'Education' }}</a></li>
            <li><a href="#healthcare" class="text-gray-400 hover:text-white transition-colors">{{ i18n?.currentLang === 'bn' ? 'স্বাস্থ্যসেবা' : 'Healthcare' }}</a></li>
            <li><a href="#water" class="text-gray-400 hover:text-white transition-colors">{{ i18n?.currentLang === 'bn' ? 'পরিষ্কার পানি' : 'Clean Water' }}</a></li>
            <li><a href="#emergency" class="text-gray-400 hover:text-white transition-colors">{{ i18n?.currentLang === 'bn' ? 'জরুরি সহায়তা' : 'Emergency Relief' }}</a></li>
            <li><a href="#community" class="text-gray-400 hover:text-white transition-colors">{{ i18n?.currentLang === 'bn' ? 'কমিউনিটি উন্নয়ন' : 'Community Development' }}</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h4 class="text-lg font-semibold mb-4">{{ i18n?.currentLang === 'bn' ? 'যোগাযোগ করুন' : 'Contact Us' }}</h4>
          <div class="space-y-3">
            <div class="flex items-center">
              <MapPin class="text-orange-400 mr-3" size="16" />
              <span class="text-gray-400">{{ i18n?.currentLang === 'bn' ? 'ইসলামবাগ, দিনাজপুর, বাংলাদেশ' : 'Islambagh, Dinajpur, Bangladesh' }}</span>
            </div>
            <div class="flex items-center">
              <Phone class="text-orange-400 mr-3" size="16" />
              <span class="text-gray-400">01717 017 645</span>
            </div>
            <div class="flex items-center">
              <Mail class="text-orange-400 mr-3" size="16" />
              <span class="text-gray-400">info@ovijatrik.org</span>
            </div>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-800 mt-8 pt-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <p class="text-gray-400 text-sm">
            {{ i18n?.currentLang === 'bn' ? '© 2025 Ovijatrik. সর্বস্বত্ব সংরক্ষিত।' : '© 2025 Ovijatrik. All rights reserved.' }}
          </p>
          <div class="flex space-x-6 mt-4 md:mt-0">
            <a href="#privacy" class="text-gray-400 hover:text-white text-sm transition-colors">{{ i18n?.currentLang === 'bn' ? 'গোপনীয়তা নীতি' : 'Privacy Policy' }}</a>
            <a href="#terms" class="text-gray-400 hover:text-white text-sm transition-colors">{{ i18n?.currentLang === 'bn' ? 'পরিষেবার শর্তাবলী' : 'Terms of Service' }}</a>
            <a href="#transparency" class="text-gray-400 hover:text-white text-sm transition-colors">{{ i18n?.currentLang === 'bn' ? 'আর্থিক স্বচ্ছতা' : 'Financial Transparency' }}</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { inject } from 'vue'

const i18n = inject('i18n')
</script>
