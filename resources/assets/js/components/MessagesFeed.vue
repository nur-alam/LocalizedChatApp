<template>
    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li v-for="message in messages"
                :class="`message${message.to == contact.id ? ' sent' : ' received'}`"
                :key="message.id">
                <div class="text">
                    {{ message.text }} <p style="color:green,font-size:8px;"> by {{message.to == contact.id ? 'me' : contact.name}}</p>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "MessagesFeed",
        props : {
            contact : {
                type : Object
            },
            messages : {
                type : Array,
                required : true
            }
        },
        methods : {
            scrollToBottom() {
                setTimeout(()=>{
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 50);
            }
        },
        watch : {
            contact(){
                this.scrollToBottom();
            },
            messages(){
                this.scrollToBottom();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .feed {
        background: #f0f0f0;
        height: 100%;
        max-height: 470px;
        overflow: scroll;
        ul {
            list-style-type: none;
            padding: 5px;
            li {
                &.message {
                    margin: 10px 0;
                    width: 100%;
                    .text {
                        max-width: 200px;
                        border-radius: 5px;
                        padding: 12px;
                        display: inline-block;
                        p{
                            font-size: 10px;
                            padding: 0px;
                            margin: 0px 0px 0px 39px;
                            color: #46462f;

                        }
                    }
                    &.received {
                        text-align: right;
                        .text {
                            background: #b2b2b2;
                        }
                    }
                    &.sent {
                        text-align: left;
                        .text {
                            background: #81c4f9;
                        }
                    }
                }
            }
        }
    }
</style>
