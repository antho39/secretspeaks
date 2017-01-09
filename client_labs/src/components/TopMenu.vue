<script>
  import {mapState} from 'vuex'
  export default {
    computed: {
      ...mapState({
        userStore: state => state.userStore
      })
    },
    methods: {
      handleLogout () {
        this.$store.dispatch('clearAuthUser')
        window.localStorage.removeItem('authUser')
        this.$router.push({name: 'home'})
      }
    }
  }
</script>

<template>
  <nav class="navbar navbar-default" v-if="userStore.authUser !== null && userStore.authUser.access_token">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <router-link :to="{name: 'dashboard'}" class="navbar-brand">
          Chat With Everyone
        </router-link>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
          <li><router-link :to="{name: 'room'}">Chat</router-link></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li data-toggle="tooltip" data-placement="top" title="Messages privés"><router-link :to="{name: 'chat'}"><span class="glyphicon glyphicon-envelope"></span></router-link></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><p style="display: inline-block" v-text="userStore.authUser.name"></p> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#"><span class="glyphicon glyphicon-user"></span> Profil</a></li>
              <li role="separator" class="divider"></li>
              <li><a v-on:click="handleLogout()"><span class="glyphicon  glyphicon-log-out"></span> Déconnexion</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</template>
