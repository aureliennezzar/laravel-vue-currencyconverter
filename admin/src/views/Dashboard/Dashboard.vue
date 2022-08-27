<script>
import axiosInstance from "../../utils";

export default {
  data() {
    return {
      pairs: []
    }
  },

  methods: {
    async fetchData() {
      try {
        const res = await axiosInstance.get('/pairs')
        return res.data;
      } catch (err) {
        console.log(err)
      }
    }
  },

  async created() {
    this.pairs = await this.fetchData();
  }
}
</script>

<template>
  <div v-for="(el,i) in pairs" :key="i">
    <p v-for="(value, key, i) in el" :key="1">
      {{ key }} : {{ value }}
    </p>
  </div>
</template>
