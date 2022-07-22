<template>
    <div class="login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="" class="h1"><b>Company</b>Task</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <form @submit.prevent="storeLogin">
                        <div class="input-group mb-3">
                            <input
                                type="email"
                                :class="{ 'is-invalid': errors.email }"
                                class="form-control"
                                placeholder="Email"
                                v-model="form.email"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <div v-if="errors.email" class="invalid-feedback">
                                {{ errors.email }}
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input
                                type="password"
                                :class="{ 'is-invalid': errors.password }"
                                class="form-control"
                                placeholder="Password"
                                v-model="form.password"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div
                                v-if="errors.password"
                                class="invalid-feedback"
                            >
                                {{ errors.password }}
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-block"
                                    v-if="!isLoading"
                                >
                                    Sign In
                                </button>
                                <button
                                    type="Button"
                                    disabled
                                    class="btn btn-primary btn-block"
                                    v-if="isLoading"
                                >
                                    <span
                                        class="spinner-border spinner-border-sm"
                                        role="status"
                                        aria-hidden="true"
                                    ></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import layout App
import LayoutApp from "../../Layouts/Auth/App.vue";

//import reactivity API dari vue
import { reactive } from "vue";

//import inertia adapter
import { Inertia } from "@inertiajs/inertia";

export default {
    data () {
        return {
            form: reactive({
                email: "",
                password: ""
            }),
            isLoading: false,
        };
    },

    //set layout
    layout: LayoutApp,

    methods: {
        storeLogin () {
            this.isLoading = true;
            Inertia.post("/login", this.form, {
                onSuccess: (data) => {
                    this.isLoading = false;
                },
                onError: (data) => {
                    this.isLoading = false;
                },
            });
        }
    },

    //get props
    props: {
        errors: Object,
    },
};
</script>

<style></style>
