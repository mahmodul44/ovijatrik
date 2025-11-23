<template>
  <div class="min-h-screen bg-gray-50 text-gray-800">

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="flex flex-col lg:flex-row lg:gap-8">

        <!-- Posts -->
        <section class="flex-1 space-y-6 order-2 lg:order-1">

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <article
              v-for="post in filteredPosts"
              :key="post.id"
              class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300"
            >
              <img :src="post.image" alt="post image" class="w-full h-44 object-cover" />
              <div class="p-5">
                <div class="flex items-center justify-between mb-2">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-semibold">{{ post.authorInitials }}</div>
                    <div>
                      <h3 class="text-sm font-semibold">{{ isBangla ? post.title.bn : post.title.en }}</h3>
                      <p class="text-xs text-gray-400">{{ isBangla ? post.author.bn : post.author.en }} • {{ post.readTime }} {{ isBangla ? 'মিনিটে পড়া' : 'min read' }}</p>
                    </div>
                  </div>
                  <div class="text-xs text-gray-400">{{ formatDate(post.date) }}</div>
                </div>

                <p class="text-gray-600 text-sm mb-4">{{ isBangla ? post.excerpt.bn : post.excerpt.en }}</p>

                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2">
                    <button class="text-xs px-3 py-1 rounded-full bg-green-50 text-green-600">{{ isBangla ? post.category.bn : post.category.en }}</button>
                    <div class="text-sm text-gray-400">❤️ {{ post.likes }}</div>
                  </div>

                  <a href="#" class="text-indigo-600 text-sm font-medium">{{ isBangla ? 'আরও পড়ুন →' : 'Read more →' }}</a>
                </div>
              </div>
            </article>
          </div>

          <!-- Pagination -->
          <div class="flex items-center justify-center mt-3 space-x-1">
            <button class="px-3 py-1 rounded-l-md border border-r-0 border-gray-200 bg-white">{{ isBangla ? 'পূর্ববর্তী' : 'Prev' }}</button>
            <div class="px-4 py-1 border-t border-b border-gray-200 bg-white">1</div>
            <button class="px-3 py-1 rounded-r-md border border-l-0 border-gray-200 bg-white">{{ isBangla ? 'পরবর্তী' : 'Next' }}</button>
          </div>

        </section>

        <!-- Sidebar -->
        <aside class="flex-none w-full lg:w-80 space-y-6 mb-8 lg:mb-0 order-1 lg:order-2">
          <div class="bg-white p-4 rounded-2xl shadow-sm">
            <h4 class="font-semibold mb-3">{{ isBangla ? 'Ovijatrik সম্পর্কে' : 'About Ovijatrik' }}</h4>
            <div class="flex items-center gap-3">
              <img src="./logo_bgtransparent.png" alt="Ovijatrik Logo" class="w-14 h-14 rounded-full bg-gray-100 p-1"/>
              <div>
                <div class="font-semibold">Ovijatrik Foundation</div>
                <div class="text-sm text-gray-400">{{ isBangla ? 'হাসিমুখের খুঁজে অভিযাত্রা' : 'A journey in search of a smile' }}</div>
              </div>
            </div>
            <p class="text-sm text-gray-500 mt-3">
              {{ isBangla
                ? 'অভিযাত্রিক একটি অলাভজনক সংস্থা যা বাংলাদেশে শিক্ষা, যুব ক্ষমতায়ন এবং টেকসই কমিউনিটি উন্নয়নে নিবেদিত।'
                : 'Ovijatrik is a non-profit organization dedicated to improving education, youth empowerment, and sustainable community development in Bangladesh.' }}
            </p>
          </div>

          <div class="bg-white p-4 rounded-2xl shadow-sm">
            <h4 class="font-semibold mb-3">{{ isBangla ? 'কার্যক্রম' : 'Causes' }}</h4>
            <div class="flex flex-wrap gap-2">
              <button v-for="cat in categories" :key="cat.en" class="text-xs px-3 py-1 rounded-full bg-gray-100">{{ isBangla ? cat.bn : cat.en }}</button>
            </div>
          </div>

          <div class="bg-white p-4 rounded-2xl shadow-sm">
            <h4 class="font-semibold mb-3">{{ isBangla ? 'জনপ্রিয় ট্যাগসমূহ' : 'Popular Tags' }}</h4>
            <div class="flex flex-wrap gap-2">
              <button v-for="tag in tags" :key="tag" class="text-xs px-2 py-1 rounded bg-green-50 text-green-600">{{ tag }}</button>
            </div>
          </div>

          <div class="bg-white p-4 rounded-2xl shadow-sm">
            <h4 class="font-semibold mb-3">{{ isBangla ? 'যোগ দিন' : 'Get Involved' }}</h4>
            <p class="text-sm text-gray-500 mb-3">{{ isBangla ? 'একটি ভালো আগামী তৈরি করতে আমাদের মিশনে যোগ দিন।' : 'Join our mission to create a better tomorrow.' }}</p>
            <div class="flex gap-2 flex-col sm:flex-row">
              <input placeholder="Email address" class="flex-1 rounded-lg border border-gray-200 px-3 py-2 text-sm" />
              <button class="px-3 py-2 rounded-lg bg-green-600 text-white text-sm hover:bg-green-700">{{ isBangla ? 'সাবস্ক্রাইব করুন' : 'Subscribe' }}</button>
            </div>
          </div>

        </aside>
      </div>
    </main>

  </div>
</template>

<script>
import { inject, computed, ref } from 'vue'

export default {
  name: 'OvijatrikBlog',
  setup() {
    const i18n = inject('i18n', null)
    const currentLang = computed(() => i18n?.currentLang ?? 'en')
    const isBangla = computed(() => currentLang.value === 'bn')

    const posts = ref([
      {
        id: 1,
        title: { en: 'Empowering Underprivileged Children through Education', bn: 'শিক্ষার মাধ্যমে সুবিধাবঞ্চিত শিশুদের ক্ষমতায়ন' },
        author: { en: 'Ovijatrik Team', bn: 'Ovijatrik টিম' },
        authorInitials: 'O',
        readTime: 6,
        date: '2025-10-20',
        excerpt: { en: 'Learn how Ovijatrik Foundation is transforming lives through community-based education programs and youth-led initiatives.', bn: 'জানুন কীভাবে Ovijatrik Foundation কমিউনিটি-ভিত্তিক শিক্ষা প্রোগ্রাম এবং যুব-নেতৃত্বাধীন উদ্যোগের মাধ্যমে জীবন পরিবর্তন করছে।' },
        image: '/uploads/blogs/1.jpg',
        category: { en: 'Education', bn: 'শিক্ষা' },
        likes: 230
      },
      {
        id: 2,
        title: { en: 'Sustainable Projects for Rural Communities', bn: 'গ্রামীণ কমিউনিটির জন্য টেকসই প্রকল্প' },
        author: { en: 'Ovijatrik Team', bn: 'Ovijatrিক টিম' },
        authorInitials: 'O',
        readTime: 8,
        date: '2025-09-18',
        excerpt: { en: 'From clean water systems to solar-powered schools — our sustainability projects are creating long-term impact.', bn: 'পরিষ্কার পানি সিস্টেম থেকে সৌর-শক্তি বিদ্যালয় পর্যন্ত — আমাদের টেকসই প্রকল্প দীর্ঘমেয়াদী প্রভাব তৈরি করছে।' },
        image: '/uploads/blogs/2.jpg',
        category: { en: 'Sustainability', bn: 'টেকসই উন্নয়ন' },
        likes: 190
      },
      {
        id: 3,
        title: { en: 'Youth Empowerment Through Leadership Training', bn: 'নেতৃত্ব প্রশিক্ষণের মাধ্যমে যুব ক্ষমতায়ন' },
        author: { en: 'Ovijatrik Team', bn: 'Ovijatrিক টিম' },
        authorInitials: 'O',
        readTime: 5,
        date: '2025-08-29',
        excerpt: { en: 'We believe in the potential of youth to drive social change. Our leadership programs nurture confidence and skills.', bn: 'আমরা বিশ্বাস করি যুবকদের সামাজিক পরিবর্তন চালানোর সম্ভাবনা রয়েছে। আমাদের নেতৃত্ব প্রোগ্রাম আত্মবিশ্বাস এবং দক্ষতা বিকাশ করে।' },
        image: '/uploads/blogs/3.jpg',
        category: { en: 'Youth', bn: 'যুব ক্ষমতায়ন' },
        likes: 145
      },
      {
        id: 4,
        title: { en: 'Healthcare Support for Marginalized Families', bn: 'সীমান্ত পরিবারগুলোর জন্য স্বাস্থ্য সহায়তা' },
        author: { en: 'Ovijatrik Team', bn: 'Ovijatrিক টিম' },
        authorInitials: 'O',
        readTime: 10,
        date: '2025-07-12',
        excerpt: { en: 'Through health camps and awareness programs, Ovijatrik ensures access to basic healthcare for the underserved.', bn: 'স্বাস্থ্য ক্যাম্প এবং সচেতনতামূলক প্রোগ্রামের মাধ্যমে Ovijatrik সুবিধাবঞ্চিতদের জন্য মৌলিক স্বাস্থ্যসেবা নিশ্চিত করে।' },
        image: '/uploads/blogs/4.jpg',
        category: { en: 'Healthcare', bn: 'স্বাস্থ্য' },
        likes: 305
      }
    ])

    const categories = [
      { en: 'Education', bn: 'শিক্ষা' },
      { en: 'Healthcare', bn: 'স্বাস্থ্য' },
      { en: 'Sustainability', bn: 'টেকসই উন্নয়ন' },
      { en: 'Youth Empowerment', bn: 'যুব ক্ষমতায়ন' }
    ]

    const tags = ['charity', 'education', 'volunteer', 'community', 'empowerment']

    const query = ref('')

    const filteredPosts = computed(() => {
      if (!query.value) return posts.value
      const q = query.value.toLowerCase()
      return posts.value.filter(p =>
        p.title.en.toLowerCase().includes(q) ||
        p.excerpt.en.toLowerCase().includes(q) ||
        p.category.en.toLowerCase().includes(q) ||
        p.title.bn.toLowerCase().includes(q) ||
        p.excerpt.bn.toLowerCase().includes(q) ||
        p.category.bn.toLowerCase().includes(q)
      )
    })

    const formatDate = (d) => {
      const dt = new Date(d)
      return dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })
    }

    return { posts, categories, tags, query, filteredPosts, isBangla, formatDate }
  }
}
</script>

<style scoped>
.swash {
  letter-spacing: -0.01em;
}
</style>
