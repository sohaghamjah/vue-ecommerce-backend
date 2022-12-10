<template>
  <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon">
                    <img src="assets/img/logo/logo2.png">
                </div>
                <div class="sidebar-brand-text mx-3">RuangAdmin</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <router-link to="/" class="nav-link" active-class="active-link"
                    exact-active-class="exact-active-link">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </router-link>
            </li>
            <li class="nav-item active">
                <router-link to="/brand" class="nav-link" active-class="active-link"
                    exact-active-class="exact-active-link">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Brand</span>
                </router-link>
            </li>
            <li class="nav-item active">
                <router-link to="/category" class="nav-link" active-class="active-link"
                    exact-active-class="exact-active-link">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Category</span>
                </router-link>
            </li>
            <li class="nav-item active">
                <router-link to="/product" class="nav-link" active-class="active-link"
                    exact-active-class="exact-active-link">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Product</span>
                </router-link>
            </li>
            <li class="nav-item active">
                <router-link to="/supplier" class="nav-link" active-class="active-link"
                    exact-active-class="exact-active-link">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Supplier</span>
                </router-link>
            </li>
        </ul>
</template>

<script>
export default {
    name: 'Sidebar',
}
</script>

<style>

</style>