<template>
  <div class="row mt-5 justify-content-center">
    <div class="col-md-5">
        <form action="" @submit.prevent="changePassword">
            <div class="form-group text-left">
                <label for="name">Current Password</label>
                <input type="password" v-model="form.current_password" id="current_password" class="form-control">
                <small v-if="errors.current_password" class="text-danger">{{errors.current_password[0]}}</small>
            </div>
            <div class="form-group text-left">
                <label for="name">New Password</label>
                <input type="password" v-model="form.password" id="password" class="form-control">
                <small v-if="errors.password" class="text-danger">{{errors.password[0]}}</small>
            </div>
            <div class="form-group text-left">
                <label for="name">Confirm Password</label>
                <input type="password" v-model="form.password_confirmation" id="password_confirmation" class="form-control">
                <small v-if="errors.password_confirmation" class="text-danger">{{errors.password_confirmation[0]}}</small>
            </div>
            <div class="form-group text-left">
               <button type="submit" class="btn btn-primary">Change Password</button>
            </div>
        </form>
    </div>
  </div>
</template>

<script>
export default {
    name: 'ChangePassword',
    props:['user'],
    data(){
        return{
            form:{
                current_password:'',
                password:'',
                password_confirmation:'',
            },
            errors:{}
        }
    },
    methods:{
        changePassword(){
            axios.post('password-change', this.form)
            .then(res => {
                if(res.data.status === true){
                    Toast.fire({
                        icon:'success',
                        title:'Password changed Successfull'
                    });
                    this.form={
                        current_password:'',
                        password:'',
                        password_confirmation:'',
                    };
                    this.errors = {};
                }else{
                    Toast.fire({
                        icon:'error',
                        title: res.data.message
                    });
                }
            })
            .catch(error=>{
                this.errors = error.response.data.errors;
            });
        }
    }
}
</script>

<style>

</style>