<template>
    <div>
        <vue-single-select
                v-model="area"
                placeholder="Search places here"
                :options="places"
                :required="true"
                :max-results="4"
        ></vue-single-select>
        <input type="text" name="area" :value="area" hidden>
    </div>
</template>
<script>
    import VueSingleSelect from "vue-single-select";
    export default {
        name: "places",
        data(){
            return {
                area: null,
                places : []
            }
        },
        mounted(){
            axios.get('/getPlaces')
                .then(res => {
                    let data = JSON.parse(res.data);
                    let len = data.length;
                    console.log(data);
                    for(let i =0; i<len; i++){
                        console.log(data[i].name);
                        this.places.push(data[i].name)
                    }
                    console.log(typeof places);
                })
                .catch(err => console.log(err));
        },
        components : {VueSingleSelect}
    }
</script>

<style scoped>

</style>