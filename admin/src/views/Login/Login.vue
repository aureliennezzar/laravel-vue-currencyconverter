<script>
import axiosInstance from "../../utils";

export default {
  data() {
    return {
      "email": "",
      "password": "",
    }
  },

  methods: {
    login() {
      console.log(this.password,this.email)
      axiosInstance.post('/auth/login', {
        email: this.email,
        password: this.password
      })
          .then(function (response) {
            console.log(response);
          })
          .catch(function (error) {
            console.log(error);
          });
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
