<script>
import axiosInstance from "../../utils";
import store from "@/store/index.js";
import router from "../../router";

export default {
  data() {
    return {
      "email": "",
      "password": "",
    }
  },

  methods: {
    async login() {
      console.log(store.state.user.token, 'post')
      const res = await axiosInstance.post('/auth/login', {
        email: this.email,
        password: this.password
      })
      store.state.user.data = res.data.user
      store.state.user.token = res.data.access_token
      console.log(store.state.user.token, 'after')

      if (res.status == 200) {
        router.push('/')
      }
    }
  },

  mounted() {
  }
}
</script>

<template>
  <form @submit.prevent="login">


    <input v-model="email" type="text" name="email">
    <input v-model="password" type="password" name="password">

    <button type="submit">SE CONNECTER</button>

  </form>
</template>
