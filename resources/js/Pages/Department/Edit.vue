<template>
    <Head title="Edit User" />
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Department</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <Link :href="route('departments.index')">Department</Link>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
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
                    <div class="col-md-6 m-auto">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <Link
                                        :href="route('departments.index')"
                                        class="btn btn-sm btn-warning"
                                    >
                                        <i class="fas fa-arrow-left"></i> Back
                                    </Link>
                                </h3>
                                <span style="color: red; margin-left: 20px">
                                    [ Note : Mandatory fields are indicated by (*) ]
                                </span>
                            </div>
                            <form @submit.prevent="update()" class="mb-auto">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <span class="text-danger">
                                            *
                                        </span>
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.name,
                                            }"
                                            placeholder="Enter department name"
                                        />
                                        <div
                                            v-if="errors.name"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button
                                        v-if="!isLoading"
                                        type="submit"
                                        class="btn btn-sm btn-success"
                                    >
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                    <button
                                        type="Button"
                                        disabled
                                        class="btn btn-primary btn-sm"
                                        v-if="isLoading"
                                    >
                                        <span
                                            class="spinner-border spinner-border-sm"
                                            role="status"
                                            aria-hidden="true"
                                        ></span>
                                        Updating...
                                    </button>
                                </div>
                            </form>
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
import { Link, Head } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";

export default {
    components: {
        Link,
        Head,
    },

    data () {
        return {
            form: reactive({
                name: this.department.name
            }),
            isLoading: false,
        };
    },

    layout: LayoutApp,

    methods: {
        update () {
            this.isLoading = true;

            this.$inertia.put(route('departments.update',this.department.id), this.form, {
                onSuccess: (data) => {
                    this.isLoading = false;
                },
                onError: (data) => {
                    this.isLoading = false;
                },
            });
        },
    },

    props: {
        errors: Object,
        department: Object,
    },
};
</script>
