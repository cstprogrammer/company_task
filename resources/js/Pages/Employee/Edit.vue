<template>
    <Head title="Edit User" />
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Company</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <Link :href="route('users.index')">Company</Link>
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
                                        :href="route('employees.index')"
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
                                            placeholder="Enter employee full name"
                                        />
                                        <div
                                            v-if="errors.name"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Employee Number</label>
                                        <span class="text-danger">
                                            *
                                        </span>
                                        <input
                                            v-model="form.employee_number"
                                            type="number"
                                            name="employee_number"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.employee_number,
                                            }"
                                            placeholder="Enter employee number"
                                        />
                                        <div
                                            v-if="errors.employee_number"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.employee_number }}
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
                                            placeholder="Enter employee email address"
                                        />
                                        <div
                                            v-if="errors.email"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.email }}
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
                                            placeholder="Enter employee contact number"
                                        />
                                        <div
                                            v-if="errors.contact"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.contact }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <span class="text-danger">
                                            *
                                        </span>
                                        <input
                                            v-model="form.designation"
                                            type="text"
                                            name="designation"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.designation,
                                            }"
                                            placeholder="Enter employee designation"
                                        />
                                        <div
                                            v-if="errors.designation"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.designation }}
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
                name: this.employee.name,
                employee_number: this.employee.employee_number,
                email: this.employee.email,
                contact: this.employee.contact,
                designation: this.employee.designation
            }),
            isLoading: false,
        };
    },

    layout: LayoutApp,

    methods: {
        update () {
            this.isLoading = true;

            this.$inertia.put(route('employees.update',this.employee.id), this.form, {
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
        employee: Object,
    },
};
</script>
