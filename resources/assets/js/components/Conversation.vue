<template>
    <div class="conversation">
        <h1>{{ contact ? contact.name : 'Select a contact' }}</h1>

        <MessagesFeed :user="user" :contact="contact" :messages="messages" />

        <MessageComposer @send="sendMessage" />

    </div>
</template>

<script>
    import MessagesFeed from './MessagesFeed';
    import MessageComposer from './MessageComposer';

    export default {
        name: "Conversation",

        props : {
            contact : {
                type : Object,
                default : null
            },
            user : {
                type : Object,
                default : null
            },
            messages:{
                type : Array,
                default:[]
            }
        },

        methods : {
            sendMessage(text){
                if(!this.contact){
                    return;
                }
                axios.post('/conversation/send', {
                    contact_id : this.contact.id,
                    text : text
                }).then((res) => {
                    this.$emit('sendMsg', res.data);
                }).catch(err => console.log(err));
            }
        },

        components : {MessagesFeed,MessageComposer}

    }
</script>

<style lang="scss" scoped>
    .conversation {
        flex: 3;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        h1 {
            font-size: 20px;
            padding: 10px;
            margin: 0;
            border-bottom: 1px dashed lightgray;
        }
    }
</style>