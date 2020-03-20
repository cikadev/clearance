<template>
    <div>
        <Header />
        <b-container>
            <OverviewChartCompleted />
        </b-container>
    </div>
</template>

<script>
import Header from "@/components/Header";
import OverviewChartCompleted from "@/components/OverviewChartCompleted.js";

export default {
    components: {OverviewChartCompleted, Header}
}
</script>