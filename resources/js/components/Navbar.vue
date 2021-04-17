<template>
  <nav>
    <div class="container">
      <div class="relative flex items-center justify-between h-16">
        <div class="absolute inset-y-0 right-0 flex items-center lg:hidden">
          <!-- Mobile menu button-->
          <button
            type="button"
            class="inline-flex items-center justify-center p-2 rounded-md bg-transparent text-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
            aria-controls="mobile-menu"
            aria-expanded="false"
            @click="showMobile = !showMobile"
          >
            <span class="sr-only">Open main menu</span>
            <!--
            Icon when menu is closed.

            Heroicon name: outline/menu

            Menu open: "hidden", Menu closed: "block"
          -->
            <svg
              class="block h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
            <!--
            Icon when menu is open.

            Heroicon name: outline/x

            Menu open: "block", Menu closed: "hidden"
          -->
            <svg
              class="hidden h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
        <div class="flex-1 flex items-center justify-center lg:justify-between">
          <div class="flex-shrink-0 flex items-center">
            <a href="/" class="flex items-center">
              <img
                src="/images/company_logo.png"
                :alt="appName + ' logo'"
                class="nav-logo mr-2"
              />
             <span>{{ appName }}</span> 
            </a>
          </div>
          <div class="hidden lg:flex align-middle lg:ml-6">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="/" class="nav-link">Home</a>

            <div v-if="canLogin" class="hidden lg:flex">
              <inertia-link
                v-if="$page.props.user"
                href="/dashboard"
                class="nav-link"
              >
                Dashboard
              </inertia-link>

              <template v-else>
                <inertia-link :href="route('login')" class="nav-link">
                  Login
                </inertia-link>

                <inertia-link
                  v-if="canRegister"
                  :href="route('register')"
                  class="nav-link"
                >
                  Register
                </inertia-link>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div
      class="lg:hidden transition duration-150 ease-in-out"
      id="mobile-menu"
      v-if="showMobile"
    >
      <div
        class="px-2 pt-2 pb-3 flex flex-col items-center justify-center text-center"
      >
        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
        <a href="/" class="nav-link">Home</a>
        <div v-if="canLogin" class="flex flex-col lg:flex-row">
          <inertia-link
            v-if="$page.props.user"
            href="/dashboard"
            class="nav-link"
          >
            Dashboard
          </inertia-link>

          <template v-else>
            <inertia-link :href="route('login')" class="nav-link">
              Login
            </inertia-link>

            <inertia-link
              v-if="canRegister"
              :href="route('register')"
              class="nav-link"
            >
              Register
            </inertia-link>
          </template>
        </div>
      </div>
    </div>
  </nav>
</template>


<script>
export default {
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    appName: String,
  },
  data() {
    return {
      showMobile: false,
    };
  },
  components: {},
};
</script>