// app.js

import './bootstrap';
import '../css/app.css';

// Alpine.js
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

window.Alpine = Alpine;
Alpine.plugin(persist);
Alpine.start();

// Vue
// reactive ইমপোর্ট করা হলো
import { createApp, reactive } from 'vue'; 
import router from './router';
import App from './App.vue';


const globalI18nState = reactive({
    currentLang: 'bn', 
    
    initLang() {
        this.currentLang = localStorage.getItem('appLang') || 'bn';
    },

    toggleLang(langCode) {
        globalI18nState.currentLang = langCode;
        localStorage.setItem('appLang', langCode); 
        console.log(`Language set to: ${langCode}`);
    },

    translations: {
        bn: {
            home: 'হোম', about: 'আমাদের সম্পর্কে', project: 'চলমান প্রকল্প',
            volunteer: 'আমাদের সাথে যুক্ত হোন', blog: 'ব্লগ', gallery: 'গ্যালারী',
            contact: 'যোগাযোগ',
            // Home page এর জন্য কিছু অনুবাদ (উদাহরণস্বরূপ)
            headline: 'একসাথে আমরা জীবন বদলে দিতে পারি',
            subtitle: 'বিশ্বজুড়ে মানুষের জন্য আশা, শিক্ষা ও প্রয়োজনীয় সম্পদ নিয়ে কাজ করছে অভিযাত্রিক। প্রতিটি অনুদানই দীর্ঘস্থায়ী প্রভাব ফেলে।',
            donate_now: 'এখনই ডোনেট করুন',
            learn_more: 'আরও জানুন',
            lives_impacted: 'মানুষের জীবনে প্রভাব',
            active_donors: 'সক্রিয় দাতা',
            countries_served: 'দেশের সেবা',
            our_campaigns: 'আমাদের প্রচারাভিযান',
            upcoming_activities: 'আসন্ন কার্যক্রম',
            join_event: 'ইভেন্টে যোগ দিন',
            expected_participants: 'জন অংশগ্রহণকারী',
        },
        en: {
            home: 'Home', about: 'About', project: 'Project',
            volunteer: 'Connect With Us', blog: 'Blog', gallery: 'Gallery',
            contact: 'Contact',
            // Home page এর জন্য কিছু অনুবাদ (উদাহরণস্বরূপ)
            headline: 'Together We Can Change Lives',
            subtitle: 'Join our mission to bring hope, education, and essential resources to communities worldwide. Every donation creates lasting impact.',
            donate_now: 'Donate Now',
            learn_more: 'Learn More',
            lives_impacted: 'Lives Impacted',
            active_donors: 'Active Donors',
            countries_served: 'Countries Served',
            our_campaigns: 'Our Campaigns',
            upcoming_activities: 'Upcoming Activities',
            join_event: 'Join Event',
            expected_participants: 'expected participants',
        }
    },
    t: (key) => globalI18nState.translations[globalI18nState.currentLang][key] || key,
});


globalI18nState.initLang();

const app = createApp(App);

app.use(router)
    // 'i18n' নামে গ্লোবাল স্টেট সরবরাহ (Provide) করা হচ্ছে
    .provide('i18n', globalI18nState) 
    .mount('#app');