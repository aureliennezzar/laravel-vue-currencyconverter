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
      const res = await axiosInstance.post('/auth/login', {
        email: this.email,
        password: this.password
      })
      store.state.user.data = res.data.user
      store.state.user.token = res.data.access_token

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
    <div class="content">
      <div class="input-wrapper">
        <label>E-mail</label>
        <input v-model="email" type="text" name="email">
      </div>
      <div class="input-wrapper">
        <label>Mot de passe</label>
        <input v-model="password" type="password" name="password">
      </div>
    </div>

    <button type="submit">SE CONNECTER</button>

  </form>
</template>
<style scoped>

form {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 30px;
  background-image: linear-gradient(353deg, rgb(242, 82, 69), rgb(131, 28, 80));
  color: white;
  min-width: 400px;
  box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
}
@media (max-width: 768px){
  form{
    min-width: 320px;
  }
}

.input-wrapper {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

.input-wrapper input {
  padding: 5px;
  border: none;
  width: 250px;
  height: 50px;
}

.input-wrapper label {
  margin-bottom: 5px;
}

form button[type="submit"] {
  border-radius: 5px;
  padding: 5px;
  border: none;
  background-color: #fff;
  color: black;
  cursor: pointer;
  width: 250px;
}
form .content{
  margin-bottom: 35px;
  max-width: 250px;

}
</style>
