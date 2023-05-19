<template>
        <cliente-layout>
            <div class="altura" style="background-color: #121212;"></div>
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img v-if="fotosBanner[num]" class="d-block w-100"  :src="'/fotos/' + fotosBanner[num].path" style="width: 100%" alt="First slide">
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

            <div>
                <div class="row compu" style="width: 90%; margin: 5%; padding: 1%; padding-top: 3%; padding-bottom: 3%; background-color: white">
                   <div class="col-2" style="padding-left: 4%">
                        <img v-for="(foto, key) in producto.path" :src="'/fotos/' + foto.path" @click="cambiarFoto(key)" style="height:100px; width: 100px; margin-right: 5%; margin-bottom: 5%; border-radius: 10px; border: 2px solid #17428A;">
                    </div>
                    <div class="col-5" style= "">
                        <img :src="'/fotos/' + fotoPrincipal" style="width: 100%; max-height: 700px">
                    </div>
                    <div class="col-5" style="padding-left: 5%">
                        <div style="margin-bottom: 7%">
                            <h1 style="font-size: 50px;"><b> {{producto.nombre}}</b> </h1>
                            <p class="card-text" style="font-size: 25px;"><b>Unidades: {{producto.cantidad}} </b></p>
                            <p class="card-text" style="font-size: 25px;">Precio por unidad: ${{(producto.precio_max / producto.cantidad).toFixed(0)}}</p>
                            <p class="card-text" style="font-size: 25px;">Faltan {{producto.fechaLanzamiento}}</p>
                            <p class="card-text" style="color: red;" v-if="producto.cantOfertas > 1"><b>YA HAY {{producto.cantOfertas}} OFERTAS</b></p>
                            <p class="card-text" style="color: red;" v-if="producto.cantOfertas == 1"><b>YA HAY {{producto.cantOfertas}} OFERTA</b></p>
                            <p class="card-text" v-if="producto.cantOfertas == 0"><b>NO HAY OFERTAS</b></p>
                            <h1 style="font-size: 50px;"><b>${{producto.precio_max}}</b></h1>
                        </div>
                        <div style="margin-bottom: 15%; display: flex;justify-content: space-evenly;">
                            <button @click="comprar()" :style="'border-radius: 50%; width: 100px; height: 100px; background-color: #' + colorComprar + ';'">
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-top: 20px" width="60" height="60" fill="white" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                </svg>
                                <h1 style="font-size: 20px; text-align: center; margin-bottom: 3%; margin-top: 30px"> COMPRAR </h1>
                            </button>
                            <button @click="ofertar()" :style="'border-radius: 50%; width: 100px; height: 100px; background-color: #' + colorOferta  + ';'">
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-top: 20px" width="60" height="60" fill="white" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"/>
                                </svg>
                                <h1 style="font-size: 20px; text-align: center; margin-bottom: 3%; margin-top: 30px"> OFERTAR </h1>
                            </button>
                        </div>
                        <div  v-if="btnOfertar || btnComprar" style="margin-top: 25px">
                            <input style="width: 90%; margin-right: 2%; margin-left: 2%; margin-bottom: 2%; border: 2px solid #C0C0C0;" v-validate="email" data-rules="required|email"    placeholder="Email" class="form-control" v-model="form.mail" >
                            <input style="width: 44%; margin-right: 2%; margin-left: 2%; float: left; border: 2px solid #C0C0C0;"    placeholder="Nombre" class="form-control" v-model="form.nombre" >
                            <input style="width: 44%; margin-right: 2%; margin-left: 0%; margin-bottom: 2%; float: left; border: 2px solid #C0C0C0;"   placeholder="Apellido" class="form-control" v-model="form.apellido" >
                            <input style="width: 90%; margin-right: 2%; margin-left: 2%; margin-bottom: 2%; border: 2px solid #C0C0C0;"  placeholder="Celular" class="form-control" v-model="form.celular" >
                            <select style="width: 90%; margin-right: 2%; margin-left: 2%; margin-bottom: 2%; border: 2px solid #C0C0C0;" class="form-control" v-model="form.provincia_id">
                                <option value="" disabled selected>Seleccione su Provincia...</option>
                                <option v-for="pro in provincias" :value="pro.id">{{pro.nombre}} - ${{pro.precio}} </option>
                            </select>
                        </div>
                        <div v-if="btnOfertar">
                            <input style="width: 44%; margin-right: 2%; margin-left: 2%; float: left; background-color: #A6A6A6; border: 2px solid #C0C0C0;"    placeholder="Precio" class="form-control" v-model="form.precio" >
                            <input style="width: 44%; margin-right: 2%; margin-left: 0%; margin-bottom: 2%; float: left; background-color: #A6A6A6; border: 2px solid #C0C0C0;"   placeholder="Cantidad" class="form-control" v-model="form.cant" >
                            <p v-if="producto.cant_minimo >= form.cant" style="color: black; text-align: center; margin-top: 10px">Cantidad minima requerida: {{producto.cant_minimo}}</p>
                            <p v-if="producto.cantidad < form.cant" style="color: black; text-align: center; margin-top: 10px">Cantidad maxima superada</p>
                            <p v-if=" (form.precio > 0) && (form.cant > 0 && producto.cant_minimo < form.cant && producto.cantidad >= form.cant)" style="color: black; text-align: center; margin-top: 10px">Oferta por unidad: ${{ (form.precio / form.cant).toFixed()}}</p>
                            <button v-if="valorOfe == 0" class="btn" style="width: 90%; margin-top: 2%; margin-left: 2%; background-color: #FF7341; color: white" @click="guardarOferta">Enviar Oferta!</button>
                            <button v-if="valorOfe == 1" class="btn" style="width: 90%; margin-top: 2%; margin-left: 2%; background-color: #FFBCA4; color: black;" @click="nuevaOferta">Nueva Oferta</button>
                            <p v-if="valorOfe == 1" style="color: black; text-align: center; margin-top: 10px">¡Oferta enviada con exito!</p>
                        </div>
                        <div v-if="btnComprar">
                            <button v-if="valorCom == 0" class="btn" style="width: 90%; margin-top: 2%; margin-left: 2%; background-color: #FFBCA4; color: white" @click="guardarCompra">Comprar Producto!</button>
                            <button v-if="valorCom == 1" class="btn" style="width: 90%; margin-top: 2%; margin-left: 2%; background-color: #FF7341; color: black;" @click="confirmarCompra">Confirmar Compra</button>
                            <p v-if="realizoCompra == 1" style="color: black; text-align: center; margin-top: 10px">¡Compra realizada con exito!</p>
                        </div>
                    </div>
                </div>
                <div class="row celu" style="width: 90%; margin: 5%; padding: 1%; padding-top: 3%; padding-bottom: 3%; background-color: white">
                    <div style=" margin-top: 5%; display: flex; overflow: auto">
                        <img @click="cambiarFoto(key)" v-for="(foto, key) in producto.path" :src="'/fotos/' + foto.path" style="height:125px; min-width: 125px; margin-right: 5%; margin-bottom: 5%; border-radius: 10px; border: 2px solid #17428A; float: left">
                    </div>
                    <div style="width: 100%; margin: 3% 0%;">
                        <img :src="'/fotos/' + fotoPrincipal" style="width: 90%; margin: 5%; ">
                    </div>
                    <div style="padding-left: 5%">
                        <div style="margin-bottom: 7%; text-align: center">
                            <h1 style="font-size: 50px;"><b> {{producto.nombre}}</b> </h1>
                            <p class="card-text" style="font-size: 25px; text-align: center"><b>Unidades: {{producto.cantidad}} </b> </p>
                            <p class="card-text" style="font-size: 25px; text-align: center ">Unitario: ${{(producto.precio_max / producto.cantidad).toFixed(0)}}</p>
                            <p class="card-text" style="font-size: 25px; text-align: center">Faltan {{producto.fechaLanzamiento}}</p>
                            <h1 style="font-size: 50px; margin-top: 30px; margin-bottom: 30px"><b>${{producto.precio_max}}</b></h1>
                        </div>
                        <div style="margin-bottom: 15%; display: flex;justify-content: space-evenly;">
                            <button @click="comprar()" :style="'border-radius: 50%; width: 100px; height: 100px; background-color: #' + colorComprar + ';'">
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-top: 20px" width="60" height="60" fill="white" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                </svg>
                                <h1 style="font-size: 20px; text-align: center; margin-bottom: 3%; margin-top: 30px"> COMPRAR </h1>
                            </button>
                            <button @click="ofertar()" :style="'border-radius: 50%; width: 100px; height: 100px; background-color: #' + colorOferta  + ';'">
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-top: 20px" width="60" height="60" fill="white" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"/>
                                </svg>
                                <h1 style="font-size: 20px; text-align: center; margin-bottom: 3%; margin-top: 30px"> OFERTAR </h1>
                            </button>
                        </div>
                        <div  v-if="btnOfertar || btnComprar" style="margin-top: 25px">
                            <input style="width: 90%; margin-right: 2%; margin-left: 2%; margin-bottom: 2%; border: 2px solid #C0C0C0;" v-validate="email" data-rules="required|email"    placeholder="Email" class="form-control" v-model="form.mail" >
                            <input style="width: 44%; margin-right: 2%; margin-left: 2%; float: left; border: 2px solid #C0C0C0;"    placeholder="Nombre" class="form-control" v-model="form.nombre" >
                            <input style="width: 44%; margin-right: 2%; margin-left: 0%; margin-bottom: 2%; float: left; border: 2px solid #C0C0C0;"   placeholder="Apellido" class="form-control" v-model="form.apellido" >
                            <input style="width: 90%; margin-right: 2%; margin-left: 2%; margin-bottom: 2%; border: 2px solid #C0C0C0;"  placeholder="Celular" class="form-control" v-model="form.celular" >
                            <select style="width: 90%; margin-right: 2%; margin-left: 2%; margin-bottom: 2%; border: 2px solid #C0C0C0;" class="form-control" v-model="form.provincia_id">
                                <option value="" disabled selected>Seleccione su Provincia...</option>
                                <option v-for="pro in provincias" :value="pro.id">{{pro.nombre}} - ${{pro.precio}} </option>
                            </select>
                        </div>
                        <div v-if="btnOfertar">
                            <input style="width: 44%; margin-right: 2%; margin-left: 2%; float: left; background-color: #A6A6A6; border: 2px solid #C0C0C0;"    placeholder="Precio" class="form-control" v-model="form.precio" >
                            <input style="width: 44%; margin-right: 2%; margin-left: 0%; margin-bottom: 2%; float: left; background-color: #A6A6A6; border: 2px solid #C0C0C0;"   placeholder="Cantidad" class="form-control" v-model="form.cant" >
                            <p v-if="(form.precio > 0) && (form.cant > 0)" style="color: black; text-align: center; margin-top: 10px">Oferta por unidad: {{ (form.precio / form.cant).toFixed()}}</p>
                            <button v-if="valorOfe == 0" class="btn" style="width: 90%; margin-top: 2%; margin-left: 2%; background-color: #FF7341; color: white" @click="guardarOferta">Enviar Oferta!</button>
                            <button v-if="valorOfe == 1" class="btn" style="width: 90%; margin-top: 2%; margin-left: 2%; background-color: #FFBCA4; color: black;" @click="nuevaOferta">Nueva Oferta</button>
                            <p v-if="valorOfe == 1" style="color: black; text-align: center; margin-top: 10px">¡Oferta enviada con exito!</p>
                        </div>
                        <div v-if="btnComprar">
                            <button v-if="valorCom == 0" class="btn" style="width: 90%; margin-top: 2%; margin-left: 2%; background-color: #FFBCA4; color: white" @click="guardarCompra">Comprar Producto!</button>
                            <button v-if="valorCom == 1" class="btn" style="width: 90%; margin-top: 2%; margin-left: 2%; background-color: #FF7341; color: black;" @click="confirmarCompra">Confirmar Compra</button>
                            <p v-if="realizoCompra == 1" style="color: black; text-align: center; margin-top: 10px">¡Compra realizada con exito!</p>
                        </div>
                    </div>
                </div>

                <div class="row" style=" margin: 5%; ">
                    <h1 style="font-size: 30px; text-align: left;">
                        DESCRIPCIÓN
                    </h1>
                    <hr style="width: 95%; border: 2px solid #EF7728; margin-bottom: 20px">
                    <p style="font-size: 25px;"><b>Estado: {{producto.nomEstado}}</b></p>

                    <p style="font-size: 15px;">{{producto.descripcion}}</p>

                    <table v-if="producto.ofertas.length != 0">
                        <thead>
                        <tr>
                            <th>Oferta</th>
                            <th>Cantidad</th>
                            <th>Precio Total</th>
                            <th>Precio por unidad</th>
                            <th>Tiempo restante</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(ofe, index) in producto.ofertas" :key="index">
                            <td>{{index + 1}}</td>
                            <td>{{ ofe.cantidad }}</td>
                            <td>${{ ofe.precio }}</td>
                            <td>${{(ofe.precio / ofe.cantidad).toFixed(0)}}</td>
                            <td>{{ofe.diferencia}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <h2 v-if="producto.ofertas.length == 0" style="font-size: 25px; margin-top: 20px">Aun no hay ofertas.</h2>

                </div>
                <div class="row" style=" margin: 5%;" v-if="otros.length > 0">
                    <h1 style="font-size: 30px; text-align: left;">
                        OTROS
                    </h1>
                    <hr style="width: 95%; border: 2px solid #EF7728; margin-bottom: 20px">
                    <div :style="otros.length >= 4  ? 'display: flex;overflow: auto;justify-content: space-evenly;' : 'display: flex;overflow: auto;'">
                        <div @click="verProductoDetalle(pro.nomCat, pro.nombre)" class="container2" v-for="pro in primerosOtros" style="margin-bottom: 10px">
                            <div class="image2">
                                <img :src="'/fotos/' + pro.path">
                            </div>
                            <hr>
                            <div class="colum2">
                                <h1 class="card-text" >$ {{pro.precio_max}}</h1>
                                <h2 class="card-text" ><b> {{pro.nombre}}</b> </h2>
                                <p class="card-text"><b>Unidades: {{pro.cantidad}} </b> </p>
                                <p class="card-text">Precio por unidad: ${{(pro.precio_max / pro.cantidad).toFixed(0)}}</p>
                                <p class="card-text">Faltan {{pro.fechaLanzamiento}}</p>
                                <p class="card-text">Estado: {{pro.nomEstado}}</p>
                                <br>
                                <p class="card-text" style="color: red;" v-if="pro.cantOfertas > 1"><b>YA HAY {{pro.cantOfertas}} OFERTAS</b></p>
                                <p class="card-text" style="color: red;" v-if="pro.cantOfertas == 1"><b>YA HAY {{pro.cantOfertas}} OFERTA</b></p>
                                <p class="card-text" v-if="pro.cantOfertas == 0"><b>NO HAY OFERTAS</b></p>
                            </div>

                        </div>
                        <a v-if="otros.length >= 4" @click="moverIzqOtros()" role="button" data-slide="prev" style="position:absolute; left: 0; margin-top: 220px; margin-left: 15px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                            </svg>
                        </a>
                        <a v-if="otros.length >= 4"  @click="moverDerOtros()" role="button" data-slide="next" style="position:absolute; right: 0; margin-top: 220px; margin-right: 15px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                            </svg>
                        </a>

                    </div>

                </div>
            </div>
            <Footer></Footer>
            <div class="modal  fade"  id="modalImagenesEnPrenda" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg "  style="height: 700px;">
                    <div class="modal-content Blanco">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
                        </div>
                        <div class="modal-body" >

                        </div>
                    </div>
                </div>
            </div>
        </cliente-layout>
</template>
<script>
import ClienteLayout from '@/Layouts/ClienteLayout.vue'
import Footer from '@/Layouts/Footer.vue'

export default {
    name: "verProducto",
    props: ['producto', 'categorias','otros','fotosBanner'],
    components: {
        ClienteLayout,
        Footer
    },
    data()
    {
        return{
            mitad: this.producto.precio_max/2,
            mitadCant: this.producto.cantidad/2,
            hola:'',
            rango: 0,
            valorOfe: 0,
            valorCom: 0,
            precioUnidad: 0,
            btnComprar: 0,
            btnOfertar: 0,
            realizoCompra: 0,
            colorComprar: 'EBEBEB',
            colorOferta: 'EBEBEB',
            fotoPrincipal: '', //this.producto.path[0].path,
            min: 0,
            num: 0,
            primerosOtros: [],
            form:{
                negocio_id: this.producto.negocio_id,
                provincia_id:'',
                producto_id: this.producto.id,
                mail:'',
                precio:'',
                cant: '',
                nombre:'',
                apellido:'',
                celular: ''
            }
        }
    },
    methods:
        {
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
            nuevaOferta(){
                this.valorOfe = 0;
                this.form.provincia_id = '';
                this.form.mail = '';
                this.form.precio = '';
                this.form.celular = '';
                this.form.apellido = '';
                this.form.nombre = '';
                this.form.cant = '';
            },
            guardarOferta(){
                this.form.producto_id = this.producto.id;
                if (this.form.provincia_id != '' && this.form.mail != '' && this.form.precio != '' && this.form.apellido != '' && this.form.nombre != '' && this.form.cant != '') {
                    if (this.producto.cant_minimo <= this.form.cant && this.producto.cantidad >= this.form.cant) {
                        this.$inertia.post('/guardarOferta', this.form);
                        this.valorOfe = 1;
                    }
                }
            },
            guardarCompra(){
                this.form.producto_id = this.producto.id;
                if (this.form.provincia_id != '' && this.form.mail != '' && this.form.apellido != '' && this.form.nombre != '') {
                    this.valorCom = 1;
                }
            },
            confirmarCompra(){
                if(this.realizoCompra == 0 && this.valorCom && this.form.provincia_id != '' && this.form.mail != '' && this.form.apellido != '' && this.form.nombre != ''){
                    this.form.cant = this.producto.cantidad;
                    this.form.precio = this.producto.precio_max;
                    this.realizoCompra = 1;
                    this.$inertia.post('/comprarProducto', this.form);
                }
            },
            verProductoDetalle($nomCat, $nombre){
                this.$inertia.get('/verProductoDetalle/' + $nomCat + '/' + $nombre);
            },
            cambiarFoto(key){
                this.fotoPrincipal = this.producto.path[key].path;
            },
            formatoFecha(fecha) {
                let fechaObj = new Date(fecha);
                let dia = fechaObj.getDate().toString().padStart(2, '0');
                let mes = (fechaObj.getMonth() + 1).toString().padStart(2, '0');
                let año = fechaObj.getFullYear().toString();
                return `${dia}/${mes}/${año}`;
            },
            comprar()
            {
                this.btnComprar = 1;
                this.btnOfertar = 0;
                this.colorComprar = '17428A';
                this.colorOferta = 'EBEBEB';

            },
            ofertar()
            {
                this.btnComprar = 0;
                this.btnOfertar = 1;
                this.colorComprar = 'EBEBEB';
                this.colorOferta = 'EF7728';
            },
            getFoo() {
                $( "div.foo" ).html();
            },
            minimo($uno, $dos){
                if ($uno > $dos){return $dos;}
                else{return $uno;}
            },
            filterOtros($num) {
                for (let i = 0; i < this.otros.length; i++) {
                    let param = (i + $num);
                    if (param >= this.otros.length){
                        param = param - this.otros.length;
                    }
                    this.primerosOtros[i] = this.otros[param];
                }
            },
            moverIzqOtros(){
                if (this.min == 0){
                    this.min = this.otros.length - 1;
                }
                else{
                    this.min = this.min - 1;
                }

                this.filterOtros(this.min);
            },
            moverDerOtros(){
                this.min = this.min + 1;
                if (this.min >= this.otros.length){
                    this.min = 0;
                }
                this.filterOtros(this.min);
            },
        },

    mounted() {
        if(this.realizoCompra || this.valorOfe)
        {
            this.form.provincia_id = '';
            this.form.mail = '';
            this.form.precio = '';
            this.form.cant = '';
            this.form.nombre = '';
            this.form.apellido = '';
            this.form.celular = '';
        }

        console.log("producto");
        var negocio = JSON.parse(JSON.stringify(this.producto));
        console.log(negocio)
        console.log( this.form.cant );
        setInterval(this.moverDer, 5000); // Change image every 2 seconds
    },
    created() {
        // Llamamos al método que filtra los productos al crear el componente
        this.filterOtros(0);

    },
}
</script>


<style scoped>
@media (max-width: 500px) {
    .celular{
        display: none;
    }
   .altura{
        height: 63px;
    }
    #cambio{
        margin-top: 134px;
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
        background-color: #17428A;
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
}

@media (min-width: 501px) {
    .altura{
        height: 118px;
    }
    #cambio{
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

    .colum2 {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin-right: 10px;
        flex: 1;
        text-align: center;
        min-width: 190px;
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
    .compu{
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
    }
    .celu{
        display: none;
    }
    .botones{
        float: left; margin-right: 3%; width: 20%; background-color: grey; color: white; font-size: 30px;
    }
    .card{
        width: 23%;
        margin-right: 2%;
        float: left;
        margin-bottom: 2%;
    }
    .filtros{
        background-color: #17428A;
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


table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-top: 3%;
}

thead {
    background-color: #f9f9f9;
    font-weight: bold;
}

tbody tr:nth-child(odd) {
    background-color: #f2f2f2;
}

tbody tr:hover {
    background-color: #ddd;
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th:first-child, td:first-child {
    padding-left: 20px;
}
</style>
