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
    async deletePair(id) {
      if (confirm('Voulez-vous craiment supprimer cette conversion ?')) {
        await PairDataService.delete(id);
        this.pairs = await PairDataService.getAll()
      }
    },
    async editPair(id) {
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


  <main>

    <h1>Dashboard</h1>
    <div class="main__content">
      <router-link to="/pairs/add" class="nav-link">Ajouter une conversion</router-link>

      <ul>
        <li v-for="(el,i) in pairs" :key="i">
          <div>
            {{ el.primary_currency[0].name }} / {{ el.secondary_currency[0].name }}
          </div>
          <div>Nb conversions : {{ el.nb_conversions }}</div>
          <a @click="deletePair(el.id)">Supprimer</a>
          <a @click="editPair(el.id)">Modifier</a>
        </li>
      </ul>
    </div>
  </main>
</template>

<style scoped>
.main__content{
  display: flex;
  flex-direction: column;
}
main {
  display: flex;
  flex-direction: column;
}

ul {
  display: flex;
  flex-direction: column;
  list-style: none;
  padding: 0;
}

ul li {
  display: flex;
}
ul li a{
  cursor: pointer;
}

ul li div{
  margin-right: 15px;
}
</style>
