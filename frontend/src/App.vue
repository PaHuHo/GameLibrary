<script>
import Footer from './components/footer.vue'
import SideBarVue from './components/sidebar.vue';
import NavBar from './components/navbar.vue'

export default {

  components: { SideBarVue, NavBar, Footer },
}
</script>

<template>
  <!-- <header>
    <img alt="Vue logo" class="logo" src="./assets/logo.svg" width="125" height="125" />

    <div class="wrapper">
      <HelloWorld msg="You did it!" />
    </div>
  </header> -->
  <div class="wrapper">
    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="http://127.0.0.1:8000/assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo"
                height="60" width="60">
        </div> -->
    <!-- Navbar -->
    <NavBar></NavBar>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <SideBarVue></SideBarVue>
    <router-view></router-view>
    <Footer></Footer>
  </div>


</template>

<style scoped>
header {
  line-height: 1.5;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }
}
</style>
