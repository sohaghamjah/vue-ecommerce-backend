<template>
  <div class="row justify-content-center">
    <div class="col-xl-5 col-lg-5 col-md-5">
      <div class="card shadow-sm my-5">
        <div class="card-body p-0">
          <div class="row">
            <div class="col-lg-12">
              <div class="login-form">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Login</h1>
                </div>
                <form class="user" @submit.prevent="login">
                  <div class="form-group">
                    <input
                      type="email"
                      class="form-control"
                      id="email" v-model="form.email"
                      placeholder="Enter Email Address"
                    />
                    <small v-if="errors.email" class="text-danger">{{errors.email[0]}}</small>
                  </div>
                  <div class="form-group">
                    <input
                      type="password"
                      class="form-control"
                      id="password" v-model="form.password"
                      placeholder="Password"
                    />
                    <small v-if="errors.password" class="text-danger">{{errors.password[0]}}</small>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block"
                      >Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data(){
    return {
      form:{
        email:'',
        password:''
      },
      errors:{}
    }
  },
  methods: {
    async login()
    {
      try {
        const res = await axios.post('/login',this.form);
        if(res.data.status === true)
        {
          User.responseAfterLogin(res.data.data);
          Toast.fire({
            icon:'success',
            title:'Logged In Successfull'
          });
          this.$router.push({name:'Dashboard'});
        }else{
          Toast.fire({
            icon:'error',
            title: res.data.errors
          });
        }
        
      } catch (error) {
        this.errors = error.response.data.errors;
      }
    }
    
  }
}
</script>

<style>

</style>