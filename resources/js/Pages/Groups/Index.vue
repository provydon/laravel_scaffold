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
                    <div class="p-4 mb-3 pb-8">
                        <inertia-link
                            :href="route('groups.create')"
                            class="btn-dark"
                        >
                            Create Group
                        </inertia-link>
                    </div>
                    <div class="p-4 mb-3 pb-8">
                        <template v-if="groups.length > 0">
                            <group-chat
                                v-for="group in groups"
                                :group="group"
                                :key="group.id"
                            ></group-chat>
                        </template>

                        <template v-else>
                            <div>No Groups Yet</div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import Groupchat from "./Chat.vue";
import JetButton from "@/Jetstream/Button";

export default {
    components: { Groupchat },
    props: ["initialGroups", "user"],
    data() {
        return {
            groups: [],
        };
    },
    mounted() {
        this.groups = this.initialGroups;
        emitter.on("groupCreated", (group) => {
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
    mounted() {},
};
</script>
