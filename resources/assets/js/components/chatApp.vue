<template>
    <div class="chat-app">

        <Conversation :contact="selectedContact" :messages="messages" @sendMsg="saveNewMsg"/>

        <Contactlist :contacts="contacts" @selected="startConversationWith" />

    </div>
</template>

<script>

    import Conversation from './Conversation';

    import Contactlist from './Contactlist';

    export default {
        name: "chatApp",

        props : {
            user : {
                type : Object,
                required : true
            }
        },

        data() {
            return {
                selectedContact: null,
                messages: [],
                contacts: []
            };
        },

        mounted(){

            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    //console.log(e);
                    this.handleIncoming(e.message);
                });

            axios.get('/contacts')
                .then(res => {
                    this.contacts = res.data;
                })
                .catch(err => console.log(err));
            // setInterval(function () {
            //     console.log(this.messages);
            // },3000)
        },

        methods : {
            startConversationWith(contact){
                console.log(contact);
                axios.get(`/conversation/${contact.id}`)
                    .then(res => {
                        //console.log(res.data);
                        //console.log(contact);
                        this.messages = res.data;
                        this.selectedContact = contact;
                    });
            },
            saveNewMsg(msg){

                if(this.selectedContact){
                    this.startConversationWith(this.selectedContact);
                }

                //this.messages.push(msg);
            },
            handleIncoming(message){
                console.log(message);
                if( this.selectedContact && message.from == this.selectedContact.id ){
                    this.saveNewMsg(message);
                    return;
                }
                alert(message.text);
            }
        },

        components : {Conversation,Contactlist}
    }
</script>

<style scoped>
.chat-app{
    display: flex;
}
</style>