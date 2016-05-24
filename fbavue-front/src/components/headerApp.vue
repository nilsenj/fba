<template>
  <div class="headerApp" id="headerApp">
    <img class="logo" src=".././assets/logo.png">
    <p>
      dasadasdadsadasdasda
      {{msg}}
    </p>
  </div>
</template>
<style>
</style>
<script>
  export default{
    data () {
      return {
        msg: 'Fruit basket store'
      }
    },
    el: function () {
      return '#headerApp'
    }
  }
</script>
