<template>
    <div>
        <b-container>
            <b-table
                    :fields="studentsFields"
                    :items="students"
                    hover
                    striped
            >
            </b-table>
        </b-container>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                studentsFields: [
                    {
                        key: "id",
                        label: "ID",
                    },
                    {
                        key: "name",
                        label: "Name",
                    },
                    {
                        key: "batch",
                        label: "Batch",
                    },
                    {
                        key: "major",
                        label: "Major",
                    }
                ],
                students: [
                    {
                        id: "001201500042",
                        name: "Aprillia Kusumawardhani Pannita",
                        batch: "2015",
                        major: "CIT Information Technology Study Program"
                    }
                ]
            };
        }
    }
</script>
