<template>
  <div class="row mt-5 justify-content-center">
    <div class="col-md-5">
        <form action="">
            <div class="form-group text-left">
                <label for="name">Name</label>
                <input type="text" v-model="form.name" id="name" class="form-control">
            </div>
            <div class="form-group text-left">
                <label for="name">Email</label>
                <input type="email" v-model="form.email" id="email" class="form-control">
            </div>
        </form>
    </div>
  </div>
</template>

<script>
export default {
    name: 'PersonalInfo',
    props:['user'],
    data(){
        return{
            form:{
                name:'',
                email:''
            }
        }
    },
    created(){
        this.form.name = this.user.name;
        this.form.email = this.user.email;
    }
}
</script>

<style>

</style>