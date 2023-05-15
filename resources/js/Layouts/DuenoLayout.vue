<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>


<template>
    <div class="tipografia">
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-white-100" style="background-color: #f0f0f0">
            <nav style="background-color: #EF7728; height: 80px; width: 100%; position: fixed; z-index: 101; top: 0" >
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center">
                                <button onclick="window.location.href='/inicio'" :active="route().current('/inicio')">
                                    <img src="/logoWop2.png" class="logo">
                                </button>
                            </div>
                        </div>
                        <div id='search-box' class="buttons" style="margin-right: 50px; margin-left: 80px">
                            <form action='/buscar'   class='search-form' method='get' target='_top'>
                                <input id='search-text' name='text' placeholder='Buscar productos...' type='text'/>
                                <button  id='search-button' type='submit' style="left: 640px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#28285B" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="flex" style="margin-top: 10px">
                            <div class="hidden sm:flex sm:items-center">
                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                            </button>

                                            <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </button>
                                        </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <DropdownLink :href="route('login')">
                                                Negocios
                                            </DropdownLink>
                                            <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                                API Tokens
                                            </DropdownLink>

                                            <div class="border-t border-gray-100" />

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <DropdownLink as="button">
                                                    Log Out
                                                </DropdownLink>
                                            </form>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id='search-box' class="buttons2">
                    <form action='/buscar' class='search-form' method='get' target='_top'>
                        <input id='search-text'  name='text' placeholder='Buscar productos...' type='text'/>
                        <button  id='search-button' type='submit' style="left: 262px; margin-top: 0px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#28285B" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>
                <a href="https://wa.me/5491128495155?text=Buenos%20dias!%20Me%20gustaria%20tener%20más%20informacion" class="whatsapp" target="_blank">
                    <svg style="margin-left: 14px; margin-top: 12px;" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                    </svg>
                </a>
                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}">
                    <div class="pt-2 pb-3 space-y-1" style="text-align: center; position: center">


                    </div>

                    <!-- Responsive Settings Options -->
                </div>
            </nav>
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Quicksand:wght@300;400&display=swap');
.container-3{
    width: 300px;
    vertical-align: middle;
    white-space: nowrap;
    position: relative;
}
.tipografia{
    font-family: 'Lato', sans-serif;
    font-family: 'Quicksand', sans-serif;
}

.container-3 input#search::-webkit-input-placeholder {
    color: #65737e;
}

.container-3 input#search:-moz-placeholder { /* Firefox 18- */
    color: #65737e;
}

.container-3 input#search::-moz-placeholder {  /* Firefox 19+ */
    color: #65737e;
}

.container-3 input#search:-ms-input-placeholder {
    color: #65737e;
}

.container-3 .icon{
    position: absolute;
    top: 50%;
    margin-left: 17px;
    margin-top: 12px;
    z-index: 1;
    color: #2b303b;

    -webkit-transition: all .55s ease;
    -moz-transition: all .55s ease;
    -ms-transition: all .55s ease;
    -o-transition: all .55s ease;
    transition: all .55s ease;
}

.container-3 input#search{
    width: 400px;
    background: white;
    border: none;
    font-size: 10pt;
    float: left;
    color: #2b303b;
    padding-left: 45px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
}


@media (min-width: 750px) {
    .buttons2{
        display: none;
    }
    .container-3 input#search{
        width: 400px;
        background: white;
        border: none;
        font-size: 10pt;
        float: left;
        color: #2b303b;
        padding-left: 45px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }

    .box{
        margin-left: 250%;
    }
}
@media (max-width: 749px) {
    .buttons{
        display: none;
    }
    .container-3 input#search{
        width: 250px;
        background: white;
        border: none;
        font-size: 10pt;
        float: left;
        color: #2b303b;
        padding-left: 45px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }

    .box{
        margin-left: 18px;
    }
}

#myBtn {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 30px;
    z-index: 99;
    font-size: 18px;
    border: none;
    outline: none;
    background-color: red;
    color: white;
    cursor: pointer;
    padding: 15px;
    border-radius: 4px;
}

#myBtn:hover {
    background-color: #555;
}


.btn-flotante {
    font-size: 16px; /* Cambiar el tamaño de la tipografia */
    text-transform: uppercase; /* Texto en mayusculas */
    font-weight: bold; /* Fuente en negrita o bold */
    color: #ffffff; /* Color del texto */
    border-radius: 5px; /* Borde del boton */
    letter-spacing: 2px; /* Espacio entre letras */
    background-color: #3d107b; /* Color de fondo */
    padding: 12px 12px; /* Relleno del boton */
    position: fixed;
    bottom: 30px;
    right: 20px;
    transition: all 300ms ease 0ms;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    z-index: 99;
}
.btn-flotante:hover {
    background-color: #A9CCFF; /* Color de fondo al pasar el cursor */
    box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
    transform: translateY(-7px);
}
@media only screen and (max-width: 600px) {
    .btn-flotante {
        font-size: 14px;
        padding: 12px 20px;
        bottom: 20px;
        right: 20px;
    }
}

*,
*:before,
*:after {

}

body {
    background: #333;
    font-family: "Open Sans", Helvetica, Arial, sans-serif;
}

.buttons {
    margin-top: 15px;
    text-align: center;
    border-radius: 30px;
}

.blob-btn {
    z-index: 1;
    position: relative;
    padding: 10px 20px;
    margin-bottom: 30px;
    text-align: center;
    text-transform: uppercase;
    color: #0505a9;
    font-size: 12px;
    font-weight: bold;
    background-color: transparent;
    outline: none;
    border: none;
    transition: color 0.5s;
    cursor: pointer;
    border-radius: 30px;
}
.blob-btn:before {
    content: "";
    z-index: 1;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    border: 2px solid #0505a9;
    border-radius: 30px;
}
.blob-btn:after {
    content: "";
    z-index: -2;
    position: absolute;
    left: 3px;
    top: 3px;
    width: 100%;
    height: 100%;
    transition: all 0.3s 0.2s;
    border-radius: 30px;
}
.blob-btn:hover {
    color: #ffffff;
    border-radius: 30px;
}
.blob-btn:hover:after {
    transition: all 0.3s;
    left: 0;
    top: 0;
    border-radius: 30px;
}
.blob-btn__inner {
    z-index: -1;
    overflow: hidden;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    border-radius: 30px;
    background: #ffffff;
}
.blob-btn__blobs {
    position: relative;
    display: block;
    height: 100%;
    filter: url("#goo");
}
.blob-btn__blob {
    position: absolute;
    top: 2px;
    width: 25%;
    height: 100%;
    background: #0505a9;
    border-radius: 100%;
    transform: translate3d(0, 150%, 0) scale(1.7);
    transition: transform 0.45s;
}
@supports (filter: url("#goo")) {
    .blob-btn__blob {
        transform: translate3d(0, 150%, 0) scale(1.4);
    }
}
.blob-btn__blob:nth-child(1) {
    left: 0%;
    transition-delay: 0s;
}
.blob-btn__blob:nth-child(2) {
    left: 30%;
    transition-delay: 0.08s;
}
.blob-btn__blob:nth-child(3) {
    left: 60%;
    transition-delay: 0.16s;
}
.blob-btn__blob:nth-child(4) {
    left: 90%;
    transition-delay: 0.24s;
}
.blob-btn:hover .blob-btn__blob {
    transform: translateZ(0) scale(1.7);
}
@supports (filter: url("#goo")) {
    .blob-btn:hover .blob-btn__blob {
        transform: translateZ(0) scale(1.4);
    }
}

#search-box {
    position: relative;
    width: 60%;
    margin-top: 5px;
}

#search-text {
    font-size: 14px;
    color: #ddd;
    border-width: 0;
    background: transparent;
}

#search-box input[type="text"] {
    width: 90%;
    padding: 5px 0 12px 1em;
    color: #333;
    outline: none;
}
#search-button {
    margin-top: 15px;
    position: absolute;
    top: 0;
    right: 0;
    height: 32px;
    width: 0px;
    font-size: 14px;
    color: #fff;
    text-align: center;
    line-height: 4px;
    border-width: 0;
    background-color: white;
    -webkit-border-radius: 0px 5px 5px 0px;
    -moz-border-radius: 0px 5px 5px 0px;
    border-radius: 3px;
    cursor: pointer;
}
.whatsapp {
    position:fixed;
    width:60px;
    height:60px;
    bottom:40px;
    right:40px;
    background-color:#25d366;
    color:#FFF;
    border-radius:50px;
    text-align:center;
    font-size:30px;
    z-index:100;
}

.whatsapp-icon {
    margin-top:13px;
}




@media (max-width: 400px) {
    .search-form{
        margin-bottom: 20px;
        margin-left: 70px;
        width: 100%;
        margin-top: 25px;
        height: 32px;
        border: 1px solid #c5c5c5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 15px;
        background-color: #fff;
        overflow: hidden;
    }

    .logo{
        width: 150px;
        margin-left: 85px;
    }
}

@media (min-width: 401px) {
    .search-form{
        margin-bottom: 20px;
        margin-left: 15px;
        width: 90%;
        margin-top: 15px;
        height: 32px;
        box-shadow: 0px 1px 4px #444444;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 3px;
        background-color: #fff;
        overflow: hidden;
    }
    .logo{
        width: 150px;
    }
}

</style>

<!--

<Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
<template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                {{ $page.props.user.current_team.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                </svg>
                                            </button>
                                        </span>
</template>

<template #content>
    <div class="w-60">
        <template v-if="$page.props.jetstream.hasTeamFeatures">
            <div class="block px-4 py-2 text-xs text-gray-400">
                Manage Team
            </div>

            <DropdownLink :href="route('teams.show', $page.props.user.current_team)">
                Team Settings
            </DropdownLink>

            <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                Create New Team
            </DropdownLink>

            <div class="border-t border-gray-100" />

            <div class="block px-4 py-2 text-xs text-gray-400">
                Switch Teams
            </div>

            <template v-for="team in $page.props.user.all_teams" :key="team.id">
                <form @submit.prevent="switchToTeam(team)">
                    <DropdownLink as="button">
                        <div class="flex items-center">
                            <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <div>{{ team.name }}</div>
                        </div>
                    </DropdownLink>
                </form>
            </template>
        </template>
    </div>
</template>
</Dropdown>
</div>

<div class="ml-3 relative">
<Dropdown align="right" width="48">
    <template #trigger>
        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
        </button>

        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </button>
                                        </span>
    </template>

    <template #content>
        <div class="block px-4 py-2 text-xs text-gray-400">
            Manage Account
        </div>

        <DropdownLink :href="route('profile.show')">
            Profile
        </DropdownLink>

        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
            API Tokens
        </DropdownLink>

        <div class="border-t border-gray-100" />

        <form @submit.prevent="logout">
            <DropdownLink as="button">
                Log Out
            </DropdownLink>
        </form>
    </template>
</Dropdown>
</div>
</div>

-->
