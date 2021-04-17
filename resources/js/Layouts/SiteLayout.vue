<template>
  <div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <!-- Start Page Component -->
    <section class="index-hero">
      <!-- Navbar -->
      <navbar
        :canLogin="canLogin"
        :canRegister="canRegister"
        :appName="$page.props.appName"
      />
    </section>

    <!-- Main Page Content -->
    <main>
      <slot></slot>
    </main>
    <!-- End Page Component -->
  </div>
</template>

<script>
// Imports
import Navbar from "@/Components/Navbar";

// Main App
export default {
  components: {
    Navbar,
  },
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    page: String,
    title: String,
    description: String,
    appName: String,
  },
  watch: {
    title(newTitle) {
      if (newTitle) {
        document.title = newTitle;
      }
    },
    description(newDescription) {
      if (newDescription && this.title) {
        document.getElementsByTagName("meta")[
          "description"
        ].content = newDescription;
        document.title = this.title + " - " + newDescription;
      }
    },
  },
  mounted() {
    if (this.title) {
      document.title = this.title;
    }
    if (this.description && this.title) {
      document.getElementsByTagName("meta")[
        "description"
      ].content = this.description;
      document.title = this.title + " - " + this.description;
    }
  },
};
</script>

<style>
/* durations and timing functions.*/
.slide-fade-enter-active {
  transition: all 0.5s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>