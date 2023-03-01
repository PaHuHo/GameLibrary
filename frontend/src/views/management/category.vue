<template>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Category Management</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Management</a></li>
                            <li class="breadcrumb-item active">Category</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-success" @click="openModel('#createForm')">Add Category</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category Name</th>
                                            <th>Function</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="category in listCategory">
                                            <td>{{ category.id }}</td>
                                            <td>{{ category.name }}
                                            </td>
                                            <td>
                                                <button class="btn btn-primary"
                                                    @click="openModel('#editForm', category)"><i
                                                        class="fas fa-edit"></i>Update</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category Name</th>
                                            <th>Function</th>
                                        </tr>
                                    </tfoot>
                                </table>
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



    <!-- Model add  category -->
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
                            <h3 class="panel-title">Add category</h3>
                        </div>
                        <div class="panel-body">
                            <form id="add-event-form">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Category name</label>
                                        <input class="form-control" id="title" v-model="nameCategoryAdd" name="title"
                                            maxlength="40" type="text" placeholder="Category name">
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="model-footer" style="height: 50px;">
                    <button class="btn btn-primary" type="button" id="add-category" @click="addCategory()"
                        style="position: absolute;right: 20px;bottom: 10px;">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Model edit category -->
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
                            <h3 class="panel-title">Update category</h3>
                        </div>
                        <div class="panel-body">
                            <form id="add-event-form">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Category name</label>
                                        <input class="form-control" id="title" v-model="categoryEdit.name" name="title"
                                            maxlength="40" type="text" placeholder="Category name">
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="model-footer" style="height: 50px;">
                    <button class="btn btn-primary" type="button" id="add-category" @click="editCategory()"
                        style="position: absolute;right: 20px;bottom: 10px;">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { INITIAL_CATEGORY, getCategory } from '../../store'
import { API_URL } from '@/api';
import { useToast } from "vue-toastification";
const toast = useToast();
export default {
    async mounted() {
        this.listCategory = await INITIAL_CATEGORY
    },
    data() {
        return {
            nameCategoryAdd: '',
            categoryEdit: {
                id: '',
                name: ''
            },
            listCategory: '',
        }
    },
    methods: {
        openModel(model, category = '') {

            if (category) {
                this.categoryEdit.id = category.id,
                this.categoryEdit.name = category.name
            }

            $(model).modal('show')
            $('.modal-content').draggable({
                zIndex: 999,
                revertDuration: 0 //  original position after the drag
            });
        },

        async editCategory() {
            try {
                await axios.post(`${API_URL}/api/category/edit/` + this.categoryEdit.id, {
                    name: this.categoryEdit.name
                }).then(res => {
                    toast.success(res.data.message.toString());
                })
                this.listCategory = await getCategory()
                $('#editForm').modal('toggle');
            } catch (error) {
                await Object.entries(error.response.data.errors).forEach(([key, value]) => {
                    toast.error(value.toString());
                });
            }
        },

        async addCategory() {
            try {
                await axios.post(`${API_URL}/api/category/add`, {
                    name: this.nameCategoryAdd
                }).then(res => {
                    toast.success(res.data.message.toString());
                })
                this.listCategory = await getCategory()
                $('#createForm').modal('toggle');
            } catch (error) {
                await Object.entries(error.response.data.errors).forEach(([key, value]) => {
                    toast.error(value.toString());
                });
            }
        },
    }
}
</script>