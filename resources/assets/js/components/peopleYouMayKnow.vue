<template>
    <div class="people-list">
        <h5>People from your area</h5>
        <p> <i class="fas fa-map-marker-alt"></i>
            {{user.area}}
            <a href="" data-toggle="modal" data-target="#exampleModal">
                change location
            </a>
        </p>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose places</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                        <vue-single-select
                                v-model="area"
                                placeholder="Search places here"
                                :options="places"
                                :required="true"
                                :max-results="4"
                        ></vue-single-select>
                        <input type="text" name="area" :value="area" hidden>
                  </div>
                  <button type="submit" @click.prevent="changelocation()" class="btn btn-primary">Change</button>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <ul>
            <li v-for="contact in contacts">
                <div class="img">
                    <img :src="contact.profile_image" alt="">
                </div>
                <div class="text">
                    <p>
                        <a href="">
                            {{contact.name}}
                        </a>
                    </p>
                    <p>{{contact.email}}</p>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import VueSingleSelect from "vue-single-select";
    export default {
        name: "peopleYouMayKnow",
        props:{
            user : {
                type : Object,
                required : true
            }
        },
        data(){
          return {
              contacts : null,
              area: null,
              places : []
          }
        },

        methods : {

            changelocation()
            {
                axios.post('/changelocation',{
                    area : this.area
                }).then(res=>{
                    //console.log(res.data);
                    window.location = "/chat";
                }).catch(err=>console.log(err));
            }

        },

        mounted(){

            axios.get('/localizedusers')
                .then(res=>{
                    this.contacts = res.data;
                }).catch(err => console.log(err));

            axios.get('/getPlaces')
                .then(res => {
                    let data = JSON.parse(res.data);
                    let len = data.length;
                    for(let i =0; i<len; i++){
                        //console.log(data[i].name);
                        this.places.push(data[i].name)
                    }
                })
                .catch(err => console.log(err));

        },

        components : {VueSingleSelect}
    }
</script>

<style lang="scss" scoped>
.people-list{
    flex : 2;
    height: 500px;
    ul{
        list-style-type: none;
        padding: 0;
      li{
          display: flex;
          flex-direction: row;
          .img{
              img {
                  width: 60px;
                  height: 60px;
              }
          }
          .text{
                margin-left : 10px;
          }
      }
    }
}
</style>