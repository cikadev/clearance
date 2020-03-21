<template>
    <div>
        <b-container>
            <b-row>
                <b-col>
                    <b-card title="Change password">
                        <b-form>
                            <b-form-group
                                    label="New password"
                                    label-for="password-new"
                            >
                                <b-input
                                        id="password-new"
                                        type="password"
                                        v-model="passwordNew"
                                ></b-input>
                            </b-form-group>
                        </b-form>

                        <b-button type="submit">
                            Submit
                        </b-button>
                    </b-card>
                </b-col>
                <b-col>2 of 3</b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
    export default {
        name: "Profile",
        data() {
            return {
                passwordNew: ""
            };
        }
    }
</script>
