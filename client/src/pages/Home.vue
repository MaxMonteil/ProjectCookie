<template>
  <main class="space-y-8">
    <!-- ENROLLED -->
    <EnrolledCoursesLayout :courses="courses" />

    <!-- SEARCH -->
    <section class="flex flex-col">
      <SearchBar
        v-model="search"
        :bg-gray="true"
        class="shadow"
      />

      <a
        href="#"
        class="text-blue-900 text-sm underline self-end mt-4"
      >
        Advanced Search
      </a>
    </section>

    <!-- TOP -->
    <TopCoursesLayout :courses="courses" />

    <!-- LINKS -->
    <section class="text-gray-600 space-y-6">
      <a
        href="#"
        class="block text-3xl leading-none font-semibold hover:underline"
      >
        See all subjects >
      </a>

      <a
        href="#"
        class="block text-3xl leading-none font-semibold hover:underline"
      >
        See all courses >
      </a>
    </section>
  </main>
</template>

<script>
import EnrolledCoursesLayout from '@/layouts/EnrolledCoursesLayout'
import TopCoursesLayout from '@/layouts/TopCoursesLayout'
import SearchBar from '@/components/inputs/SearchBar'

export default {
  name: 'Home',
  components: {
    EnrolledCoursesLayout,
    TopCoursesLayout,
    SearchBar,
  },
  data () {
    return {
      search: '',
      courses: [
        {
          id: 1,
          title: 'World History',
          subject: 'history',
          startDate: 'April 26, 2020',
          studentCount: '145, 900',
          description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis neque sed vehicula interdu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis neque sed vehicula interdu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis neque sed vehicula interdu.',
          progress: 20,
        },
        {
          id: 2,
          title: 'Microbiology',
          subject: 'science',
          startDate: 'April 26, 2020',
          studentCount: '145, 900',
          description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis neque sed vehicula interdu.',
          progress: 20,
        },
        {
          id: 3,
          title: 'Magnetism',
          subject: 'science',
          startDate: 'April 26, 2020',
          studentCount: '145, 900',
          description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis neque sed vehicula interdu.',
          progress: 20,
        },
        {
          id: 4,
          title: 'Web Development',
          subject: 'development',
          startDate: 'April 26, 2020',
          studentCount: '145, 900',
          description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis neque sed vehicula interdu.',
          progress: 20,
        },
        {
          id: 5,
          title: 'CVSP 205',
          subject: 'philosophy',
          startDate: 'April 26, 2020',
          studentCount: '145, 900',
          description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis neque sed vehicula interdu.',
          progress: 20,
        },
        {
          id: 6,
          title: 'PHIL 211',
          subject: 'philosophy',
          startDate: 'April 26, 2020',
          studentCount: '145, 900',
          description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis neque sed vehicula interdu.',
          progress: 20,
        },
        {
          id: 7,
          title: 'Linear Algebra',
          subject: 'math',
          startDate: 'April 26, 2020',
          studentCount: '145, 900',
          description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis neque sed vehicula interdu.',
          progress: 20,
        },
      ],
    }
  },
}
</script>
