<template>
    <div class="people-list">
        <h5>People from your area</h5>
        <p><i class="fas fa-map-marker-alt"></i> {{user.area}} <a href="">change location</a></p>
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
              contacts : null
          }
        },
        mounted(){
            axios.get('/localizedusers')
                .then(res=>{
                    //console.log(this.user.area);
                    console.log(res.data);
                    this.contacts = res.data;
                }).catch(err => console.log(err));
        }
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