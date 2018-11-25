<template>
    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li v-for="message in messages"
                :class="`message${message.to == contact.id ? ' sent' : ' received'}`"
                :key="message.id">
                <div class="text">
                    <div class="img">
                        <img :src="message.to == contact.id ? '' : contact.profile_image" alt="">
                    </div>
                    <div class="msg">
                        {{ message.text }}
                        <p>{{message.created_at | momentdate}}</p>
                    </div>
                    <!--{{ message.text }} <p style="color:green,font-size:8px;"> by {{message.to == contact.id ? 'me' : contact.name}}</p>-->
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
        background: #fff;
        height: 100%;
        max-height: 390px;
        overflow: scroll;
        ul {
            list-style-type: none;
            padding: 5px;
            li {
                display: flex;

                &.message {
                    margin: 5px 0;
                    width: 100%;
                    .text {
                        max-width: 400px;
                        border-radius: 5px;
                        padding: 5px;
                        display: flex;
                        flex-direction: row;
                        .img{
                            img {
                                width: 50px;
                                height: 50px;
                                border-radius: 50%;
                            }
                        }
                        .msg{
                            padding: 10px;
                            border-radius: 6px;
                            justify-content: center;
                            vertical-align: middle;
                            position : relative;
                            p{
                                position: absolute;
                                width: 117px;
                                right: 0px;
                                bottom: -22px;
                                border-radius: 6px;
                                text-align: center;
                                display: none;
                                font-weight: bold;
                            }
                            &:hover p{
                                display: block;
                            }
                        }
                        p{
                            font-size: 10px;
                            padding: 0px;
                            margin: 0px 0px 0px 39px;
                            color: #46462f;
                        }
                    }
                    &.received {
                        justify-content: flex-start;
                        .msg{
                            margin-left: 13px;
                            background: #F1F0F0;
                            color : #000;
                        }
                    }
                    &.sent {
                        justify-content: flex-end;
                        .msg{
                            background: #9439f6;
                            color : #fff;
                        }
                    }
                }
            }
        }
    }
</style>
