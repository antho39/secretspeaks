<script>
  import {loginUrl, getHeader, userUrl} from './../config'
  import {clientId, clientSecret} from './../env'
  import {mapState} from 'vuex'
  export default {
    computed: {
      ...mapState({
        userStore: state => state.userStore
      })
    },
    data () {
      return {
        login: {
          email: '',
          password: ''
        }
      }
    },
    methods: {
      handleLoginFormSubmit () {
        const postData = {
          grant_type: 'password',
          client_id: clientId,
          client_secret: clientSecret,
          username: this.login.email,
          password: this.login.password,
          scope: ''
        }
        const authUser = {}
        this.$http.post(loginUrl, postData)
          .then(response => {
            if (response.status === 200) {
              console.log('Oauth token', response)
              authUser.access_token = response.data.access_token
              authUser.refresh_token = response.data.refresh_token
              window.localStorage.setItem('authUser', JSON.stringify(authUser))
              this.$http.get(userUrl, {headers: getHeader()})
                .then(response => {
                  console.log('user object', response)
                  authUser.email = response.body.email
                  authUser.name = response.body.name
                  window.localStorage.setItem('authUser', JSON.stringify(authUser))
                  this.$store.dispatch('setUserObject', authUser)
                  this.$router.push({name: 'dashboard'})
                })
            }
          })
      }
    }
  }
</script>

<template>
  <div class="wrapper" id="login-wrapper">
    <section class="login">
      <div class="row">
        <div class="col-md-6 col-md-push-3">
          <div class="panel panel-default">
            <div class="panel-heading"><strong>Connexion</strong></div>
            <div class="panel-body">
              <form v-on:submit.prevent="handleLoginFormSubmit()">
                <div class="form-group">
                  <label>Adresse mail</label>
                  <input
                    class="form-control"
                    placeholder="Entrez votre mail"
                    type="text"
                    v-model="login.email"
                  >
                </div>

                <div class="form-group">
                  <label>Mot de passe</label>
                  <input
                    class="form-control"
                    placeholder="Entrez votre mot de passe"
                    type="password"
                    v-model="login.password"
                  >
                </div>

                <button class="btn btn-primary">Connexion</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style lang="sass">
  #login-wrapper
    margin-top: 50px
</style>
