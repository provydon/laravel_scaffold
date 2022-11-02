<template>
  <FilterContainer>
    <span>{{ filter.name }}</span>

    <template #filter>
      <!-- <SelectControl
        :dusk="`${filter.name}-select-filter`"
        label="label"
        class="w-full block"
        size="sm"
        v-model:selected="value"
        @change="value = $event"
        :options="filter.options"
        id="calendar"
      >
        <option value="" :selected="value == ''">&mdash;</option>
      </SelectControl> -->

      <input
        @click.once="startcalendar()"
        :dusk="`${filter.name}-select-filter`"
        label="label"
        class="
          w-full
          block
          form-control form-select form-control-sm form-select-bordered
        "
        size="sm"
        v-model="value"
        @change="value = $event"
        style="margin-bottom: 0"
        id="calendarFlat"
      />
    </template>
  </FilterContainer>
</template>

<script>
import debounce from "lodash/debounce";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";

export default {
  emits: ["change"],

  props: {
    resourceName: {
      type: String,
      required: true,
    },
    filterKey: {
      type: String,
      required: true,
    },
    lens: String,
  },

  data: () => ({
    value: null,
    debouncedHandleChange: null,
  }),

  created() {
    this.debouncedHandleChange = debounce(() => this.handleChange(), 500);
    this.setCurrentFilterValue();
  },

  mounted() {
    Nova.$on("filter-reset", this.setCurrentFilterValue);
  },

  beforeUnmount() {
    Nova.$off("filter-reset", this.setCurrentFilterValue);
  },

  watch: {
    value() {
      this.debouncedHandleChange();
    },
  },

  methods: {
    setCurrentFilterValue() {
      this.value = this.filter.currentValue;
    },

    handleChange() {
      this.$store.commit(`${this.resourceName}/updateFilterState`, {
        filterClass: this.filterKey,
        value: this.value,
      });

      this.$emit("change");
    },

    // startcalendar() {
    //   var element = document.getElementById("flatpickrCalendar");
    //   if (!element) {
    //     const vm = this;
    //     console.log("starting calender...");
    //     this.fp = flatpickr("#calendarFlat", {
    //       dateFormat: "d-m-Y",
    //       mode: "range",
    //       inline: true
    //     });

    //     setTimeout(
    //       () => {
    //         var elements =
    //           document.getElementsByClassName("flatpickr-calendar");

    //         if (elements) {
    //           var calendar = elements[0];
    //           console.log("calendar: ", calendar);
    //           calendar.setAttribute("id", "flatpickrCalendar");
    //           // vm.fp.open();
    //         }
    //       },
    //       1000,
    //       vm
    //     );
    //   }
    // },

    startcalendar() {
      var element = document.getElementById("flatpickrCalendar");
      if (element) {
        element.remove();
        console.log("removed calendar");
      }

      if (this.fp) {
        this.fp.destroy();
        console.log("destroyed calendar: ", this.fp);
      }

      const vm = this;

      console.log("starting calender...");

      this.fp = flatpickr("#calendarFlat", {
        dateFormat: "d-m-Y",
        mode: "range",
      });

      setTimeout(
        () => {
          var elements = document.getElementsByClassName("flatpickr-calendar");

          if (elements) {
            var calendar = elements[0];
            console.log("calendar: ", calendar);
            calendar.setAttribute("id", "flatpickrCalendar");
          }
        },
        1000,
        vm
      );
    },
  },

  computed: {
    filter() {
      return this.$store.getters[`${this.resourceName}/getFilter`](
        this.filterKey
      );
    },
  },
};
</script>
