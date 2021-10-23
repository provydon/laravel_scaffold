<template>
  <div>
    <h3 class="text-sm uppercase tracking-wide text-80 bg-30 p-3">
      {{ filter.name }}
    </h3>

    <div class="p-2">
      <div class="w-full mb-3">
        <label for="start_date">Start Date</label>
        <input
          class="w-full form-control form-input form-input-bordered"
          ref="datePicker"
          type="date"
          :placeholder="'Sttart Date'"
          name="start_date"
          @change="change1"
        />
      </div>
      <div class="w-full mb-3">
        <label for="end_date">End Date</label>
        <input
          class="w-full form-control form-input form-input-bordered"
          ref="datePicker"
          type="date"
          :placeholder="'End Date'"
          name="end_date"
          @change="change2"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    resourceName: {
      type: String,
      required: true,
    },
    filterKey: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      values: [],
    };
  },

  methods: {
    change1(event) {
      this.values[0] = event.target.value;
      this.handleChange();
    },
    change2(event) {
      this.values[1] = event.target.value;
      this.handleChange();
    },
    handleChange() {
      this.$store.commit(`${this.resourceName}/updateFilterState`, {
        filterClass: this.filterKey,
        value: this.values,
      });

      this.$emit("change");
    },
  },

  computed: {
    filter() {
      return this.$store.getters[`${this.resourceName}/getFilter`](
        this.filterKey
      );
    },

    // value() {
    //   return this.filter.currentValue;
    // },

    placeholder() {
      return this.filter.placeholder || this.__("Pick a date range");
    },
  },
};
</script>
