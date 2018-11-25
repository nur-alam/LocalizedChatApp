<template>
    <div class="chat-app">
        <peopleYouMayKnow :user="user"></peopleYouMayKnow>
        <Contactlist :contacts="contacts" @selected="startConversationWith" />
        <Conversation :contact="selectedContact" :messages="messages" @sendMsg="saveNewMsg"/>
    </div>
</template>

<script>

    import peopleYouMayKnow from './peopleYouMayKnow';

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
                    console.log(e.message);
                    this.handleIncoming(e.message);
                });

            axios.get('/contacts')
                .then(res => {
                    this.contacts = res.data;
                    //console.log(res.data);
                })
                .catch(err => console.log(err));

            axios.get('/getPlaces')
                .then(res => {
                    //this.contacts = res.data;
                    console.log(res);
                })
                .catch(err => console.log(err));
        },

        methods : {
            startConversationWith(contact){
                this.updateUnreadCount(contact, true);
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

                if( this.selectedContact && message.from == this.selectedContact.id ){
                    this.saveNewMsg(message);
                    return;
                }
                console.log(message);
                this.updateUnreadCount(message.from_contact, false);
            },
            updateUnreadCount(contact, reset){
                this.contacts = this.contacts.map((single) => {
                    if(single.id != contact.id){
                        return single;
                    }
                    if(reset)
                        single.unread = 0;
                    else
                        single.unread += 1;

                    return single;
                })
            },
        },

        components : {peopleYouMayKnow,Conversation,Contactlist}
    }
</script>

<style scoped>
.chat-app{
    display: flex;
    flex-wrap : wrap;
}
</style>