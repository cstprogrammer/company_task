<template>
    <Head title="Create User" />
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create User</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <Link :href="route('users.index')">User</Link>
                            </li>
                            <li class="breadcrumb-item active">Create</li>
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
                                        :href="route('users.index')"
                                        class="btn btn-sm btn-warning"
                                    >
                                        <i class="fas fa-arrow-left"></i> Back
                                    </Link>
                                </h3>
                            </div>
                            <form @submit.prevent="store()" class="mb-auto">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.name,
                                            }"
                                            placeholder="Enter name"
                                        />
                                        <div
                                            v-if="errors.name"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            name="email"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.email,
                                            }"
                                            placeholder="Enter email"
                                        />
                                        <div
                                            v-if="errors.email"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.email }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input
                                            v-model="form.password"
                                            type="password"
                                            name="password"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.password,
                                            }"
                                            placeholder="Password"
                                        />
                                        <div
                                            v-if="errors.password"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.password }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input
                                            v-model="form.password_confirmation"
                                            type="password"
                                            name="password_confirmation"
                                            class="form-control"
                                            placeholder="Password"
                                        />
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button
                                        v-if="!isLoading"
                                        type="submit"
                                        class="btn btn-sm btn-primary"
                                    >
                                        <i class="fas fa-save"></i> Save
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
                                        Saving...
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
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            }),
            isLoading: false,
        };
    },

    layout: LayoutApp,

    methods: {
        store () {
            this.isLoading = true;
            this.$inertia.post(route('users.store'), this.form, {
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
    },
};
</script>
