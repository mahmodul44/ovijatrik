<template>
  <div class="max-w-4xl mx-auto px-4 py-4">
    <div class="bg-white rounded-xl shadow-md p-6">
      <h1 class="text-2xl font-bold text-green-700 mb-4">{{ project.project_title }}</h1>
      <p class="text-sm text-gray-500 mb-2">তারিখ: {{ formatDate(project.created_at) }}</p>
      <img
        v-if="project.image"
        :src="`/${project.image}`"
        alt="Project Image"
        class="w-full h-64 object-cover rounded mb-4"
      />
      <p class="text-gray-700 leading-relaxed">{{ project.project_details }}</p>
       <button
        @click="$router ? $router.back() : window.history.back()"
        class="mt-6 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
      >
        Back
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProjectDetails',
  props: ['id'],
  data() {
    return {
      project: {}
    };
  },
  mounted() {
    this.fetchProject();
  },
  methods: {
    fetchProject() {
      fetch(`/api/project/${this.id}`)
        .then(res => res.json())
        .then(data => {
          this.project = data;
        })
        .catch(err => console.error("Error:", err));
    },
    formatDate(dateStr) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateStr).toLocaleDateString('bn-BD', options);
    }
  }
};
</script>
