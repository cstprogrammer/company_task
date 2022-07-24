<template>
    <Head title="Create User" />
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Company</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <Link :href="route('companies.index')">Company</Link>
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
                                        :href="route('companies.index')"
                                        class="btn btn-sm btn-warning"
                                    >
                                        <i class="fas fa-arrow-left"></i> Back
                                    </Link>
                                </h3>
                                <span style="color: red; margin-left: 20px">
                                    [ Note : Mandatory fields are indicated by (*) ]
                                </span>
                            </div>
                            <form @submit.prevent="store()"
                                  class="mb-auto"
                            >
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
                                            placeholder="Enter company name"
                                        />
                                        <div
                                            v-if="errors.name"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Location</label>
                                         <span class="text-danger">
                                            *
                                        </span>
                                        <input
                                            v-model="form.location"
                                            type="text"
                                            name="location"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.location,
                                            }"
                                            placeholder="Enter company location"
                                        />
                                        <div
                                            v-if="errors.location"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.location }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Contact</label>
                                         <span class="text-danger">
                                            *
                                        </span>
                                        <input
                                            v-model="form.contact"
                                            type="text"
                                            name="contact"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.contact,
                                            }"
                                            placeholder="Enter company contact"
                                        />
                                        <div
                                            v-if="errors.contact"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.contact }}
                                        </div>
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
                location: "",
                contact: "",
            }),
            isLoading: false,
        };
    },

    layout: LayoutApp,

    methods: {
        store () {
            this.isLoading = true;
            this.$inertia.post(route('companies.store'), this.form, {
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
