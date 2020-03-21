<template>
    <div>
        <b-container>
            <b-table
                    :fields="activitiesFields"
                    :items="activities"
                    hover
                    striped
            >
                <template v-slot:cell(action)="row">
                    <b-button @click="row.toggleDetails">
                        <b-icon icon="gear"></b-icon>
                    </b-button>
                </template>
                <!-- TODO -->
                <template v-slot:row-details="row">
                    <b-card>
                        <b-row class="mb-2">
                            <b-col class="text-sm-right" sm="3"><b>Age:</b></b-col>
                            <b-col>{{ row.item.age }}</b-col>
                        </b-row>

                        <b-row class="mb-2">
                            <b-col class="text-sm-right" sm="3"><b>Is Active:</b></b-col>
                            <b-col>{{ row.item.isActive }}</b-col>
                        </b-row>
                    </b-card>
                </template>
            </b-table>
        </b-container>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                activitiesFields: [
                    {
                        key: "name",
                        label: "Name"
                    },
                    {
                        key: "isDependent",
                        label: "Dependent"
                    },
                    {
                        key: "prevStep",
                        label: "Previous Step"
                    },
                    {
                        key: "department",
                        label: "Department"
                    },
                    "action"
                ],
                activities: [
                    {
                        name: "Completing Thesis Defence",
                        dependent: false,
                        prevStep: "",
                        department: "Faculty"
                    }
                ],
            };
        },
    };
</script>
