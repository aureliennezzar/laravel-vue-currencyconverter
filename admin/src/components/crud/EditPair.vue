<script>

import axiosInstance from "../../utils";
import PairDataService from "../../services/PairDataService";
import CurrencyDataService from "../../services/CurrencyDataService";
import router from "../../router";

export default {
  data() {
    return {
      currencies: [],
      id: null,
      primary_currency: "",
      secondary_currency: "",
      rate: "",
    }
  },

  methods: {
    async editPair() {
      if (confirm('Voulez-vous vraiment éditer cette conversion?')) {
        let {primary_currency, secondary_currency, rate,id} = this
        await PairDataService.update(id,{primary_currency, secondary_currency, rate});
        router.push('/')
        //
      }
    }
  },

  async created() {
    this.currencies = await CurrencyDataService.getAll()
    const pair = await PairDataService.get(this.$route.params.id);
    let {id, primary_currency, secondary_currency, rate} = pair
    this.id = id
    this.primary_currency = primary_currency
    this.secondary_currency = secondary_currency
    this.rate = rate
  }
}
</script>

<template>
  <form @submit.prevent="editPair">
    <label>Devise 1</label>

    <select required v-model="primary_currency">
      <option selected="false" v-for="(el,i) in currencies" :key="i" :value="el.id">{{ el.name }}</option>
    </select>


    <label>Devise 2</label>

    <select required v-model="secondary_currency">
      <option v-for="(el,i) in currencies" :key="i" :value="el.id">{{ el.name }}</option>
    </select>

    <label> Taux de change</label>
    <input v-model="rate">


    <button type="submit">Modifer</button>

  </form>
</template>
