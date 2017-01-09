<script>
  import {saveUser} from './../config'
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
          name: '',
          email: '',
          password: '',
          confirm_password: ''
        }
      }
    },
    methods: {
      handleLoginFormSubmit () {
        const postData = {
          name: this.login.name,
          email: this.login.email,
          password: this.login.password,
          confirm_password: this.login.confirm_password,
          scope: ''
        }
        if (postData.password === postData.confirm_password) {
          this.$http.post(saveUser, postData).then(response => {
            if (response.status === 200) {
              console.log('Votre compte a bien été créé ' + response.body.name)
              this.$router.push({name: 'dashboard'})
            }
          })
        } else {
          console.log('Les mots de passe ne correspondent pas!')
        }
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
            <div class="panel-heading"><strong>Enregistrement</strong></div>
            <div class="panel-body">
              <form v-on:submit.prevent="handleLoginFormSubmit()">
                <div class="form-group">
                  <label>Nom</label>
                  <input
                          class="form-control"
                          placeholder="Entrez votre nom"
                          type="text"
                          v-model="login.name"
                  >
                </div>
                <div class="form-group">
                  <label>Adresse mail</label>
                  <input
                    class="form-control"
                    placeholder="Entrez votre adresse mail"
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
                <div class="form-group">
                  <label>Confirmation mot de passe</label>
                  <input
                          class="form-control"
                          placeholder="Confirmez votre mot de passe"
                          type="password"
                          v-model="login.confirm_password"
                  >
                </div>

                <button class="btn btn-primary">Enregistrer</button>
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
