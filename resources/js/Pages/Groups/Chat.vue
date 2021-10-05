<template>
    <div>
        <div class="panel panel-primary">
            <div class="panel-heading" id="accordion">
                <span class="glyphicon glyphicon-comment"></span>
                {{ group.name }}
                <div class="btn-group pull-right">
                    <a
                        type="button"
                        class="btn btn-default btn-xs"
                        data-toggle="collapse"
                        data-parent="#accordion-"
                        :href="'#collapseOne-' + group.id"
                    >
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                </div>
            </div>
            <div
                class="panel-collapse collapse"
                :id="'collapseOne-' + group.id"
            >
                <div class="panel-body chat-panel">
                    <ul class="chat flex flex-col">
                        <li
                            v-for="(conversation, index) in conversations"
                            :key="index"
                            class="w-3/4"
                            :class="{
                                'justify-end': conversation.user.id == user.id,
                            }"
                        >
                            <!-- <span class="chat-img pull-left">
                            <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                        </span> -->
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">{{
                                        conversation.user.name
                                    }}</strong>
                                </div>
                                <p>
                                    {{ conversation.message }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input
                            required
                            id="btn-input"
                            type="text"
                            class="form-control input-sm"
                            placeholder="Type your message here..."
                            v-model="message"
                            @keyup.enter="store()"
                            autofocus
                        />
                        <span class="input-group-btn">
                            <button
                                class="btn-dark"
                                id="btn-chat"
                                @click.prevent="store()"
                            >
                                Send
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["group", "user"],
    data() {
        return {
            conversations: this.group.conversations,
            message: "",
            group_id: this.group.id,
        };
    },
    mounted() {
        this.listenForNewMessage();
    },
    methods: {
        store() {
            axios
                .post("/conversations", {
                    message: this.message,
                    group_id: this.group.id,
                })
                .then((response) => {
                    this.message = "";
                    this.conversations.push(response.data);
                });
        },
        listenForNewMessage() {
            Echo.private("groups." + this.group.id).listen(
                "NewMessage",
                (e) => {
                    // console.log("new msg: ", e);
                    // console.log('conversations: ',this.conversations);
                    this.conversations.push(e.conversation);
                }
            );
        },
    },
};
</script>
