<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Group
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 mb-3 pb-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">Create Group</div>
                            <div class="panel-body">
                                <form>
                                    <div class="form-group">
                                        <input
                                            class="form-control"
                                            type="text"
                                            v-model="name"
                                            placeholder="Group Name"
                                            required
                                        />
                                    </div>
                                    <div class="form-group">
                                        <select
                                            v-model="users"
                                            multiple
                                            id="friends"
                                        >
                                            <option
                                                v-for="(
                                                    user, index
                                                ) in initialUsers"
                                                :key="index"
                                                :value="user.id"
                                            >
                                                {{ user.name }}
                                            </option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="panel-footer text-center">
                                <button
                                    type="submit"
                                    @click.prevent="createGroup"
                                    class="btn-dark"
                                >
                                    Create Group
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
export default {
    props: ["initialUsers"],
    data() {
        return {
            name: "",
            users: [],
        };
    },
    methods: {
        createGroup() {
            axios
                .post("/groups", { name: this.name, users: this.users })
                .then((response) => {
                    this.name = "";
                    this.users = [];
                    this.$emitter.emit("groupCreated", response.data);
                    this.$inertia.get(
                        route("conversations.index", {
                            group_id: response.data.id,
                        })
                    );
                });
        },
    },
};
</script>
