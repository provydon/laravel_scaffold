<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Groups
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <group-chat
                        v-for="group in groups"
                        :group="group"
                        :key="group.id"
                    ></group-chat>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Groupchat from "./Chat.vue";

export default {
    components: { Groupchat, AppLayout },
    props: ["initialGroups", "user"],
    data() {
        return {
            groups: [],
        };
    },
    mounted() {
        this.groups = this.initialGroups;
        Bus.$on("groupCreated", (group) => {
            this.groups.push(group);
        });
        this.listenForNewGroups();
    },
    methods: {
        listenForNewGroups() {
            Echo.private("users." + this.user.id).listen(
                "GroupCreated",
                (e) => {
                    this.groups.push(e.group);
                }
            );
        },
    },
};
</script>
