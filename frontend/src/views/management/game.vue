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
                        <h1 class="m-0">Game Management</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Management</a></li>
                            <li class="breadcrumb-item active">Game</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Search -->
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" >
                                <button class="btn btn-primary" @click="openModel('#createForm')">ADD</button>

                                <button class="btn btn-success" @click="openModel('#importForm')">IMPORT</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th style="width: 300px;">Game Name</th>
                                            <th style="width: 250px;">Description</th>
                                            <th style="width: 250px;">Category</th>
                                            <th>Rating</th>
                                            <th>Status</th>
                                            <th>Function</th>
                                        </tr>
                                    </thead>
                                    <div style="display:none">{{ (index = (listGame.current_page - 1) *
                                    listGame.per_page + 1) }}</div>
                                    <tbody v-if="listGame.total > 0">
                                        <tr v-for="(gameData ) in listGame.data">
                                            <td>{{ index++ }}</td>
                                            <td>
                                                <div class="hover_container">
                                                    <div class="text">{{ gameData.name }}</div>
                                                    <div class="image">
                                                        <img v-show="gameData.image" :src="gameData.image"  alt="" />

                                                        <!-- <img src="{{!$product->product_image ? asset('assets/dist/img/default-150x150.png') : asset($product->product_image) }}"
                                                            alt="" width="200" height="200" /> -->
                                                    </div>
                                                </div>

                                            </td>
                                            <td><span v-if="gameData.description">{{ gameData.description }}</span>
                                                <span v-else>No description</span>
                                            </td>
                                            <td>
                                                <ul style="padding:0">
                                                    <li v-for="categoryGame in gameData.categories"
                                                        class="btn"
                                                        :style="['border-radius: 30px;margin: 5px;color:white; ', (categoryGame.color ? 'background-color:#'+ categoryGame.color : '')].join(' ')">{{ categoryGame.name }}
                                                    </li>
                                                </ul>
                                            </td>

                                            <td><star-rating :rating="Number(gameData.rating)" :increment="0.5"
                                                    :star-size="30" :read-only="true"></star-rating> </td>
                                            <td>
                                                <div :class="[(uiStatus[gameData.status].color), 'btn'].join(' ')">
                                                    {{ uiStatus[gameData.status].text }}</div>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary"
                                                    @click="openModel('#editForm', gameData)"
                                                    style="margin-right:10px ;"><i class="fas fa-edit"></i></button>

                                                <button class="btn btn-danger" @click=""><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="7" style="font-size:50px;text-align: center;">NO DATA</td>
                                        </tr>
                                    </tbody>
                                    <tfoot v-show="(listGame.total > 0)">
                                        <tr>
                                            <th>ID</th>
                                            <th>Game Name</th>
                                            <th>Category</th>
                                            <th>Rating</th>
                                            <th>Status</th>
                                            <th>Function</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div style="display: flex;justify-content: flex-end;" class="card-footer" v-show="(listGame.total > 10)" id="pagination">
                                <pagination v-model="page" :records="Number(listGame.total)" :options="{ hideCount:true,chunk:8 }"
                                    :per-page="Number(listGame.per_page)" @paginate="getSearchGame(page)" />
                            </div>

                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>

    <!-- create form game -->
    <div class="modal fade " id="createForm" tabindex="-1" role="dialog" data-backdrop="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header"
                    style="background-color:#e9e9e9; height: 30px; margin: 5px; border: 1px solid #ddd;">
                    <div class="modal-title"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute;right: 10px;top:10px">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top:5px">
                    <div class="panel panel-primary" style="border: none;margin-bottom: 0;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Add Game</h3>
                        </div>
                        <div class="panel-body">
                            <form id="add-event-form">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Game name</label>
                                        <input class="form-control" maxlength="40" type="text"
                                            v-model="formAddGame.name" placeholder="Game name">
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <vue3-tags-input v-model:tags="formAddGame.categories" :select="true"
                                            :select-items="tagsCategory" @on-select="handleSelectedTag"
                                            @on-tags-changed="handleChangeTag" placeholder="Select the category">
                                            <template #item="{ tag, index }">
                                                {{ tag.name }}
                                            </template>
                                            <template #no-data>
                                                No Data
                                            </template>
                                            <template #select-item="tag">
                                                {{ tag.name }}
                                            </template>
                                        </vue3-tags-input>
                                    </div>
                                    <div class="form-group">
                                        <label>Rating</label>
                                        <star-rating :increment="0.5" v-model:rating="formAddGame.rating"></star-rating>
                                    </div>
                                    <div class="form-group">
                                        <label>Image Game</label>
                                        <input class="form-control" type="text" v-model="formAddGame.image"
                                            placeholder="Image">
                                        <img v-show="formAddGame.image" style="margin-top: 10px;"
                                            :src="formAddGame.image" height="200" width="270">
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="model-footer" style="height: 50px;">
                    <button class="btn btn-primary" type="button" id="add-category" @click="addGame()"
                        style="position: absolute;right: 20px;bottom: 10px;">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit form game -->
    <div class="modal fade " id="editForm" tabindex="-1" role="dialog" data-backdrop="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header"
                    style="background-color:#e9e9e9; height: 30px; margin: 5px; border: 1px solid #ddd;">
                    <div class="modal-title"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute;right: 10px;top:10px">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top:5px">
                    <div class="panel panel-primary" style="border: none;margin-bottom: 0;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Update Game</h3>
                        </div>
                        <div class="panel-body">
                            <form id="add-event-form">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Game name</label>
                                        <input class="form-control" maxlength="40" type="text"
                                            v-model="formEditGame.name" placeholder="Game name">
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <vue3-tags-input v-model:tags="formEditGame.categories" :select="true"
                                            :select-items="tagsCategory" @on-select="handleSelectedTagEdit"
                                            @on-tags-changed="handleChangeTagEdit" placeholder="Select the category">
                                            <template #item="{ tag, index }">
                                                {{ tag.name }}
                                            </template>
                                            <template #no-data>
                                                No Data
                                            </template>
                                            <template #select-item="tag">
                                                {{ tag.name }}
                                            </template>
                                        </vue3-tags-input>
                                    </div>
                                    <div class="form-group">
                                        <label>Rating</label>
                                        <star-rating :increment="0.5"
                                            v-model:rating="formEditGame.rating"></star-rating>
                                    </div>
                                    <div class="form-group">
                                        <label>Image Game</label>
                                        <input class="form-control" type="text" v-model="formEditGame.image"
                                            placeholder="Image">
                                        <img v-show="formEditGame.image" style="margin-top: 10px;"
                                            :src="formEditGame.image" height="200" width="270">
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" v-model="formEditGame.status">
                                            <option v-for="option in uiStatus" :value="option.id">{{ option.text }}
                                            </option>
                                        </select>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="model-footer" style="height: 50px;">
                    <button class="btn btn-primary" type="button" id="add-category" @click="editGame()"
                        style="position: absolute;right: 20px;bottom: 10px;">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- export form game -->
    <div class="modal fade " id="importForm" tabindex="-1" role="dialog" data-backdrop="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header"
                    style="background-color:#e9e9e9; height: 30px; margin: 5px; border: 1px solid #ddd;">
                    <div class="modal-title"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute;right: 10px;top:10px">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top:5px">
                    <div class="panel panel-primary" style="border: none;margin-bottom: 0;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Export file excel</h3>
                        </div>
                        <div class="panel-body">
                            <form id="importExcelForm">
                                <fieldset>
                                    <div class="form-group">
                                        <label>File excel: </label>
                                        <input class="form-control" type="file" id="file" name="file"
                                            style="padding:5px">
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="model-footer" style="height: 50px;">
                    <button class="btn btn-primary" type="button" id="add-category" @click="importFileExcel()"
                        style="position: absolute;right: 20px;bottom: 10px;">
                        Export file
                    </button>
                </div>
            </div>
        </div>
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
        Vue3TagsInput
    },
    mounted() {
        this.listGame = INITIAL_GAME
        this.tagsCategory = INITIAL_CATEGORY
    },
    data() {
        return {
            importFile: '',
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
            formAddGame: {
                name: '',
                categories: [],
                description: 'No description',
                rating: 0,
                image: '',
            },
            formEditGame: {
                id: '',
                name: '',
                categories: [],
                description: '',
                rating: 0,
                image: '',
                status: ''
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
        openModel(model, gameEdit = '') {
            if (gameEdit) {
                this.formEditGame.id = gameEdit.id,
                    this.formEditGame.name = gameEdit.name,
                    this.formEditGame.description = gameEdit.description,
                    this.formEditGame.categories = gameEdit.categories,
                    this.formEditGame.rating = Number(gameEdit.rating)
                this.formEditGame.image = gameEdit.image
                this.formEditGame.status = gameEdit.status
            }

            $(model).modal('show')
            $('.modal-content').draggable({
                zIndex: 999,
                revertDuration: 0
            });
        },
        handleSelectedTag(tag) {
            if (!this.formAddGame.categories.includes(tag)) {
                this.formAddGame.categories.push(tag);
            }
        },
        handleChangeTag(tags) {
            this.formAddGame.categories = tags;
        },
        handleSelectedTagEdit(tag) {
            if (!this.formEditGame.categories.find((category) => category.id == tag.id)) {
                this.formEditGame.categories.push(tag);
            }
        },
        handleChangeTagEdit(tags) {
            this.formEditGame.categories = tags;
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

        async addGame() {
            try {
                await axios.post("http://127.0.0.1:8000/api/game/add", {
                    name: this.formAddGame.name,
                    categories: this.formAddGame.categories,
                    rating: this.formAddGame.rating,
                    description: this.formAddGame.description,
                    image: this.formAddGame.image
                }).then(res => {
                    toast.success(res.data.message.toString());
                })
                this.listGame = await getGame()

                $('#createForm').modal('toggle');
            } catch (error) {
                await Object.entries(error.response.data.errors).forEach(([key, value]) => {
                    toast.error(value.toString());
                });
            }
        },
        async editGame() {
            try {
                await axios.post("http://127.0.0.1:8000/api/game/edit/" + this.formEditGame.id, {
                    name: this.formEditGame.name,
                    categories: this.formEditGame.categories,
                    rating: this.formEditGame.rating,
                    description: this.formEditGame.description,
                    image: this.formEditGame.image,
                    status: this.formEditGame.status
                }).then(res => {
                    toast.success(res.data.message.toString());
                })
                await this.getSearchGame(this.page)
                $('#editForm').modal('toggle');
            } catch (error) {
                await Object.entries(error.response.data.errors).forEach(([key, value]) => {
                    toast.error(value.toString());
                });
            }
        },

        async importFileExcel() {

            try {
                var $importExcelForm = $('#importExcelForm')
                var data = new FormData(importExcelForm)
                await axios.post("http://127.0.0.1:8000/api/game/import", data).then(res => {
                    toast.success(res.data.message.toString());
                })
                await this.getSearchGame(this.page)
                $('#importForm').modal('toggle');
            } catch (error) {
                console.log(error)
                // await Object.entries(error.response.data.errors).forEach(([key, value]) => {
                //     toast.error(value.toString());
                // });
            }
        },
    },
    computed: {
    }
}
</script>

<style>
.card-header button {
    margin: 5px;
}

.vue-star-rating-rating-text {
    display: none;
}

.pagination {
    display: inline-flex;
}
div.hover_container .image
{
    display: none; /* hidden by default */
    width: 300px; /* same width as container */
    height: 300px; /* same height as container */
}
div.hover_container .image img
{
    width: 300px; /* width of the image */
    height: 250px; /* height of the image */
}
div.hover_container:hover .text{
    cursor: pointer;
}
div.hover_container:hover .image
{
    
    display: block; /* shown when hovering the container */
    display: inline;
    position: absolute;
    z-index: 10;
    margin-left: 60px;
}
</style>