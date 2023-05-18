<template>
    <cliente-layout>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div v-if="fotosBanner && fotosBanner[num] " class="carousel-item active">
                    <a :href="'https://' + fotosBanner[num].url" target="_blank">
                         <img v-if="fotosBanner[num]" class="d-block w-100"  :src="'/fotos/' + fotosBanner[num].path" style="width: 100%" alt="First slide">
                    </a>
                </div>
            </div>
            <a class="carousel-control-prev" @click="moverIzq()" role="button" data-slide="prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                </svg>
            </a>
            <a class="carousel-control-next" @click="moverDer()" role="button" data-slide="next">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                </svg>
            </a>
        </div>
        <div  v-if="ofertados.length > 0"  class="overflow-hidden sm:rounded-lg" style="margin: 3%; margin-top: 5%; padding: 20px" >
            <h1 style="font-size: 30px; text-align: left; color: #17428A;">
                Los más solicitados
            </h1>
            <hr style="width: 95%; border: 2px solid #EF7728; margin-bottom: 20px">
            <div :style="ofertados.length >= 4  ? 'display: flex; justify-content: space-evenly;' : 'display: flex;'">
                <div v-for="(pro, index) in primerosOfertas"  @click="verProductoDetalle(pro.nomCat, pro.nombre)" class="container2"  @mouseover="handleMouseOverOfertados(index)" @mouseleave="handleMouseLeaveOfertados(index)" :style="primerosOfertas[index].zoomed  ? 'transform: scale(1.1); margin-bottom: 10px' : 'margin-bottom: 10px'">
                    <div class="image2">
                        <img :src="'/fotos/' + pro.path">
                    </div>
                    <hr>
                    <div class="colum2">
                        <h1 class="card-text" >$ {{pro.precio}}</h1>
                        <h2 class="card-text" ><b> {{pro.nombre}}</b> </h2>
                        <p class="card-text"><b>Unidades: {{pro.cantidad}} </b> </p>
                        <p class="card-text">Precio por unidad: ${{(pro.precio / pro.cantidad).toFixed(0)}}</p>
                        <p class="card-text" style="max-width: 175px">Estado: {{pro.nomEstado}}</p>
                        <br>
                        <p class="card-text" style="color: red;" v-if="pro.cantOfertas > 1"><b>YA HAY {{pro.cantOfertas}} OFERTAS</b></p>
                        <p class="card-text" style="color: red;" v-if="pro.cantOfertas == 1"><b>YA HAY {{pro.cantOfertas}} OFERTA</b></p>
                        <p class="card-text" v-if="pro.cantOfertas == 0"><b>NO HAY OFERTAS</b></p>
                    </div>

                </div>
                <a v-if="ofertados.length >= 4" @click="moverIzqOfertados()" role="button" data-slide="prev" style="position:absolute; left: 0; margin-top: 220px; margin-left: 15px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                    </svg>
                </a>
                <a v-if="ofertados.length >= 4" @click="moverDerOfertados()" role="button" data-slide="next" style="position:absolute; right: 0; margin-top: 220px; margin-right: 15px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="overflow-hidden sm:rounded-lg" style="margin: 3%; padding: 20px">
            <div class="card-deck cate" v-for="(cat, index) in cateTotales" style="text-align: center">
                <img :style="cateTotales[index].zoomed  ? 'transform: scale(1.2); border: 3px solid white;' : ''"
                    @click="verProductosCategoria(cat.nombre, cat.hijos)" :src="'/fotos/' + cat.path" class="fotoCategoria rounded-circle" @mouseover="handleMouseOver(index)" @mouseleave="handleMouseLeave(index)">
                <button  @click="verProductosCategoria(cat.nombre, cat.hijos)" class="btn" style="text-align: left; padding-left: 0px">
                    <p><b>{{cat.nombre}}</b></p>
                </button>
            </div>
        </div>
        <div class="overflow-hidden sm:rounded-lg" style="margin: 3%; padding: 20px">
            <div class="container2" style="margin-bottom: 10px; width: 96%; margin-left: 2%; margin-right: 2%">
                <div>
                    <h1 style="text-align: center; font-size: 60px; padding: 20px"><b>Bienvenido a La Cole Market</b></h1>
                    <p style="text-align: center; font-size: 20px; padding: 10px">El shuk virtual de la comunidad donde vas a poder comprar, vender o alquilar productos y servicios a toda la comundidad</p>
                </div>
                <hr style="width: 90%; margin-left: 5%; margin-right: 5%; border: 2px solid #EF7728; margin-bottom: 10px; margin-top: 10px">

                <div style="display: flex; justify-content: space-evenly; padding: 20px">
                    <div class="item">
                        <svg style="float: left; margin-right: 20px" xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                        </svg>
                        <span  style="text-align: center; font-size: 30px">+500 Usuarios</span>
                    </div>
                    <div class="item">
                        <svg style="float: left; margin-right: 20px"  xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                        </svg>
                        <span  style="text-align: center; font-size: 30px">+1500 Productos</span>
                    </div>
                    <div class="item">
                        <svg style="float: left; margin-right: 20px"  xmlns="http://www.w3.org/2000/svg" width="60" height="60"  fill="currentColor" class="bi bi-ui-radios-grid" viewBox="0 0 16 16">
                            <path d="M3.5 15a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm9-9a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 9a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zM16 3.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0zm-9 9a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0zm5.5 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zm-9-11a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 2a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                        </svg>
                        <span  style="text-align: center; font-size: 30px">+30 Categorias</span>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-evenly; padding: 20px">
                    <button  @mouseover="handleMouseOverCuatroCampos(0)" @mouseleave="handleMouseLeaveCuatroCampos(0)" :style="cuatroCampos[0].zoomed   ? 'transform: scale(1.2);' : ''" class="item">
                        <svg style="float: left; margin-right: 20px"  xmlns="http://www.w3.org/2000/svg" width="60" height="60"  fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
                        </svg>
                        <span  style="text-align: center">Publica Productos</span>
                    </button>
                    <p style="font-size: 60px">|</p>
                    <button @mouseover="handleMouseOverCuatroCampos(1)" @mouseleave="handleMouseLeaveCuatroCampos(1)" :style="cuatroCampos[1].zoomed   ? 'transform: scale(1.2);' : ''" class="item" onclick="window.location.href='/register'">
                        <svg style="float: left; margin-right: 20px"  xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                        </svg>
                        <span  style="text-align: center">Unite a la comunidad <br> Crea tu cuenta</span>
                    </button>
                    <p style="font-size: 60px">|</p>
                    <button @mouseover="handleMouseOverCuatroCampos(2)" @mouseleave="handleMouseLeaveCuatroCampos(2)" :style="cuatroCampos[2].zoomed  ? 'transform: scale(1.2);' : ''" class="item"  onclick="window.location.href='/buscar?text='">
                        <svg  style="float: left; margin-right: 20px"  xmlns="http://www.w3.org/2000/svg" width="60" height="60"  fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"/>
                        </svg>
                        <span  style="text-align: center">Contamos con productos <br> de calidad</span>
                    </button>
                    <p style="font-size: 60px">|</p>
                    <button @mouseover="handleMouseOverCuatroCampos(3)" @mouseleave="handleMouseLeaveCuatroCampos(3)" :style="cuatroCampos[3].zoomed   ? 'transform: scale(1.2);' : ''" class="item" onclick="window.location.href='/enviarConsulta'">
                        <svg style="float: left; margin-right: 20px" xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-stars" viewBox="0 0 16 16">
                            <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828l.645-1.937zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.734 1.734 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.734 1.734 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.734 1.734 0 0 0 3.407 2.31l.387-1.162zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L10.863.1z"/>
                        </svg>
                        <span style="text-align: center">Publicita tu marca, servicio <br>
                            o emprendimiento</span>
                    </button>
                </div>

            </div>

        </div>

        <!-- Tabs navs -->
        <div  v-if="novedades.length > 0"  class="overflow-hidden sm:rounded-lg" style="margin: 3%; padding: 20px">
            <h1 style="font-size: 30px; text-align: left; color: #17428A;">
                Los más recientes
            </h1>
            <hr style="width: 95%; border: 2px solid #EF7728; margin-bottom: 20px">
            <div :style="novedades.length >= 4  ? 'display: flex; justify-content: space-evenly;' : 'display: flex;'">
                <div @click="verProductoDetalle(pro.nomCat, pro.nombre)" class="container2" @mouseover="handleMouseOverNovedades(index)" @mouseleave="handleMouseLeaveNovedades(index)" v-for="(pro, index) in primerosNovedades" :style="primerosNovedades[index].zoomed  ? 'transform: scale(1.1); margin-bottom: 10px' : 'margin-bottom: 10px'">
                    <div class="image2">
                        <img :src="'/fotos/' + pro.path">
                    </div>
                    <hr>
                    <div class="colum2">
                        <h1 class="card-text" >$ {{pro.precio}}</h1>
                        <h2 class="card-text" ><b> {{pro.nombre}}</b> </h2>
                        <p class="card-text"><b>Unidades: {{pro.cantidad}} </b> </p>
                        <p class="card-text">Precio por unidad: ${{(pro.precio / pro.cantidad).toFixed(0)}}</p>
                        <p class="card-text">Estado: {{pro.nomEstado}}</p>
                        <br>
                        <p class="card-text" style="color: red;" v-if="pro.cantOfertas > 1"><b>YA HAY {{pro.cantOfertas}} OFERTAS</b></p>
                        <p class="card-text" style="color: red;" v-if="pro.cantOfertas == 1"><b>YA HAY {{pro.cantOfertas}} OFERTA</b></p>
                        <p class="card-text" v-if="pro.cantOfertas == 0"><b>NO HAY OFERTAS</b></p>
                    </div>

                </div>
                <a v-if="novedades.length >= 4" @click="moverIzqNovedades()" role="button" data-slide="prev" style="position:absolute; left: 0; margin-top: 220px; margin-left: 15px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                    </svg>
                </a>
                <a v-if="novedades.length >= 4" @click="moverDerNovedades()" role="button" data-slide="next" style="position:absolute; right: 0; margin-top: 220px; margin-right: 15px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                    </svg>
                </a>
            </div>
        </div>
        <!-- Footer -->
        <footer style="background-color: #EF7728; margin-top: 4%;" class="text-center text-white">
            <!-- Grid container -->
            <div class="container p-3">
                <!-- Section: Links -->
                <section class="">
                    <!--Grid row-->
                    <div class="row" style="margin-bottom: 1%">
                        <div class="col-lg-3 col-md-6 mb-3 mb-md-0">
                            <h1 style="font-size: 20px; color: black"><b>Metodos de Pago</b></h1>
                            <br>
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <p class="text-white">Transferencia Bancaria</p>
                                </li>
                                <li>
                                    <p class="text-white">Mercado Pago</p>
                                </li>
                                <li>
                                    <p class="text-white">Efectivo</p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-3 mb-md-0">
                            <h1 style="font-size: 20px; color: black"><b>Medios de envio</b></h1>
                            <br>
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <p class="text-white">Correo Argentino</p>
                                </li>
                                <li>
                                    <p class="text-white">Andreani</p>
                                </li>
                                <li>
                                    <p class="text-white">Expresos</p>
                                </li>
                                <li>
                                    <p class="text-white">A Convenir</p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3 mb-md-0">
                            <h1 style="font-size: 20px; color: black"><b>Contacto</b></h1>
                            <br>
                            <ul class="list-unstyled mb-0">
                                <li style="margin-top: 5%;display: flex;justify-content: space-evenly;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                    </svg>
                                    <a href="https://www.instaram.com/wop.ok/">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                        </svg>
                                    </a>
                                    <a href="https://wa.me/5491128495155?text=Buenos%20dias!%20Me%20gustaria%20tener%20más%20informacion" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                        </svg>
                                    </a>
                                    <a href="mailto:admin@wop.com.ar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                            <a href="/enviarConsulta">
                                <div style="background-color: #17428A; color: white; padding: 15px 30px 15px 30px; border-radius: 15px; width: 80%; margin-left: 5%; margin-top: 20px">
                                    <h1 style="font-size: 20px;">Recibí atención personalizada ¡Dejanos tu mensaje!</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
            <div style="padding: 8px; background-color: black">
                © Copyright 2023 W.O.P - 1128495155
            </div>
            <!-- Grid container -->
            <!-- Copyright
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © 2020 Copyright:
                <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
            </div>
           Copyright -->
        </footer>
        <!-- Footer -->
    </cliente-layout>
</template>


<script>
import ClienteLayout from '@/Layouts/ClienteLayout.vue'
import { Carousel, Slide } from 'vue-carousel';

export default {
  name: "Index",
  props: ['novedades', 'categorias', 'ofertados', 'fotosBanner','cateTotales'],
  components:{
      ClienteLayout,
      Carousel,
      Slide
  },
  data()
  {
      return{
          hola:'',
          num: 0,
          minNove: 0,
          minOfe: 0,
          primerosNovedades: [],
          primerosOfertas: [],
          cuatroCampos: [
              {
                  zoomed: 0,

              },
              {
                  zoomed: 0,
              },
              {
                  zoomed: 0,

              },
              {
                  zoomed: 0,
              }
              ]
      }
  },
    computed: {

    },
  methods:
      {
          handleMouseOverCuatroCampos($i){
              this.cuatroCampos[$i].zoomed = 1;
          },
          handleMouseLeaveCuatroCampos($i) {
              this.cuatroCampos[$i].zoomed = 0;
          },
          handleMouseOverOfertados($i) {
              this.primerosOfertas[$i].zoomed = true;
          },
          handleMouseLeaveOfertados($i) {
              this.primerosOfertas[$i].zoomed = false;
          },
          handleMouseOverNovedades($i) {
              this.primerosNovedades[$i].zoomed = true;
          },
          handleMouseLeaveNovedades($i) {
              this.primerosNovedades[$i].zoomed = false;
          },
          handleMouseOver($i) {
              this.cateTotales[$i].zoomed = true;
          },
          handleMouseLeave($i) {
              this.cateTotales[$i].zoomed = false;
          },
          moverIzq(){
                if (this.num == 0){
                    this.num = this.fotosBanner.length - 1;
                }
                else{
                    this.num = this.num - 1;
                }
          },
          moverDer(){
              this.num =  (this.num+1) % this.fotosBanner.length;
          },
          verProductoDetalle($nomCat, $nombre){
              this.$inertia.get('/verProductoDetalle/' + $nomCat + '/' + $nombre);
          },
          verProductosNegocio($id){
              this.$inertia.get('/verProductosNegocio/' + $id);
          },
          verProductosCategoria($nombre, $hijo){
              this.$inertia.get('/verProductosCategoria/' + $nombre);
          },
          enviarMail(){
              this.$inertia.post('/enviar-correo');
          },
          minimo($uno, $dos){
              if ($uno > $dos){return $dos;}
              else{return $uno;}
          },
          filterNovedades($num) {
              for (let i = 0; i < this.minimo(this.novedades.length, 4); i++) {
                  let param = (i + $num);
                  if (param >= this.novedades.length){
                      param = param - this.novedades.length;
                  }
                  this.primerosNovedades[i] = this.novedades[param];
              }
          },
          filterOfertas($num) {
              for (let i = 0; i < this.minimo(this.ofertados.length, 4); i++) {
                  let param = (i + $num);
                  if (param >= this.ofertados.length){
                      param = param - this.ofertados.length;
                  }
                  this.primerosOfertas[i] = this.ofertados[param];

              }
          },
          moverIzqNovedades(){
              if (this.minNove == 0){
                    this.minNove = this.novedades.length - 1;
                }
                else{
                  this.minNove = this.minNove - 1;
              }

              this.filterNovedades(this.minNove);
          },
          moverDerNovedades(){
              this.minNove = this.minNove + 1;
              if (this.minNove >= this.novedades.length){
                  this.minNove = 0;
              }
              this.filterNovedades(this.minNove);
          },

          moverIzqOfertados(){
              if (this.minOfe == 0){
                  this.minOfe = this.ofertados.length - 1;
              }
              else{
                  this.minOfe = this.minOfe - 1;
              }

              this.filterOfertas(this.minOfe);
          },
          moverDerOfertados(){
              this.minOfe = this.minOfe + 1;
              if (this.minOfe >= this.ofertados.length){
                  this.minOfe = 0;
              }
              this.filterOfertas(this.minOfe);
          },
      },
    mounted() {

        this.timer = setInterval(() => {
            this.moverDer();
        }, 5000);
    },
    created() {
        // Llamamos al método que filtra los productos al crear el componente
        this.filterNovedades(0);
        this.filterOfertas(0);

    },
}
</script>


<style scoped>
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
      background-color: white;
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
          background-color: whitesmoke;
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

.toggler{
    /* ALWAYS KEEPING THE TOGGLER OR THE CHECKBOX ON TOP OF EVERYTHING :  */
    z-index:2;
    height: 50px;
    width: 50px;
    position: absolute;
    top: 0;
    left: 0;
    cursor: pointer;
    opacity: 0;
}

.hamburger{
    position: absolute;
    top: 0;
    left: 0;
    height: 68px;
    width: 40px;
    padding: 0.6rem;
    margin-left: 15px;
    /* FOR DISPLAYING EVERY ELEMENT IN THE CENTER : */

    display: flex;
    align-items: center;
    justify-content: center;
}

/* CREATING THE MIDDLE LINE OF THE HAMBURGER : */

.hamburger > div{
    position: relative;
    top: 0;
    left: 0;
    background: white;
    height: 2px;
    width: 100%;
    transition: all  0.4s ease;
}

/* CREATING THE TOP AND BOTTOM LINES :
TOP AT -10PX ABOVE THE MIDDLE ONE AND BOTTOM ONE IS 10PX BELOW THE MIDDLE: */

.hamburger > div::before,
.hamburger > div::after{
    content: '';
    position: absolute;
    top: -10px;
    background: white;
    width: 100%;
    height: 2px;
    right: 0px;
    transition: all  0.4s ease;
}

.hamburger > div::after{
    top: 10px;
}

/* IF THE TOGGLER IS IN ITS CHECKED STATE, THEN SETTING THE BACKGROUND OF THE MIDDLE LAYER TO COMPLETE BLACK AND OPAQUE :  */

.toggler:checked + .hamburger > div{
    background: rgba(0,0,0,0);
}

.toggler:checked + .hamburger > div::before{
    top: 0;
    transform: rotate(45deg);
    background: black;
}

/* AND ROTATING THE TOP AND BOTTOM LINES :  */

.toggler:checked + .hamburger > div::after{
    top: 0;
    transform: rotate(135deg);
    background: black;
}


/* MAIN MENU WITH THE WHITE BACKGROUND AND THE TEXT :  */

.menu{
    background: black;
    width: 0%;
    height: 100vh;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 2;
    /* APPLYING TRANSITION TO THE MENU :  */

    transition: all 0.4s ease;
}

/* IF THE TOGGLER IS CHECKED, THEN INCREASE THE WIDTH OF THE MENU TO 30% , CREATING A SMOOTH EFFECT :  */

.toggler:checked ~ .menu{
    width: 60%;
}


/* STYLING THE LIST :  */

.menu >  div > ul{
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 90px;
    width: 60%;

    /* HIDDEN INITIALLY  :  */

    visibility: hidden;
}

.menu > div > ul > li{
    list-style: none;
    padding: 0.5rem;
}

.menu > div > ul > li > a{
    color: white;
    text-decoration: none;
    font-size: 20px;
    text-align: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* WHEN THE TOGGLER IS CHECKED, CHANGE THE VISIBILITY TO VISIBLE :  */

.toggler:checked ~ .menu > div > ul{
    transition: visibility 0.4s ease;
    transition-delay: 0.1s;
    visibility: visible;
}

.toggler:checked ~ .menu > div > ul > li > a:hover{
    color: orange;
}



























.navbar {
    overflow: hidden;
    background-color: #333;
    font-family: Arial;
}

/* Links inside the navbar */
.navbar a {
    float: left;
    font-size: 16px;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

/* The dropdown container */
.dropdown {
    float: left;
    overflow: hidden;
}

/* Dropdown button */
.dropdown .dropbtn {
    font-size: 16px;
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
    font-family: inherit; /* Important for vertical align on mobile phones */
    margin: 0; /* Important for vertical align on mobile phones */
}

/* Add a red background color to navbar links on hover */
.navbar a:hover, .dropdown:hover .dropbtn {
    background-color: red;
}

/* Dropdown content (hidden by default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

/* Add a grey background color to dropdown links on hover */
.dropdown-content a:hover {
    background-color: #ddd;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
    display: block;
}
.item{
    display: flex;    align-items: center;
}


.zoomable {
    transition: transform 0.3s;
}

.zoomable.zoomed {
    transform: scale(1.1);
}
</style>
