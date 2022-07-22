<template>
    <Head title="User" />
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Users</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <Link :href="route('users.index')">Users</Link>
                            </li>
                            <li class="breadcrumb-item active">List</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div
                            class="alert alert-success alert-dismissible"
                            v-if="flash.success"
                        >
                            <button
                                type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true"
                            >
                                ×
                            </button>
                            {{ flash.success }}
                        </div>
                        <div
                            class="alert alert-danger alert-dismissible"
                            v-if="flash.error"
                        >
                            <button
                                type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true"
                            >
                                ×
                            </button>
                            {{ flash.error }}
                        </div>
                        <div class="card m-0">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <Link
                                        :href="route('users.create')"
                                        class="btn btn-sm btn-success"
                                    >
                                        <i class="fas fa-plus"></i> Create
                                    </Link>
                                </h3>
                                <div class="card-tools">
                                    <div
                                        class="input-group input-group"
                                        style="width: 200px"
                                    >
                                        <input
                                            v-model="q"
                                            @keyup="search"
                                            type="text"
                                            name="table_search"
                                            class="form-control float-right"
                                            placeholder="Search"
                                        />
                                        <div class="input-group-append">
                                            <button
                                                type="submit"
                                                class="btn btn-default"
                                            >
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="users.data != 0">
                                        <tr
                                            v-for="(user, index) in users.data"
                                            :key="user.id"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ user.name }}</td>
                                            <td>{{ user.email }}</td>
                                            <td>{{ user.created_at }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <Link
                                                        :href="
                                                            route(
                                                                'users.edit',
                                                                user.id
                                                            )
                                                        "
                                                        class="btn btn-primary"
                                                    >
                                                        <i
                                                            class="fas fa-pencil-alt"
                                                        ></i>
                                                    </Link>
                                                    <Link
                                                        :href="
                                                            route(
                                                                'users.destroy',
                                                                user.id
                                                            )
                                                        "
                                                        method="delete"
                                                        class="btn btn-danger"
                                                    >
                                                        <i
                                                            class="fas fa-trash"
                                                        ></i>
                                                    </Link>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-if="users.data == 0">
                                        <tr>
                                            <td colspan="5">
                                                <div class="text-center">
                                                    <h5>
                                                        <i
                                                            class="fas fa-exclamation-triangle"
                                                        ></i>
                                                        No data found
                                                    </h5>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-center p-3" style="background: rgba(0,0,0,.03)">
                                    <Pagination
                                        :links="users.links"
                                    ></Pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
</template>

<script>
//import layout App
import LayoutApp from "../../Layouts/Admin/App.vue";
import Pagination from "../../Components/Pagination.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import _ from "lodash";

export default {
    components: {
        Link,
        Head,
        Pagination,
    },

    data () {
        return {
            isLoading: false,
            q: "",
        };
    },

    layout: LayoutApp,

    methods: {
        search: _.debounce(function() {
            this.$inertia.replace(
                route("users.index", {
                    q: this.q,
                })
            );
        }, 500),
    },

    props: {
        users: Object,
        flash: Object,
    },
};
</script>
