<script setup>
import axiosInstance from "./utils";

axiosInstance.get('/pairs').then(function(caca){
  console.log(caca)
})
</script>

<template>
  App

  <router-view/>
</template>
