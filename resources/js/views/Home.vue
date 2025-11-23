<template>
  <section id="home" class="relative p-4 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="absolute inset-0">
      <img
        src="https://d64gsuwffb70l.cloudfront.net/68b3328b1e58a822a5b77f57_1756574391745_b407f7a4.webp"
        alt="Volunteers helping community"
        class="w-full h-full object-cover opacity-30"
      />
      <div class="absolute inset-0 bg-blue-900 opacity-50"></div>
    </div>

    <div class="relative container mx-auto px-4 py-20">
      <div class="max-w-3xl">
        <h1 class="text-5xl md:text-6xl font-bold mb-6">
          {{ i18n.t('headline').split(' ').slice(0, 3).join(' ') }}
          <span class="block text-orange-400">{{ i18n.t('headline').split(' ').slice(3).join(' ') }}</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-blue-100">
          {{ i18n.t('subtitle') }}
        </p>

        <div class="flex flex-col sm:flex-row gap-4 mb-12">
          <button
            @click="onDonateClick"
            class="bg-orange-500 text-white px-8 py-4 rounded-lg hover:bg-orange-600 transition-colors font-semibold text-lg flex items-center justify-center"
          >
            {{ i18n.t('donate_now') }}
            </button>
          <button
            class="border-2 border-white text-white px-8 py-4 rounded-lg hover:bg-white hover:text-blue-800 transition-colors font-semibold text-lg"
          >
            {{ i18n.t('learn_more') }}
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 
                4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 
                4.5 0 010-6.364z" />
            </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">50,000+</h3>
            <p class="text-blue-100">{{ i18n.t('lives_impacted') }}</p>
          </div>
          <div class="text-center">
            <div class="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 15a4 4 0 014-4h4m0 0a4 4 0 014 4m-4-4v-3a4 4 0 118 0v3m-6 
              4h6m-3 4v1m-8-5h-3a2 2 0 00-2 2v3h5v-5z" />
            </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">25,000+</h3>
            <p class="text-blue-100">{{ i18n.t('active_donors') }}</p>
          </div>
          <div class="text-center">
            <div class="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
             <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 3C7.03 3 3 7.03 3 12s4.03 9 9 9
              9-4.03 9-9-4.03-9-9-9zM3.6 9h16.8M3.6 
              15h16.8M12 3c2.5 3 2.5 15 0 18m0-18c-2.5 
              3-2.5 15 0 18" />
          </svg>
          </div>
            <h3 class="text-xl font-semibold mb-2">45+</h3>
            <p class="text-blue-100">{{ i18n.t('countries_served') }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="bg-white shadow-2xl rounded-xl p-10 md:p-16 border-t-4 border-indigo-500">
  <h2 class="text-4xl font-bold text-indigo-600 mb-6 border-b-2 border-indigo-200 pb-3">
    {{ currentContent.title }}
  </h2>

  <p class="text-xl text-gray-700 leading-relaxed">
    <span v-if="expandedAbout">
      {{ currentContent.about }}
    </span>
    <span v-else>
      {{
        currentContent.about.length > 150
          ? currentContent.about.slice(0, 150) + "..."
          : currentContent.about
      }}
    </span>

    <button
      v-if="currentContent.about.length > 150"
      @click="toggleAbout"
      class="text-blue-600 font-medium hover:underline ml-1"
    >
      {{ expandedAbout ? (isBangla ? 'কম দেখাও' : 'See less') : (isBangla ? 'আরও দেখাও' : 'See more') }}
    </button>
  </p>

  <div class="mt-8 flex flex-wrap gap-5">
    <router-link
      to="/about"
      class="px-8 py-3 bg-indigo-600 text-white font-semibold rounded-full hover:bg-indigo-700 transition duration-300 shadow-lg transform hover:scale-105"
    >
      {{ isBangla ? 'আরও পড়ুন' : 'Read More' }}
    </router-link>

    <button class="px-8 py-3 border-2 border-indigo-600 text-indigo-600 font-semibold rounded-full hover:bg-indigo-50 transition duration-300 shadow-md">
      {{ isBangla ? 'এখনই ডোনেট করুন' : 'Donate Now' }}
    </button>
  </div>
</section>
<section class="py-16 bg-gray-50">
  <div class="container mx-auto px-6">
    <h2 class="text-4xl font-bold text-center text-gray-800 mb-10">
       {{ isBangla ? 'আয়-ব্যয়ের নীতিমালা' : 'Income-Expense Policy' }}
    </h2>

    <div class="bg-white shadow-lg rounded-2xl p-6 md:p-10">
      <div class="flex justify-center mb-8 flex-wrap gap-3">
  <button
    v-for="tab in localizedTabs"
    :key="tab.key"
    @click="activeTab = tab.key"
    :class="[
      'flex items-center gap-2 px-6 py-3 rounded-full border transition-all duration-300 font-semibold',
      activeTab === tab.key
        ? 'bg-green-100 border-green-500 text-green-800'
        : 'border-gray-300 text-gray-600 hover:bg-gray-100'
    ]"
  >
      <span v-html="tab.icon" class="w-5 h-5"></span>
    {{ tab.label }}
  </button>
</div>


      <!-- Tab Content -->
      <div class="p-6 border rounded-2xl bg-gray-50">
        <ul class="space-y-3">
          <li
            v-for="(item, index) in currentTabContent"
            :key="index"
            class="flex items-start gap-2 text-lg text-gray-700"
          >
            <span class="text-green-500 text-xl">✔</span>
            <span>{{ item }}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
  <section id="campaigns" class="bg-gray-100 py-12">
    <div class="container mx-auto px-4">
      <Campaign />
    </div>
  </section> 

  <section id="activities" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ i18n.t('Activities') }}</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Join us in making a difference through community events, volunteer opportunities, and impact initiatives.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="activity in activities"
          :key="activity.id"
          class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
        >
          <img :src="activity.image" :alt="activity.title" class="w-full h-48 object-cover" />
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-3">{{ activity.title }}</h3>
            <p class="text-gray-600 mb-4 text-sm">{{ activity.description }}</p>

            <div class="space-y-2 mb-4">
              <div class="flex items-center text-sm text-gray-600">
                {{ activity.date }}
              </div>
              <div class="flex items-center text-sm text-gray-600">
                {{ activity.time }}
              </div>
              <div class="flex items-center text-sm text-gray-600">
                {{ activity.location }}
              </div>
              <div class="flex items-center text-sm text-gray-600">
                {{ activity.participants }} {{ i18n.t('expected_participants') }}
              </div>
            </div>

           
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { inject, computed, ref, onMounted  } from 'vue';
import { useRouter } from 'vue-router';
import Campaign from './Campaign.vue' 
const i18n = inject('i18n');

const onDonateClick = () => {
  alert('Donate button clicked! (Language: ' + i18n.currentLang + ')')
}

const router = useRouter()

const expandedAbout = ref(false)
const isBangla =  computed(() => i18n.currentLang === 'bn') 

const aboutData = ref({
  about: '',
  about_bn: ''
})

// ✅ API থেকে ডেটা লোড করা
onMounted(() => {
  axios.get('/api/about')
    .then(res => {
      aboutData.value = res.data
    })
    .catch(err => {
      console.error('About API error:', err)
    })
})

const currentContent = computed(() => ({
  title: isBangla.value ? 'আমাদের সম্পর্কে' : 'About Us',
  about: isBangla.value
    ? aboutData.value.about_bn || 'আমাদের প্রতিষ্ঠান সম্পর্কে তথ্য লোড করা যাচ্ছে না।'
    : aboutData.value.about || 'Unable to load about content.'
}))

// --- tabs as you already have (keep it) ---
const tabs = ref([
  {
    key: "income",
    label_bn: "আয়ের উৎস",
    label_en: "Sources of Income",
    icon: `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round' class='w-6 h-6 text-green-600 transition-transform duration-300 group-hover:scale-110'>
      <path d='M12 3v18m0-18c4.418 0 8 3.582 8 8s-3.582 8-8 8-8-3.582-8-8 3.582-8 8-8z'/>
      <path d='M8 12h8M12 8v8'/>
    </svg>`,
  },
  {
    key: "service",
    label_bn: "সেবামূলক ব্যয়",
    label_en: "Service Expenses",
    icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
      <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
        d='M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 
        4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 
        4.5 0 010-6.364z'/>
    </svg>`,
  },
  {
    key: "management",
    label_bn: "ব্যবস্থাপনা ব্যয়",
    label_en: "Management Expenses",
    icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
      <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
        d='M12 8c2.21 0 4 1.79 4 4H8c0-2.21 1.79-4 4-4z'/>
      <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
        d='M6 12v6h12v-6'/>
    </svg>`,
  },
]);

// --- localizedTabs: computed mapping that picks the right label for each tab ---
const localizedTabs = computed(() => {
  // use isBangla (computed) — template auto-unwrapping makes it fine too
  const useBn = isBangla.value;
  return tabs.value.map(t => ({
    ...t,
    label: useBn ? t.label_bn : t.label_en
  }))
})


// Active tab state
const activeTab = ref("income");

// Static content for tabs (Bangla + English)
const contentData = {
  income: {
    bn: [
      "বিভিন্ন ব্যক্তি ও প্রতিষ্ঠান থেকে প্রাপ্ত স্বেচ্ছা অনুদান ও অর্থসাহাযতা।",
      "সদস্য, সমর্থক ও শুভাকাঙ্ক্ষীদের এককালীন ও নিয়মিত অনুদান।",
      "ফাউন্ডেশনের প্রকল্পের জন্য সংগৃহীত অর্থ।",
      "সহজলভ্য মুনাফার প্রাপ্তি।",
      "ইফতার ও কুরবানিসহ বিশেষ খাতে তহবিলকৃত অর্থ।",
      "ফাউন্ডেশনের অন্যান্য উৎস থেকে আয়।",
    ],
    en: [
      "Voluntary donations and contributions from individuals and organizations.",
      "One-time and regular contributions from members and supporters.",
      "Funds collected for various foundation projects.",
      "Earnings from approved investments.",
      "Funds raised for special purposes like Iftar and Qurbani.",
      "Income from other foundation sources.",
    ],
  },
  service: {
    bn: [
      "গরীব ও অসহায়দের চিকিৎসা ও খাদ্য সহায়তা।",
      "শিক্ষা, প্রশিক্ষণ ও সামাজিক উন্নয়নমূলক কার্যক্রমে ব্যয়।",
      "প্রাকৃতিক দুর্যোগে ক্ষতিগ্রস্তদের সহায়তা।",
    ],
    en: [
      "Medical and food aid for the poor and needy.",
      "Expenses on education, training, and social development activities.",
      "Support for victims of natural disasters.",
    ],
  },
  management: {
    bn: [
      "ফাউন্ডেশনের দৈনন্দিন প্রশাসনিক ব্যয়।",
      "কর্মচারী ও কর্মকর্তাদের বেতন-ভাতা।",
      "অফিস পরিচালনা, রক্ষণাবেক্ষণ ও যোগাযোগ ব্যয়।",
    ],
    en: [
      "Daily administrative expenses of the foundation.",
      "Salaries and allowances for employees and officers.",
      "Office maintenance and communication costs.",
    ],
  },
};

const currentTabContent = computed(() => {
  const lang = isBangla.value ? "bn" : "en";
  return contentData[activeTab.value][lang];
});

// Toggle About section expand/collapse
function toggleAbout() {
  expandedAbout.value = !expandedAbout.value
}

const activities = [
  {
    id: 1,
    title: "Community Health Fair",
    date: "March 15, 2024",
    time: "9:00 AM - 4:00 PM",
    location: "Central Park Community Center",
    participants: 150,
    description: "Free health screenings, vaccinations, and wellness education for families.",
    image:
      "https://d64gsuwffb70l.cloudfront.net/68b3328b1e58a822a5b77f57_1756574424953_0739b9ab.webp",
  },
  {
    id: 2,
    title: "School Supply Drive",
    date: "March 22, 2024",
    time: "10:00 AM - 2:00 PM",
    location: "Hope Foundation Center",
    participants: 75,
    description: "Collecting and distributing school supplies to underprivileged students.",
    image:
      "https://d64gsuwffb70l.cloudfront.net/68b3328b1e58a822a5b77f57_1756574418107_b5bcc467.webp",
  },
  {
    id: 3,
    title: "Clean Water Initiative Launch",
    date: "April 5, 2024",
    time: "11:00 AM - 3:00 PM",
    location: "Rural Development Site",
    participants: 200,
    description: "Launching new water well projects in underserved communities.",
    image:
      "https://d64gsuwffb70l.cloudfront.net/68b3328b1e58a822a5b77f57_1756574396029_1859e819.webp",
  },
];
</script>

<style scoped>
/* Add any additional styles here if needed */
</style>
