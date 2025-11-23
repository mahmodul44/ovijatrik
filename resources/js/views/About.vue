<template>
  <div class="about-us-page bg-gray-50 min-h-screen py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

      <header class="text-center mb-16">
        <h1 class="text-6xl font-extrabold text-indigo-700 tracking-tight leading-snug">
          {{ isBangla ? 'আমাদের সম্পর্কে' : 'About Us' }}
        </h1>
        <p class="mt-4 text-xl text-gray-600 font-medium">
          {{ isBangla ? 'হাসি মুখের খুঁজে অভিযাত্রা' : 'Ovijatrik’s Journey on the Path of Hope and Change' }}
        </p>
      </header>

      <div class="space-y-20">
        
        <section class="bg-white shadow-2xl rounded-xl p-10 md:p-16 border-t-4 border-indigo-500">
          <h2 class="text-4xl font-bold text-indigo-600 mb-6 border-b-2 border-indigo-200 pb-3">
            {{ currentContent.title.about }}
          </h2>
          <p class="text-xl text-gray-700 leading-relaxed">{{ currentContent.about }}</p>
          <div class="mt-8 flex flex-wrap gap-5">
            <button class="px-8 py-3 bg-indigo-600 text-white font-semibold rounded-full hover:bg-indigo-700 transition duration-300 shadow-lg transform hover:scale-105">
              {{ isBangla ? 'আমাদের প্রজেক্টসমূহ দেখুন' : 'Explore Our Projects' }}
            </button>
            <button class="px-8 py-3 border-2 border-indigo-600 text-indigo-600 font-semibold rounded-full hover:bg-indigo-50 transition duration-300 shadow-md">
              {{ isBangla ? 'এখনই ডোনেট করুন' : 'Donate Now' }}
            </button>
          </div>
        </section>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
          
          <section class="bg-white shadow-2xl rounded-xl p-10 transform hover:scale-105 transition duration-500 border-l-4 border-green-500">
            <div class="flex items-center mb-4">
              <svg class="w-10 h-10 text-green-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7-8V6a2 2 0 012-2h4a2 2 0 012 2v2m0 8v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2"></path></svg>
              <h2 class="text-3xl font-bold text-gray-800">{{ currentContent.title.mission }}</h2>
            </div>
            <p class="text-lg text-gray-700 leading-relaxed">{{ currentContent.mission }}</p>
          </section>
          
          <section class="bg-white shadow-2xl rounded-xl p-10 transform hover:scale-105 transition duration-500 border-l-4 border-orange-500">
            <div class="flex items-center mb-4">
              <svg class="w-10 h-10 text-orange-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6m3 3h8m-8 0a2 2 0 00-2-2h-3a2 2 0 00-2 2v6a2 2 0 002 2h3a2 2 0 002-2v-6m0 0h6m-6 0h6m6 0a2 2 0 002-2V9a2 2 0 00-2-2h-3.5a2.5 2.5 0 00-2.5 2.5V17"></path></svg>
              <h2 class="text-3xl font-bold text-gray-800">{{ currentContent.title.vision }}</h2>
            </div>
            <p class="text-lg text-gray-700 leading-relaxed">{{ currentContent.vision }}</p>
          </section>
        </div>

        <section class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-3xl rounded-xl p-10 md:p-16">
          <h2 class="text-4xl font-bold mb-10 text-center border-b border-indigo-400 pb-3">
            {{ currentContent.founderMessage }}
          </h2>
          
          <div class="md:flex md:items-center space-y-8 md:space-y-0 md:space-x-12">
            <div class="flex-shrink-0 text-center">
              <img :src="message_img"
                    alt="প্রতিষ্ঠাতার ছবি" 
                    class="w-40 h-40 rounded-full object-cover mx-auto ring-4 ring-white shadow-2xl">
              <p class="mt-4 text-2xl font-semibold">{{ currentContent.founder.name }}</p>
              <p class="text-lg font-light text-indigo-200">{{ currentContent.founder.title }}</p>
            </div>
            
            <div class="flex-1">
              <blockquote class="text-2xl italic font-light leading-relaxed border-l-4 border-white pl-6">
                "{{ currentContent.message }}"
              </blockquote>
              <p class="mt-6 text-indigo-200 text-right font-medium">
                **- {{ currentContent.founder.name }}**
              </p>
            </div>
          </div>
        </section>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AboutOvijatrik',
  
  inject: ['i18n'], 

  data() {
    return {
      message_img: null,
      content: {
        bn: {
          title: {
            about: "আমরা কারা",
            mission: "আমাদের মিশন",
            vision: "আমাদের ভিশন",
            founderMessage: "প্রতিষ্ঠাতার বার্তা",
          },
           founder: {
            name: "আরিফ",
            title: "প্রতিষ্ঠাতা, অভিযাত্রিক ফাউন্ডেশন",
            }
        },
        en: {
          title: {
            about: "Who We Are",
            mission: "Our Mission",
            vision: "Our Vision",
            founderMessage: "Founder's Message",
          },
          founder: {
            name: "Arif",
            title: "Founder, Ovijatrik Foundation",
           }
        }
      }
    };
  },
  computed: {
    isBangla() {
      return this.i18n.currentLang === 'bn'; 
    },
    currentContent() {
      return this.content[this.i18n.currentLang];
    }
  },
   mounted() {
    axios.get('/api/about')
      .then(res => {
        this.about = res.data;
        this.content.en.about = res.data.about || this.content.en.about;
        this.content.bn.about = res.data.about_bn || this.content.bn.about;
        this.content.en.message = res.data.message || this.content.en.message;
        this.content.bn.message = res.data.message_bn || this.content.bn.message;
        this.content.en.mission = res.data.mission || this.content.en.mission;
        this.content.bn.mission = res.data.mission_bn || this.content.bn.mission;
        this.content.en.vision = res.data.vision || this.content.en.vision;
        this.content.bn.vision = res.data.vision_bn || this.content.bn.vision;
         if (res.data.message_img) {
          this.message_img = '/uploads/abouts/' + res.data.message_img;
        } else {
          this.message_img = '/public/uploads/abouts/default-founder.jpg';
        }
      })
      .catch(err => {
        console.error(err);
      });
  }
  // ⚠️ 'methods' ব্লক থেকে 'toggleLanguage' মুছে ফেলা হলো।
  // ⚠️ 'mounted' ব্লক থেকে স্থানীয় লজিক মুছে ফেলা হলো।
}
</script>

<style scoped>
.about-us-page {
  font-family: 'Inter', sans-serif;
}
.shadow-3xl {
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
}
</style>