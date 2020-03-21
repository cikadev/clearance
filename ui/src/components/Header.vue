<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="dark">
            <router-link :to="{ name: 'dashboard' }" class="navbar-brand">Clearance</router-link>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item-dropdown>
                        <template v-slot:button-content>
                            Reports
                        </template>
                        <router-link :to="{ name: 'report-student' }" class="dropdown-item">Student</router-link>
                    </b-nav-item-dropdown>
                    <router-link :to="{ name: 'activation' }" class="nav-link">Activation</router-link>
                    <router-link :to="{ name: 'activities' }" class="nav-link">Activities</router-link>
                </b-navbar-nav>

                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown right>
                        <template v-slot:button-content>
                            User
                        </template>
                        <router-link :to="{ name: 'settings' }" class="dropdown-item">Settings</router-link>
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item href="#">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
export default {
    name: "Header",
}
</script>
