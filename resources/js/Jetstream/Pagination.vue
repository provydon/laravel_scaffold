<template>
  <div>
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, p) in links" :key="p">
        <div
          v-if="link.url === null"
          class="
            mr-1
            mb-1
            px-4
            py-3
            text-sm
            leading-4
            text-gray-400
            border
            rounded
          "
          v-html="link.label"
        />

        <a
          v-if="aTag && link.url != null"
          class="
            mr-1
            mb-1
            px-4
            py-3
            text-sm
            leading-4
            border
            rounded
            hover:bg-white hover:text-indigo-500
            focus:border-indigo-500 focus:text-indigo-500
          "
          :class="{ 'bg-indigo-500 text-white': link.active }"
          :href="link.url"
          v-html="link.label"
        ></a>
        <Link
          v-if="!aTag && link.url != null"
          class="
            mr-1
            mb-1
            px-4
            py-3
            text-sm
            leading-4
            border
            rounded
            hover:bg-white hover:text-indigo-500
            focus:border-indigo-500 focus:text-indigo-500
          "
          :class="{ 'bg-indigo-500 text-white': link.active }"
          :href="link.url"
          v-html="link.label"
        >
        </Link>
      </template>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
  },
  props: {
    links: Array,
    aTag: {
      type: Boolean,
      default: false,
    },
  },
};
</script>