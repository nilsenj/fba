<template>
  <div class="row">
  <div id="index">
    <div>
      <h1>This is the layout that won't change</h1>
    </div>
    <p>
      <a v-link="{ path: '/subroute' }" class="btn btn-lg btn-primary" role="button">View SubRoute</a>
      To get a better understanding of how this boilerplate works, check out
      <a href="http://vuejs-templates.github.io/webpack" target="_blank">its documentation</a>.
      It is also recommended to go through the docs for
      <a href="http://webpack.github.io/" target="_blank">Webpack</a> and
      <a href="http://vuejs.github.io/vue-loader/" target="_blank">vue-loader</a>.
      If you have any issues with the setup, please file an issue at this boilerplate's
      <a href="https://github.com/vuejs-templates/webpack" target="_blank">repository</a>.
    </p>
    <p>
      You may also want to checkout
      <a href="https://github.com/vuejs/vue-router/" target="_blank">vue-router</a> for routing and
      <a href="https://github.com/vuejs/vuex/" target="_blank">vuex</a> for state management.
    </p>
    <!-- To show nested subroute-->
    <router-view></router-view>
  </div>
  </div>
</template>
<script>
  export default {
  }
</script>
<style>
  html {
    height: 100%;
  }
  body {
    display: block;
    align-items: center;
    justify-content: center;
    height: 100%;
  }
  #app {
    color: #2c3e50;
    font-family: Source Sans Pro, Helvetica, sans-serif;
    text-align: center;
  }
  #app a {
    color: #42b983;
    text-decoration: none;
  }

  .logo {
    width: 100px;
    height: 100px
  }
</style>
