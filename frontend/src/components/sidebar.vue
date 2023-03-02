<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link to="/" class="brand-link" :class="{ active: routeNow == '/' }" style="padding-left: 0">
            <img src="https://www.logoground.com/uploads8/dv8y2020700642020-04-202666735broken-game.jpg" alt="List Game"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">My Library</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link" :class="{ active: routeNow == '/' }">
                            <i class="nav-icon fas fa-gamepad"></i>
                            <p>Home</p>
                        </router-link>
                    </li>
                    <!-- menu-open: mo menu , active gan nav-link de hien thi cai nao dang active -->
                    <li class="nav-item" :class="{ 'menu-open': isMenuOpen }" @click="isMenuOpen = !isMenuOpen">
                        <router-link :to="routeNow" class="nav-link" :class="{ active: subIsActive(['/management']) }">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </router-link>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{ name: 'game' }" class="nav-link "
                                    :class="{ active: routeNow == '/management' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Game</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'category' }" class="nav-link"
                                    :class="{ active: routeNow == '/management/category' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Category</p>
                                </router-link>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="./index3.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard v3</p>
                                </a>
                            </li> -->
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="nav-icon fas fa-star"></i>
                            <p>
                                Favourite
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="nav-icon fas fa-crown"></i>
                            <p>
                                Ranking List
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="nav-icon fas fa-award"></i>
                            <p>
                                The Game Awards
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
export default {

    data() {
        return {
            isMenuOpen: false,
        }
    },
    methods: {
        subIsActive(input) {
            const paths = Array.isArray(input) ? input : [input]
            return paths.some(path => {
                return this.$route.path.indexOf(path) === 0 // current path starts with this path string
            })
        }
    },
    computed: {
        routeNow() {
            return this.$route.path
        },


    }
}
</script>