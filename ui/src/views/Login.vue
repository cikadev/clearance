<template>
    <div>
        <b-form @submit.prevent="onSubmit">
            <b-form-group
                label="Username"
                label-for="input-username"
            >
                <b-form-input
                    id="input-username"
                    v-model="form.username"
                    required
                    type="text"
                    placeholder="Enter username"
                ></b-form-input>
            </b-form-group>
            <b-form-group
                    label="Password"
                    label-for="input-username"
            >
                <b-form-input
                        id="input-password"
                        v-model="form.password"
                        required
                        type="password"
                        placeholder="Enter password"
                ></b-form-input>
            </b-form-group>
            <div v-if="!submitting">
                <b-button type="submit">Login</b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
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

        }
    }
}
</script>
