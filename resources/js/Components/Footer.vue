<template>
    <footer class="pt-14 pb-16 footer">
        <div class="container">
            <div class="pb-12">
                <a href="/" class="flex items-center">
                    <img
                        src="/images/company_logo.png"
                        :alt="$page.props.appName + ' logo'"
                        class="nav-logo mr-2"
                    />
                </a>
            </div>
            <div class="flex flex-col md:flex-row justify-between">
                <div class="flex flex-col md:flex-row">
                    <JetNavLink
                        :href="route('index')"
                        :active="route().current('index')"
                    >
                        Home
                    </JetNavLink>
                </div>
                <div>
                  
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import JetNavLink from "@/Jetstream/NavLink.vue";

export default {
    components: {
        JetNavLink,
    },
};
</script>
