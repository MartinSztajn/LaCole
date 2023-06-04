<script setup>
    const logout = () => {
        Inertia.post(route('logout'));
    };
</script>
<template>
    <div class="tipografia">
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-white-100" style="background-color: #F5F1F1">

            <nav style="background-color: #121212; width: 100%; position: fixed; z-index: 101; top: 0" >
                <!-- Primary Navigation Menu -->
                <div style="background-color: #121212;">
                    <div class="md:flex hidden">
                        <div class="container">
                            <div class="row">
                                <div class="col-3">
                                    <div class="flex-shrink-0 flex items-center">
                                        <button style="margin-top: 10px" onclick="window.location.href='/inicio'" :active="route().current('/inicio')">
                                            <img src="/fotos/COLEMARKET.jpg" class="logo">
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="search-box buttons" style="margin-left: 60px; margin-top: 25px; margin-right: 60px; width: 600px;">
                                    <div class='search-form' method='get' target='_top'>
                                        <input class='search-text' placeholder='Buscar productos...' style="padding-left: 10px" v-model="form.buscador" @input="buscarParcial"/>
                                        <button @click="buscar" class='search-button' type='submit'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#C5C5C5" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div v-if="form.buscador != ''" style="margin-left: 15px; width: 500px; background-color: #302D2D; position: fixed; z-index: 101;">
                                        <div  v-for="producto in resultados" @click="verProductoDetalle(producto.nomCat, producto.nombre)">
                                            <img :src="'/fotos/' + producto.path" style="float: left; width: 80px; height: 80px; margin: 5px; margin-right: 30px">
                                            <a :href="'/verProductoDetalle/' + producto.nomCat + '/' + producto.nombre">
                                                <h1 style="text-align: left; font-size: 20px; padding-top: 10px; color: #EBE9E9">
                                                    <b>{{producto.nombre}}</b>
                                                </h1>
                                            </a>
                                            <h1 style="text-align: left; font-size: 15px; color: #C5C5C5">{{producto.nomCat}}</h1>
                                            <h1 style="text-align: left; font-size: 15px; color: #C5C5C5">${{producto.precio}} ARS</h1>

                                            <hr style="width: 100%; border: 1px solid black;">
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-3">
                                    <div class="flex" style="float: right; margin: 25px;display: flex;justify-content: center;" v-if="!this.$page.props.user">
                                        <div class="flex-shrink-0 flex items-center" style="margin-right: 20px; color: white">
                                            <a :href="route('register')">Registrate</a>
                                        </div>
                                        <div class="flex-shrink-0 flex items-center" style="margin-right: 20px">
                                            <hr style="border:none; border-left: 3px solid white; height: 30px; width: 1px;">
                                        </div>
                                        <div class="flex-shrink-0 flex items-center"  style="color: white">
                                            <a :href="route('login')">Ingresá</a>
                                        </div>
                                    </div>
                                    <div style="float: right; margin: 25px;" v-if="this.$page.props.user">
                                        <div style="margin-right: 20px; color: white">
                                            <div>
                                                <a style="display: flex; color: white; text-align: center; font-size: 20px; background-color: #121212; border: none;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg v-if="cantOfertasTotal == 0" style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                                    </svg>
                                                    <div v-if="cantOfertasTotal > 0" style="margin-right: 10px;" class="ofertas">{{cantOfertasTotal}}</div>

                                                    <p>{{$page.props.user.name}}</p>
                                                </a>
                                                <ul style="border: none;"  class="dropdown-menu" aria-labelledby="dropdownMenuLink" >

                                                    <li>
                                                        <a href="/dashboard" style="width: 150px">
                                                            <DropdownLink as="button" style="text-align: center">
                                                                Productos
                                                            </DropdownLink>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/user/profile" style="width: 150px">
                                                            <DropdownLink as="button" style="text-align: center">
                                                                Cuenta
                                                            </DropdownLink>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form @submit.prevent="logout" style="width: 150px">
                                                            <DropdownLink as="button" style="text-align: center">
                                                                Log Out
                                                            </DropdownLink>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filtros celular" style="text-align: center; width: 100%; position: fixed; z-index: 100">
                            <div class="compu" @mouseleave="handleMouseLeaveCuatroCampos">
                                    <div   style="display: flex; color: white; text-align: center; font-size: 20px; position: absolute">
                                        <div style="margin-right: 20%;"><a  href="/inicio">Inicio</a></div>
                                        <div style="margin-right: 20%;" @mouseover="handleMouseOverCuatroCampos(1)">Categorias</div>
                                        <div @mouseover="handleMouseOverCuatroCampos(2)">Colores</div>
                                    </div>

                                    <div v-if="showCategories || showColors || showHelp" style="margin-top: 30px;  position: absolute; background-color: white; max-width: 60%; border-radius: 10px; padding: 20px;">
                                        <div  v-if="showCategories">
                                            <ul>
                                                <li v-for="cate in categorias" style="float:left; margin-bottom: 5px; margin-left: 10px; margin-right: 10px; text-align: center">
                                                    <img @click="verProductosCategoria(cate.nombre)" :src="'/fotos/' + cate.path" style="width: 80px;height: 80px;" class="rounded-circle">
                                                    <button  @click="verProductosCategoria(cate.nombre)" class="btn" style="text-align: left; padding-left: 0px; color: black">
                                                        <p>{{cate.nombre}}</p>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div  v-if="showColors">
                                            <ul>
                                                <li v-for="col in colores"  style="float:left; margin-bottom: 5px; margin-left: 10px; margin-right: 10px; text-align: center">
                                                    <button @click="verProductosColores(col.id)" href="" style="float:left; margin-bottom: 5px; margin-left: 10px; margin-right: 10px; text-align: center">
                                                        <div class="rounded-circle" :style="'width: 60px; height: 60px; border: 4px solid black; background-color:' + col.color"></div>
                                                        <p>{{col.nombre}}</p>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                            </div>
                        </div>

                    </div>
                    <div class="md:hidden">
                        <button
                            @click="toggleMenu"
                            class="flex items-center px-3 py-2 rounded text-gray-500 border-gray-500 hover:text-gray-900 hover:border-gray-900 focus:outline-none"
                            style="float: left; margin-right: 6%"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                ></path>
                            </svg>
                        </button>
                        <div style="display: flex">
                            <button onclick="window.location.href='/inicio'" :active="route().current('/inicio')">
                                <img src="/fotos/COLEMARKET.jpg" style="width: 100px; margin-right: 20px;">
                            </button>
                            <div class="flex" v-if="!this.$page.props.user">
                                <div class="flex-shrink-0 flex items-center" style="margin-right: 10px; color: white">
                                    <a :href="route('register')">Registrate</a>
                                </div>
                                <div class="flex-shrink-0 flex items-center" style="margin-right: 10px">
                                    <hr style="border:none; border-left: 3px solid white; height: 30px; width: 1px;">
                                </div>
                                <div class="flex-shrink-0 flex items-center"  style="color: white">
                                    <a :href="route('login')">Ingresá</a>
                                </div>
                            </div>
                            <div v-if="this.$page.props.user">
                                <div style="margin-right: 20px; margin-top: 10px; color: white">
                                    <div>
                                        <a style="display: flex; color: white; text-align: center; font-size: 20px; background-color: #121212; border: none;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg v-if="cantOfertasTotal == 0" style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                            </svg>
                                            <div v-if="cantOfertasTotal > 0" style="margin-right: 10px;" class="ofertas">{{cantOfertasTotal}}</div>

                                            <p>{{$page.props.user.name}}</p>
                                        </a>
                                        <ul style="border: none;"  class="dropdown-menu" aria-labelledby="dropdownMenuLink" >
                                            <li>
                                                <a href="/dashboard" style="width: 150px">
                                                    <DropdownLink as="button" style="text-align: center">
                                                        Productos
                                                    </DropdownLink>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/user/profile" style="width: 150px">
                                                    <DropdownLink as="button" style="text-align: center">
                                                        Cuenta
                                                    </DropdownLink>
                                                </a>
                                            </li>
                                            <li>
                                                <form @submit.prevent="logout" style="width: 150px">
                                                    <DropdownLink as="button" style="text-align: center">
                                                        Log Out
                                                    </DropdownLink>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        <div>

                         </div>

                        </div>

                    </div>
                </div>
                <div
                    style="width: 70%; background-color:  #302D2D"
                    class="fixed inset-0 z-10 transform transition-transform duration-300 ease-in-out"
                    v-if="isMenuOpen"
                >
                    <div @click="toggleMenu" style="float:right; padding: 10px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                        </svg>
                    </div>
                    <div style="margin-top: 80px">
                        <a :href="route('login')"><p style="text-align: center; color: white; font-size: 25px">Ingresá</p></a>
                        <br>
                    </div>
                    <div class='search-form' method='get' target='_top'>
                        <input class='search-text' placeholder='Buscar productos...' style="padding-left: 10px"  v-model="form.buscador"/>
                        <button @click="buscar" class='search-button' type='submit'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#C5C5C5" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </button>
                    </div>
                    <div style="height: 365px; overflow: auto;">
                        <ul style="margin-left: 25px">
                            <li v-for="cate in categorias" style="float:left; margin-bottom: 5px; margin-left: 10px; margin-right: 10px; text-align: center">
                                <img @click="verProductosCategoria(cate.nombre)" :src="'/fotos/' + cate.path" style="width: 45px;height: 45px;" class="rounded-circle">
                                <button  @click="verProductosCategoria(cate.nombre)" class="btn" style="text-align: left; padding-left: 0px; color: white">
                                    <p><b>{{cate.nombre}}</b></p>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <a href="https://wa.me/5491128495155?text=Buenos%20dias!%20Me%20gustaria%20tener%20más%20informacion" class="whatsapp celular" target="_blank">
                    <svg style="margin-left: 14px; margin-top: 12px;" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                    </svg>
                </a>
                 Responsive Navigation Menu -->
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

<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

export default {
    name: "ClienteLayout",
    props:['productos'],
    computed: {

    },
    data()
    {
        return{
            menuAbierto:false,
            form:{
                buscador: ''
            },
            showCategories: false,
            showColors: false,
            showHelp: false,
            resultados: [],
            isMenuOpen: false,
            categorias: [],
            categoriasHijos: [],
            colores: [],
            cantOfertasTotal: 0,
            habilitarModalBuscar: false,
        }
    },

    methods:{
       handleMouseOverCuatroCampos($i){
           if($i == 1){
               this.showCategories = 1;
               this.showColors = 0;
               this.showHelp = 0;

           }
           if($i == 2){
               this.showColors = 1;
               this.showCategories = 0;
               this.showHelp = 0;
           }
           if($i == 3){
               this.showHelp = 1;
               this.showColors = 0;
               this.showCategories = 0;
           }
        },
        handleMouseLeaveCuatroCampos(){
            this.showCategories = 0;
            this.showColors = 0;
            this.showHelp = 0;
        },
        verProductosColores($id){
            this.$inertia.get('/buscarTexto?color=' + $id);
        },
        verProductosCategoria($nombre){
            this.$inertia.get('/buscarTexto?categoria=' + $nombre);
        },
        buscar(){
            this.$inertia.get('/buscarTexto?text=' + this.form.buscador);
        },
        verProductoDetalle($nomCat, $nombre){
            this.$inertia.get('/verProductoDetalle/' + $nomCat + '/' + $nombre);
        },
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen;
        },
        buscarParcial() {
            axios.get('/buscar', {
                params: {
                    text: this.form.buscador,
                },
            })
                .then(response => {
                    this.resultados = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        buscarColores(){
            axios.get('/buscarColores', {
            })
                .then(response => {
                    this.colores = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        buscarCategorias(){
            axios.get('/buscarCategorias', {
            })
                .then(response => {
                    this.categorias = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        buscarCategoriasHijos(){
            axios.get('/buscarCategoriasHijos', {
            })
                .then(response => {
                    this.categoriasHijos = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        buscarCantOfetasTotal(){
            axios.get('/buscarCantOfetasTotal', {
            })
                .then(response => {
                    this.cantOfertasTotal = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },

    },
    created() {
        // Llamamos al método que filtra los productos al crear el componente
        this.buscarCategorias();
        this.buscarCantOfetasTotal();
        this.buscarColores();
        this.buscarCategoriasHijos();

    }
}
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Quicksand:wght@300;400&display=swap');
.container-3{
    width: 300px;
    vertical-align: middle;
    white-space: nowrap;
    position: relative;
}
.tipografia{
    font-family: 'Open Sans';
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

.search-box {
    position: relative;
    width: 60%;
    margin-top: 5px;
}

.search-text {
    color: #C5C5C5;
    font-size: 14px;
    border-width: 0;
    background-color: #555555;
    width: 100%;
    height: 31px;

}

.search-box input[type="text"] {
    width: 90%;
    padding: 5px 0 12px 1em;
    color: #333;
    outline: none;
}

.whatsapp {
    position:fixed;
    width:60px;
    height:60px;
    bottom:40px;
    right:40px;
    background-color:#555555;
    color:#FFF;
    border-radius:50px;
    text-align:center;
    font-size:30px;
    z-index:100;
}

.whatsapp-icon {
    margin-top:13px;
}
.dropdown-toggle::after{
    margin-top: 10px;
}



@media (max-width: 400px) {
    .search-form{
        width: 90%;
        margin-bottom: 25px;
        margin-left: 5%;
        height: 32px;
        border: 1px solid #c5c5c5;
        border-radius: 15px;
        overflow: hidden;
    }

    .logo{
        width: 150px;
        margin-left: 85px;
    }
    .search-button{
        position: absolute;
        right: 20px;
        margin-top: 5px;
    }
}

@media (min-width: 401px) {
    .search-button {
        position: absolute;
        right: 51px;
        height: 32px;
    }
    .search-form{
        margin-left: 15px;
        width: 90%;
        margin-top: 15px;
        height: 32px;
        box-shadow: 0px 1px 4px #444444;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 3px;
        overflow: hidden;
    }
    .logo{
        width: 150px;
    }
}
.transition-transform {
    transition-property: transform;
}


@media (max-width: 500px) {
    #carouselExampleControls{
        margin-top: 63px;
    }
    p.card-text{
        font-size: 15px;
        text-align: left;
    }
    h2.card-text{
        font-size: 20px;
        text-align: left;
    }
    h1.card-text{
        font-size: 25px;
        text-align: left;
    }
    .container2 {
        padding: 5px;
        background-color: white;
        margin: 1%;
        width: 450px;
        float: left;
        border-radius: 5px;
    }
    .colum2 {
        flex-direction: column;
        margin-right: 10px;
        flex: 1;
        text-align: center;
        min-width: 190px;
        padding: 10px;
    }
    .card-deck{
        float: left;
        margin-left: 12px;
        margin-right: 12px;
        margin-top: 10px;
        text-align: center;
    }
    .fotoCategoria{
        width: 75px;
        height: 75px;
    }
    .botones{
        float: left; margin: 2%; width: 45%; background-color: grey; color: white; font-size: 15px;
    }
    .compu{
        display: none;
    }
    .card{
        width: 100%;
        margin-right: 2%;
        margin-bottom: 5%;
    }
    .filtros{
        background-color: #121212;
        margin-top: -1px;
        padding-left: 12%;
        padding-top: 2%;
        padding-bottom: 2%;
        height: 55px;
        top: 80px;
    }
    .botonfiltros{
        width: 140px;
        font-size: 20px;
    }


    .card-img-top{
        height: 300px;
    }


    .colum2 div {
        background-color: #28285b;
        font-size: 1.4rem;
        padding: 5px 0;
        border-bottom: 1px solid white;
    }

    .image2 img {
        max-width: none;
        height: 200px;
        width: 200px;
        display: block;
    }
    .info{
        padding: 10px;
        background-color: #EF7728;
        width: 90%;
        box-shadow: 0px 1px 4px #444444;
        border-radius: 3px;
        margin: 0 auto;
    }
    .celular{
        display: none;
    }
}

@media (min-width: 501px) {
    #carouselExampleControls{
        margin-top: 118px;
    }
    p.card-text{
        font-size: 20px;
        text-align: left;
    }
    h2.card-text{
        font-size: 25px;
        text-align: left;
    }
    h1.card-text{
        font-size: 30px;
        text-align: left;
    }
    .container2 {
        background-color: white;
        width: 300px;
        margin: 1%;
        float: left;
        border-radius: 5px;
    }
    .compu{
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
    }
    .colum2 {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin-right: 10px;
        flex: 1;
        text-align: center;
        min-width: 300px;
    }

    .colum2 div {
        background-color: #28285b;
        font-size: 1.4rem;
        padding: 5px 0;
        border-bottom: 1px solid white;
    }

    .image2{
        max-width: none;
        height: 250px;
        display: flex;
        justify-content: center;

    }
    .card-img-top{
        height: 250px;
        width: 250px;
    }
    .info{
        padding: 10px;
        background-color: #EF7728;
        width: 90%;
        box-shadow: 0px 1px 4px #444444;
        border-radius: 3px;
        margin: 0 auto;
    }
    .infoli{
        font-size: 23px; color: white;
    }
    .cate{
        margin-top: 40px;
        float: left;
        margin-right: 50px;
    }
    .fotoCategoria{
        width:120px;
        height:120px;
    }
    .celu{
        display: none;
    }
    .botones{
        float: left; margin-right: 3%; width: 20%; background-color: grey; color: white; font-size: 30px;
    }
    .card{
        width: 45%;
        margin-right: 2%;
        float: left;
        margin-bottom: 2%;
    }
    .filtros{
        background-color: #121212;
        margin-top: -1px;
        padding-bottom: 1%;
        height: 40px;
        top: 79px;
    }
    .botonfiltros{
        width: 200px;
        font-size: 20px;
    }
}
.ofertas{
    background-color: red;
    display: inline-table;
    width: 25px;
    height: 25px;
    text-align: center;
    border-radius: 10px;
}
</style>
