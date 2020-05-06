<template>
  <main class="space-y-12">
    <!-- SEARCH -->
    <form
      class="space-y-6"
      @submit.prevent
    >
      <div class="flex space-x-4">
        <SearchBar
          v-model="search"
          :bg-gray="true"
          class="shadow"
        />

        <button
          type="submit"
          class="btn btn-blue"
        >
          Search
        </button>
      </div>

      <div class="flex space-x-12">
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

        <InputSelect
          v-model="options.price"
          label="Price"
          :values="searchOptions.price"
        />

        <InputSelect
          v-model="options.startDate"
          label="Start Date"
          :values="searchOptions.startDate"
        />
      </div>
    </form>

    <div class="space-y-4">
      <header class="flex justify-between">
        <h1 class="text-3xl leading-none font-semibold mb-6">
          Results
        </h1>

        <InputSelect
          v-model="sort"
          label="Order by:"
          :label-black="true"
          :label-inline="true"
          :values="sortOptions"
        />
      </header>

      <section class="grid grid-cols-4 gap-8">
        <DetailedClassCard
          v-for="course in courses"
          :key="course.id"
          :course="course"
        />
      </section>
    </div>
  </main>
</template>

<script>
import courses from '../../courses.json'

import InputSelect from '@/components/inputs/InputSelect'
import SearchBar from '@/components/inputs/SearchBar.vue'
import DetailedClassCard from '@/components/ui/classCard/DetailedClassCard'

export default {
  name: 'Search',
  components: {
    InputSelect,
    SearchBar,
    DetailedClassCard,
  },
  data () {
    return {
      courses,
      search: '',
      sort: '',
      sortOptions: [
        'subject',
        'name',
        'price asc',
        'price des',
      ],
      options: {
        subject: '',
        language: '',
        price: '',
        startDate: '',
      },
    }
  },
  computed: {
    searchOptions () {
      const options = {
        subject: [],
        language: [],
        price: [],
        startDate: [],
      }

      for (const course of courses) {
        Object.keys(options).forEach(option => {
          if (!options[option].includes(course[option])) {
            options[option].push(course[option])
          }
        })
      }

      return options
    },
  },
}
</script>
