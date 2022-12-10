<template>
  <div class="row">
    <div class="col-12 main-section text-center">
        <div class="row">
            <div class="col-12 profile-header">
                
            </div>
        </div>
        <div class="row">
            <div class="col-12 user-details">
                <img src="assets/img/boy.png" class="rounded-circle img-thumbnail" :alt="user.name">
            </div>  
            <div class="col-12">
                <button class="btn btn-sm mr-3" @click="activeTab='PersonalInfo'" :class="activeTab == 'PersonalInfo' ? 'btn-primary' : 'btn-secondary'">Personal Information</button>
                <button class="btn btn-sm" @click="activeTab = 'ChangePassword'" :class="activeTab == 'ChangePassword' ? 'btn-primary' : 'btn-secondary'">Change Password</button>
            </div>
            <div class="col-12">
                <keep-alive>
                    <component :is="activeTab" :user="user"></component>
                </keep-alive>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import PersonalInfo from '../Components/Profile/PersonalInfo.vue';
import ChangePassword from '../Components/Profile/ChangePassword.vue';
export default {
    name: 'Profile',
    components:{
        PersonalInfo,
        ChangePassword,
    },
    data(){
        return{
            user:{},
            activeTab: 'PersonalInfo',
        }
    },
    created(){
       this.user = User.userInfo();
    }
}
</script>

<style scoped>
.main-section{
    min-height: 100vh;
    background: #fff;
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.5);
}
.profile-header{
    background: #4c60da;
    height: 150px;
}
.user-details{
     margin: -75px 0 30px 0px;   
}
.user-details img{
    width: 150px;
    height: 150px;
}
</style>