<template>
    <div>
    <form>
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
              </button>
           </div>
           <div class="modal-body">
             <p>Modal body text goes here.</p>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-primary">Save changes</button>
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           </div>
       </div>
    </div>
  </div>
        <vue-single-select
                v-model="area"
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
                    //console.log(data);
                    for(let i =0; i<len; i++){
                        //console.log(data[i].name);
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