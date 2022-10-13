<template>
  <site-layout>
    <section class="container index-body">
      <div class="flex flex-col justify-center items-center pt-8">
        <img
          class="fill-current h-16 w-auto sm:h-20 object-contain"
          src="/images/company_logo.png"
        />
        <a href="/">
        <h3 class="my-5">{{ appName }}</h3>
        </a>
      </div>
    </section>
  </site-layout>
</template>

<script>
import SiteLayout from "@/Layouts/SiteLayout.vue";

export default {
  props: { appName: String },
  components: {
    SiteLayout,
  },
};
</script>