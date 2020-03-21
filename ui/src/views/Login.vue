<template>
    <div>
        <b-container>
            <b-alert
                    :show="warnMsg != null"
                    @dismissed="warnMsg = null"
                    dismissible
                    variant="danger">
                {{ warnMsg }}
            </b-alert>
            <b-form @submit.prevent="onSubmit">
                <b-form-group
                        label="Username"
                        label-for="input-username"
                >
                    <b-form-input
                            :disabled="submitting"
                            id="input-username"
                            placeholder="Enter username"
                            required
                            type="text"
                            v-model="form.username"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                        label="Password"
                        label-for="input-username"
                >
                    <b-form-input
                            :disabled="submitting"
                            id="input-password"
                            placeholder="Enter password"
                            required
                            type="password"
                            v-model="form.password"
                    ></b-form-input>
                </b-form-group>
                <div v-if="!submitting">
                    <b-button type="submit">Login</b-button>
                </div>
                <div v-else>
                    <b-spinner label="Spinning" variant="primary"></b-spinner>
                </div>
            </b-form>
        </b-container>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            warnMsg: null,
            submitting: false,
            form: {
                username: "",
                password: ""
            }
        };
    },
    methods: {
        onSubmit() {
            this.submitting = true;

            // TODO
            // Mock login
            if (this.form.password === "admin" && this.form.username === "admin") {
                setTimeout(() => {
                    this.submitting = false;
                    this.$router.push({name: "dashboard"});
                }, 1000);
            } else {
                setTimeout(() => {
                    this.submitting = false;
                    this.warnMsg = "Invalid username or password";
                }, 1000);
            }
        }
    }
}
</script>
