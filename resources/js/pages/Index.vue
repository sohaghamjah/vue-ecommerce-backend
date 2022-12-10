<template>
    <div id="wrapper">
        <!-- Sidebar -->
            <sidebar></sidebar>
        <!-- Sidebar -->

        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <topbar @logout="logout"></topbar>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <router-view></router-view>
                </div>
                <!---Container Fluid-->
            </div>
        </div>
    </div>
</template>

<script>
    import Sidebar from "../Components/Sidebar.vue";
    import Topbar from "../Components/Topbar.vue";
    export default {
        name: "Index",
        components:{
            Sidebar,
            Topbar,
        },
        methods:{
            logout(){
                User.logout();
                 Toast.fire({
                    icon:'success',
                    title:'Logged out Successfull'
                });
                this.$router.push({name:'Login'});
            }
        }
    }
</script>

<style>

</style>
