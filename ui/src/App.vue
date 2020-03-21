<template>
    <div>
        <Header/>
        <router-view class="mt-4 mb-4"></router-view>
    </div>
</template>

<script>
    import Header from "@/components/Header";

export default {
    name: 'App',
    components: {Header},
    data() {
        return {
            username: "",
        };
    },
}
</script>
