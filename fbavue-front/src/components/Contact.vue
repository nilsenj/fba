<template>
  <div class="jumbotron">
    <h1>Contacts</h1>
    <h3 class="text-info">{{msg}}</h3>
    <p>This is contact page</p>
    <a href="#aboutModal"  @click="showContacts()" data-toggle="modal" data-target="#myModal">
      <img src="../../src/assets/me.jpg" name="aboutme" width="100" height="100" class="img-circle"></a>
    <em>click my face for more</em>
  </div>
  <!-- Modal -->
  <modal :show.sync="showContact">
    <div slot="modal-header" class="modal-header">
      <h4 class="modal-title">My contacts</h4>
    </div>

    <div slot="modal-body" class="modal-body">
    </div>
    <div slot="modal-body" class="modal-body">
      <center>
        <img
          src="../../src/assets/me.jpg"
          name="aboutme" width="100" height="100" border="0" class="img-circle">
        <h3 class="media-heading">Nikolenko Ivan(nilsenj)
          <small>Ukraine</small>
        </h3>
        <span><strong>Skills: </strong></span>
        <span class="label label-primary">PHP/Laravel/Symfony2</span>
        <span class="label label-default">MySql/PostgreSQL/Mongo/Redis</span>
        <span class="label label-warning">HTML5/CSS Preprocessors</span>
        <span class="label label-info">Nodejs, Express, Sails.js, Meteor</span>
        <span class="label label-success">Angular</span>
      </center>
      <hr>
      <center>
        <p class="text-left"><strong>Bio: </strong><br>
         I'm the dev from Ukraine. Like to study new techs, make some nice features and  play around the web.
        </p>
        <br>
        <p class="text-left"><strong>Contacts: </strong><br>
          <i class="glyphicon glyphicon-envelope"></i>nikoleivan@gmail.com
          <br />
          <i class="glyphicon glyphicon-globe"></i><a href="http://www.jquery2dotnet.com">Search me all around the internet</a>
          <br />
          <i class="glyphicon glyphicon-gift"></i>born March 01, 1992
        </p>
        <br>
        <p class="text-left"><strong>Additional info: </strong><br>
          <i class="glyphicon glyphicon-briefcase"></i> position <strong class="text-info">Senior developer</strong>
          <br>
          <i class="glyphicon glyphicon-home"></i> company <strong class="text-info">Global IT Support</strong>
          <br>
          <i class="glyphicon glyphicon-phone"></i> phone <strong class="text-info">+380936583690</strong>
          <br>
        </p>
      </center>
    </div>
    <div slot="modal-footer" class="modal-footer">

      <center>
        <button type="button" @click="showContacts()" class="btn btn-default" data-dismiss="modal">Thanks for attention - Click to close</button>
      </center>

    </div>
  </modal>
</template>

<style>
</style>

<script>
  var modal = require('vue-strap/dist/vue-strap.min').modal
  export default{
    data () {
      return {
        msg: 'Hello I\'m nilsenj',
        showContact: false
      }
    },
    methods: {
      showContacts: function () {
        if (this.showContact) {
          this.showContact = false
        } else {
          this.showContact = true
        }
      }
    },
    components: {
      modal
    }
  }
</script>
