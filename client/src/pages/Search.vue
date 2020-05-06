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
          :with-blur="false"
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
          v-model.number="options.price"
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
          Results {{ search ? `for: ${search}` : '' }}
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
          v-for="course in searchResults"
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

const stringCompare = (a, b) => {
  const A = a.toUpperCase()
  const B = b.toUpperCase()
  if (A < B) return -1
  if (A > B) return 1
  return 0
}

const compareFunctions = {
  subject: (a, b) => stringCompare(a.subject, b.subject),
  name: (a, b) => stringCompare(a.title, b.title),
  'price asc': (a, b) => a.price - b.price,
  'price des': (a, b) => b.price - a.price,
}

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
    searchResults () {
      const result = this.courses.filter(course => {
        const matchesSearchTerm = course.title.toLowerCase().includes(this.search.trim().toLowerCase())
        const matchesOptions = Object.entries(this.options).every(([option, value]) => !value || value === course[option])

        return matchesSearchTerm && matchesOptions
      })

      return result.sort(compareFunctions[this.sort])
    },
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
