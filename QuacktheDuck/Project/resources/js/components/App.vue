<template>
    <h1>Hello {{ documents }}</h1>
</template>

<script>
    export default {
        mounted() {
            return {
                axios.get('http://localhost/QuacktheDuck/Project/public/api/documents').then( response => (this.input = response ) ),
            }
        },
        data() {
            return {
                documents: '',
                input: ''
            }
        }
    }
</script>

<style scoped>

</style>
