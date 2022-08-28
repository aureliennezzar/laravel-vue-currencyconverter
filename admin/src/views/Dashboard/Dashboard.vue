<script>
import axiosInstance from "../../utils";
import PairDataService from "../../services/PairDataService";
import router from "../../router";

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
    },
    async deletePair(id){
      if(confirm('Voulez-vous craiment supprimer cette conversion ?')){
        await PairDataService.delete(id);
        this.pairs = await PairDataService.getAll()
      }
    },
    async editPair(id){
      router.push(`/pairs/edit/${id}`);
    }
  },

  async created() {
    console.log(await PairDataService.getAll())
    this.pairs = await PairDataService.getAll()
  }
}
</script>
<style scoped>

</style>
<template>
  <router-link to="/pairs/add" class="nav-link">Ajouter</router-link>

  <ul v-for="(el,i) in pairs" :key="i">
    <li>
      <div>
        {{ el.primary_currency[0].name }}
        {{ el.secondary_currency[0].name }}
      </div>
      <button @click="deletePair(el.id)">Supprimer</button>
      <button @click="editPair(el.id)">Modifier</button>
    </li>
  </ul>
</template>
