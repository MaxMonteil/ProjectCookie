<template>
  <div class="space-y-12">
    <form
      class="space-y-6"
      @submit.prevent="handleSearch"
    >
      <div class="flex space-x-6">
        <input
          v-model="searchTerm"
          placeholder="Search"
          class="block w-full py-1 pl-2 text-black placeholder-gray-600 rounded outline-none transition-opacity duration-100 focus:shadow focus:opacity-100"
          :class="[
            bgGray ? 'bg-gray-200' : 'bg-white',
            withOpacity ? 'opacity-50' : 'opacity-100',
          ]"
        >

        <button
          v-if="showButton"
          type="submit"
          class="btn btn-blue"
        >
          Search
        </button>
      </div>

      <div
        v-if="showAdvanced"
        class="flex items-end space-x-8"
      >
        <InputSelect
          v-model="options.subject"
          label="Subjects"
          :values="searchOptions.subject"
        />

        <InputSelect
          v-model="options.language"
          label="Language"
          :values="searchOptions.language"
        />

        <InputText
          v-model.number="options.price"
          label="Price"
          class="w-16"
          :bg-gray="true"
          :label-white="false"
        />
      </div>
    </form>

    <slot
      :courses="courses"
      :error="error"
      :loading="loading"
      :search-term="searchTerm"
    />
  </div>
</template>

<script>
import InputSelect from '@/components/inputs/InputSelect'
import InputText from '@/components/inputs/InputText'

export default {
  name: 'SearchBar',
  components: {
    InputSelect,
    InputText,
  },
  props: {
    getAllCourses: {
      type: Boolean,
      default: false,
    },
    searchQuery: {
      type: String,
      default: '',
    },
    bgGray: {
      type: Boolean,
      default: false,
    },
    withOpacity: {
      type: Boolean,
      default: false,
    },
    withBlur: {
      type: Boolean,
      default: true,
    },
    showButton: {
      type: Boolean,
      default: false,
    },
    showAdvanced: {
      type: Boolean,
      default: false,
    },
  },
  data () {
    return {
      loading: true,
      error: '',
      searchTerm: '',
      courses: [{}],
      options: {
        subject: '',
        language: '',
        price: null,
      },
      searchOptions: {
        subject: [],
        language: [],
      },
    }
  },
  created () {
    this.getAllCourses && this.fetchCourses()
    console.log(this.$route.params)

    if (this.$route.query.q) {
      this.searchTerm = this.$route.query.q
      this.handleSearch(null, this.$route.params.options)
    }
  },
  methods: {
    async handleSearch (_, optionsParam = {}) {
      if (this.$route.name !== 'search') {
        this.$router.push({ name: 'search', query: { q: this.searchTerm } })
      }
      try {
        const {
          searchOptions,
          courses,
        } = await this.$api.search.withOptions({
          search: this.searchTerm,
          options: {
            ...this.options,
            ...optionsParam,
          },
        })

        this.searchOptions = searchOptions
        this.courses = courses
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
    async fetchCourses () {
      try {
        this.courses = await this.$api.search.getAllCourses()
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
}
</script>
