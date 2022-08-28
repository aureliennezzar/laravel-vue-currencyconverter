<script>

import axiosInstance from "../../utils";
import PairDataService from "../../services/PairDataService";
import CurrencyDataService from "../../services/CurrencyDataService";

export default {
  data() {
    return {
      currencies: [],
      primary_currency: "",
      secondary_currency: "",
      rate: "",
    }
  },

  methods: {
    async createPair() {
      if (confirm('Voulez-vous vraiment créer cette conversion?')) {
        console.log(this.primary_currency, this.secondary_currency, this.rate)
        //
      }
    }
  },

  async created() {
    this.currencies = await CurrencyDataService.getAll()
  }
}
</script>

<template>
  <form @submit.prevent="createPair">
    <label>Devise 1</label>

    <select required v-model="primary_currency">
      <option v-for="(el,i) in currencies" :key="i" :value="el.id">{{ el.name }}</option>
    </select>


    <label>Devise 2</label>

    <select required v-model="secondary_currency">
      <option v-for="(el,i) in currencies" :key="i" :value="el.id">{{ el.name }}</option>
    </select>

    <label> Taux de change</label>
    <input v-model="rate" >


    <button type="submit">Créer</button>

  </form>
</template>
