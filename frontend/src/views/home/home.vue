<template>
    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="http://127.0.0.1:8000/assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo"
                height="60" width="60">
        </div> -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Home</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <h2 class="text-center display-4">Search</h2>
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Category:</label>
                                    <select class="form-control" v-model="searchForm.category">
                                        <option disabled selected value="">Choose category</option>
                                        <option v-for="option in tagsCategory" :value="option.id">{{ option.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select class="form-control" v-model="searchForm.status">
                                        <option disabled selected value="">Choose status</option>
                                        <option v-for="option in uiStatus" :value="option.id">{{ option.text }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Order By:</label>
                                    <select class="form-control" v-model="searchForm.orderBy">
                                        <option value="name">Name</option>
                                        <option value="rating">Rating</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Sort Order:</label>
                                    <select class="form-control" v-model="searchForm.sortOrder">
                                        <option value="asc">ASC</option>
                                        <option value="desc">DESC</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <input type="search" class="form-control form-control-lg"
                                    placeholder="Type your keywords here" v-model="searchForm.name">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default"
                                        @click="getSearchGame(1, true)">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;justify-content: center">
                            <button class="btn btn-primary" @click="resetSearch()">Refresh</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <h5 class="mb-2">List Game</h5>

                <div class="card card-success">
                    <div class="card-body" v-if="listGame.total > 0">
                        <div style="display: flex;justify-content: center" id="pagination">
                            <pagination v-model="page" :records="Number(listGame.total)"
                                :options="{ hideCount: true, chunk: 8 }" :per-page="Number(listGame.per_page)"
                                @paginate="getSearchGame(page)" />
                        </div>
                        <div class="row">
                            <div v-for="gameData in listGame.data" class="col-md-12 col-lg-6 col-xl-4">
                                <div class="card mb-2 bg-gradient-dark">
                                    <img class="card-img-top" :src="gameData.image" height="300" width="200">
                                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                                        <!-- <h3 class="card-title text-white">{{ gameData.name }}</h3> -->
                                        <div class="card-text text-white pb-2 pt-1"><star-rating
                                                :rating="Number(gameData.rating)" :increment="0.5" :star-size="30"
                                                :read-only="true"></star-rating>
                                        </div>
                                        <div>
                                            <ul style="padding:0">
                                                <li v-for="categoryGame in gameData.categories" class="btn"
                                                    :style="['border-radius: 30px;margin: 5px;color:white; ', (categoryGame.color ? 'background-color:#' + categoryGame.color : '')].join(' ')">
                                                    {{ categoryGame.name }}
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- <a href="#" class="text-white">Last update 2 mins ago</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex;justify-content: center;margin-top: 10px;" id="pagination">
                            <pagination v-model="page" :records="Number(listGame.total)"
                                :options="{ hideCount: true, chunk: 8 }" :per-page="Number(listGame.per_page)"
                                @paginate="getSearchGame(page)" />
                        </div>
                    </div>
                    <div v-else style="display: flex;justify-content: center;"><span style="font-size: xxx-large;">
                            NO GAME MATCH
                        </span></div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
</template>

<script>
import axios from "axios";
import StarRating from 'vue-star-rating'
import { INITIAL_CATEGORY, INITIAL_GAME, getGame } from '../../store'
import { useToast } from "vue-toastification";
import Vue3TagsInput from 'vue3-tags-input';

const toast = useToast();
export default {
    components: {
        StarRating,
        Vue3TagsInput,
    },
    mounted() {
        this.listGame = INITIAL_GAME
        console.log(this.listGame)
        this.tagsCategory = INITIAL_CATEGORY
    },
    data() {
        return {
            page: 1,
            uiStatus: [
                {
                    id: 0,
                    html: '<div class="btn btn-danger">DROP</div>',
                    color: 'btn-danger',
                    text: 'DROP'
                },
                {
                    id: 1,
                    html: '<div class="btn btn-success">DONE</div>',
                    color: 'btn-success',
                    text: 'DONE'
                },
                {
                    id: 2,
                    html: '<div class="btn btn-warning">WAIT</div>',
                    color: 'btn-warning text-white',
                    text: 'WAIT'
                },
                {
                    id: 3,
                    html: '<div class="btn btn-warning">WAIT</div>',
                    color: 'btn-info',
                    text: 'WISHLIST'
                },
            ],
            tagsCategory: [],
            listGame: {},
            searchForm: {
                category: '',
                status: '',
                orderBy: 'name',
                sortOrder: 'asc',
                name: '',
            },
        }
    },
    methods: {
        async resetSearch() {
            this.searchForm.name = '',
                this.searchForm.category = '',
                this.searchForm.status = '',
                this.searchForm.orderBy = 'name',
                this.searchForm.sortOrder = 'asc',
                this.getSearchGame(1, true)
        },
        async getSearchGame(page = 1, wantBack = false) {
            try {

                const response = await axios.get('http://127.0.0.1:8000/api/game/search?page=' + page + '&name=' + this.searchForm.name + '&category=' + this.searchForm.category + '&status=' + this.searchForm.status + '&orderBy=' + this.searchForm.orderBy + '&sortOrder=' + this.searchForm.sortOrder)
                console.log(response)
                this.listGame = response.data
                if (wantBack) {
                    this.page = 1
                }
            } catch (error) {
                // this.error = error.response.data
            }
        },
    }
}
</script>