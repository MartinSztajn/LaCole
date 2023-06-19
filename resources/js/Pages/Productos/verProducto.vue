<template>
        <cliente-layout>
            <div class="altura" style="background-color: #121212;"></div>
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img v-if="fotosBanner[num]" class="d-block w-100"  :src="'/fotos/' + fotosBanner[num].path" style="width: 100%" alt="First slide">
                    </div>
                </div>
                <a class="carousel-control-prev compu" @click="moverIzq()" role="button" data-slide="prev">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="50" height="50" fill="black" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                        <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z"/>
                    </svg>
                </a>
                <a class="carousel-control-next compu" @click="moverDer()" role="button" data-slide="next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                        <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z"/>
                    </svg>
                </a>
            </div>
            <div>
                <div class="row compu" style="width: 90%; margin-left: 5%; margin-top: 2%; padding: 1%; padding-top: 3%;">
                   <div class="col-4" style="padding-left: 4%; text-align: center">
                       <h1 style="font-size: 50px;"><b> {{producto.nombre}}</b> </h1>
                       <h1 style="font-size: 35px;">Estado {{ producto.nomEstado}}</h1>
                       <br>
                       <h1 style="font-size: 40px; margin-bottom: 10%"><b>${{ producto.precio}}</b></h1>
                       <a href="#interesa" class="rounded-circle" style="background-color: white; width: 125px; height: 125px; display: inline-grid;">
                           <svg style="margin-left: 30px; margin-top: 25px" xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                               <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"/>
                           </svg>
                       </a>

                   </div>
                    <div class="col-5" style= "">
                        <img :src="'/fotos/' + fotoPrincipal" style="width: 100%; max-height: 700px">
                    </div>
                    <div class="col-3" style= "height: 700px; overflow: auto; padding-left: 5%">
                        <img v-for="(foto, key) in producto.path" :src="'/fotos/' + foto.path" @mouseover="cambiarFoto(key)" style="height:100px; width: 100px; margin: 5%; border-radius: 10px; border: 2px solid black; float: left">
                    </div>
                </div>
                <div class="row celu" style="width: 90%; margin: 5%; padding: 1%; padding-top: 3%; padding-bottom: 3%;">
                    <div style="padding-left: 5%; text-align: center">
                            <h1 style="font-size: 50px;"><b> {{producto.nombre}}</b> </h1>
                            <h1 style="font-size: 35px;">Estado {{ producto.nomEstado}}</h1>
                            <br>
                            <h1 style="font-size: 40px; margin-bottom: 10%"><b>${{ producto.precio}}</b></h1>
                    </div>

                    <div style="margin-top: 5%; display: flex; overflow: auto">
                        <img @click="cambiarFoto(key)" v-for="(foto, key) in producto.path" :src="'/fotos/' + foto.path" style="height:75px; min-width: 75px; margin-right: 5%; margin-bottom: 5%; border-radius: 10px; border: 2px solid #17428A;">
                    </div>
                    <div style="width: 100%; margin: 3% 0%;">
                        <img :src="'/fotos/' + fotoPrincipal" style="width: 90%; margin: 5%; ">
                    </div>
                </div>

                <div class="row" style="margin-left: 5%;  margin-right: 5%;">
                    <h1 style="font-size: 30px; text-align: left; margin-bottom: 10px">Colores disponibles:</h1>
                    <div style="display: flex;  margin-bottom: 4%; overflow: auto ">
                        <div  v-for="(col, index) in producto.coloresProducto" style="text-align: center; margin-right: 20px">
                            <div style="margin: 10px; text-align: center;">
                                <div class="rounded-circle" :style="'width: 75px; height: 75px; border: 4px solid black; background-color:' + col.color"></div>
                                <p>{{col.nombre}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-left: 5%;  margin-right: 5%;">
                    <div v-html="producto.descripcion"></div>
                </div>
                <div id="interesa" style="width: 90%; margin-left: 5%; margin-top: 7%; margin-bottom: 7%; ">
                    <h1 style="margin-bottom: 2%;font-size: 25px;  text-align: center;">Ingresa tus datos para que el vendedor se pueda contactar con vos</h1>
                    <input style="width: 90%; margin-right: 5%; margin-left: 5%; margin-bottom: 2%; border: 2px solid #C0C0C0;" v-validate="email" data-rules="required|email"    placeholder="Email" class="form-control" v-model="form.mail" >
                    <input style="width: 44%; margin-right: 1%; margin-left: 5%; margin-bottom: 2%; float: left; border: 2px solid #C0C0C0;"   placeholder="Nombre" class="form-control" v-model="form.nombre" >
                    <input style="width: 44%; margin-right: 5%; margin-left: 1%; margin-bottom: 2%; float: left; border: 2px solid #C0C0C0;"   placeholder="Apellido" class="form-control" v-model="form.apellido" >
                    <input style="width: 90%; margin-right: 5%; margin-left: 5%; margin-bottom: 2%; border: 2px solid #C0C0C0;"  placeholder="Celular" class="form-control" v-model="form.celular" >
                    <div style="text-align: center; margin: 1%">
                        <input type="checkbox" v-model="aceptoCondiciones">
                        Acepto los <a style="text-decoration: underline;" href="/verPolitica">términos y condiciones </a>
                    </div>
                    <button v-if="realizoCompra != 3" class="btn" style="width: 90%; margin-left: 5%; background-color: black; color: white" @click="aceptarCondiciones">Confirmar!</button>
                    <p  style="color: black;text-align: center;margin-top: 10px;display: flex;justify-content: center;">
                        <svg v-if="realizoCompra == 2" style="float: left; margin-right: 10px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                            <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                        </svg>
                        {{mensajeEnviar}}
                    </p>
                </div>

                <div class="row" style="margin: 5%; margin-top: 50px" v-if="otrosVendedor.length > 0">
                    <h1 style="font-size: 30px; text-align: left; margin-bottom: 10px">
                            Otros productos del vendedor
                        </h1>
                    <div class="celuCarrusel" :style="otrosVendedor.length > 5  ? 'display: flex; justify-content: space-evenly;' : 'display: flex;'">
                            <div @click="verProductoDetalle(pro.nomCat, pro.nombre)" class="container2" v-for="(pro, index) in primerosVendedor" :style="primerosVendedor[index].zoomed  ? 'transform: scale(1.1); margin-bottom: 10px' : 'margin-bottom: 10px'"  @mouseover="handleprimerosVendedorMouseOver(index)" @mouseleave="handleprimerosVendedorMouseLeave(index)">
                                <div class="image2">
                                    <img :src="'/fotos/' + pro.path">
                                </div>
                                <hr>
                                <div class="colum2">
                                    <h2 class="card-text"><b> {{pro.nombre}}</b> </h2>
                                    <h2 class="card-text">{{pro.nomEstado}}</h2>
                                    <br>
                                    <h1 class="card-text" >${{pro.precio}}</h1>
                                </div>
                            </div>
                            <a v-if="otrosVendedor.length > 5" @click="moverIzqVendedor()" role="button" data-slide="prev" style="position:absolute; left: 0; margin-top: 150px; margin-left: 15px">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="black" class="bi bi-arrow-left-square-fill flechita" viewBox="0 0 16 16">
                                    <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z"/>
                                </svg>
                            </a>
                            <a v-if="otrosVendedor.length > 5"  @click="moverDerVendedor()" role="button" data-slide="next" style="position:absolute; right: 0; margin-top: 150px; margin-right: 15px">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="black" class="bi bi-arrow-right-square-fill flechita" viewBox="0 0 16 16">
                                    <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z"/>
                                </svg>
                            </a>

                        </div>
                </div>
                <div class="row" style="margin: 5%; margin-top: 50px" v-if="otrosCategoria.length > 0">
                    <h1 style="font-size: 30px; text-align: left; margin-bottom: 10px">
                        Otros productos de la categoria

                    </h1>
                    <div class="celuCarrusel" :style="otrosCategoria.length > 5  ? 'display: flex; justify-content: space-evenly;' : 'display: flex;'">
                        <div @click="verProductoDetalle(pro.nomCat, pro.nombre)" class="container2" v-for="(pro, index) in primerosOtros"  :style="primerosOtros[index].zoomed  ? 'transform: scale(1.1); margin-bottom: 10px' : 'margin-bottom: 10px'"  @mouseover="handleprimerosOtrosMouseOver(index)" @mouseleave="handleprimerosOtrosMouseLeave(index)">
                            <div class="image2">
                                <img :src="'/fotos/' + pro.path">
                            </div>
                            <hr>
                            <div class="colum2">
                                <h2 class="card-text"><b> {{pro.nombre}}</b> </h2>
                                <h2 class="card-text">{{pro.nomEstado}}</h2>
                                <br>
                                <h1 class="card-text" >${{pro.precio}}</h1>
                            </div>

                        </div>
                        <a  v-if="otrosCategoria.length > 5" @click="moverIzqOtros()" role="button" data-slide="prev" style="position:absolute; left: 0; margin-top: 150px; margin-left: 15px">
                            <svg xmlns="http://www.w3.org/2000/svg"  fill="black" class="bi bi-arrow-left-square-fill flechita" viewBox="0 0 16 16">
                                <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z"/>
                            </svg>
                        </a>
                        <a v-if="otrosCategoria.length > 5"  @click="moverDerOtros()" role="button" data-slide="next" style="position:absolute; right: 0; margin-top: 150px; margin-right: 15px">
                            <svg xmlns="http://www.w3.org/2000/svg"  fill="black" class="bi bi-arrow-right-square-fill flechita" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z"/>
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
    props: ['producto', 'categorias','otrosCategoria','otrosVendedor','fotosBanner'],
    components: {
        ClienteLayout,
        Footer
    },
    data()
    {
        return{
            acivado: 0,
            realizoCompra: 0,
            aceptoCondiciones: 0,
            fotoPrincipal: this.producto.path[0].path,
            min: 0,
            minVen: 0,
            num: 0,
            primerosOtros: [],
            primerosVendedor: [],
            mensajeEnviar: '',
            form:{
                producto_id: this.producto.id,
                mail:'',
                nombre:'',
                apellido:'',
                celular: ''
            }
        }
    },
    methods:
        {
            handleprimerosVendedorMouseOver($i) {
                this.primerosVendedor[$i].zoomed = true;
            },
            handleprimerosVendedorMouseLeave($i) {
                this.primerosVendedor[$i].zoomed = false;
            },
            handleprimerosOtrosMouseOver($i) {
                this.primerosOtros[$i].zoomed = true;
            },
            handleprimerosOtrosMouseLeave($i) {
                this.primerosOtros[$i].zoomed = false;
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
            aceptarCondiciones(){
                if (this.aceptoCondiciones == 1) {
                    if (this.form.celular != '' && this.form.mail != '' && this.form.apellido != '' && this.form.nombre != '') {
                        this.mensajeEnviar = '¡Se enviaron los datos con exito!';
                        this.realizoCompra = 3;
                        this.$inertia.post('/comprarProducto', this.form);
                    } else {
                        this.realizoCompra = 2;
                        this.mensajeEnviar = 'Debe ingresar:';
                        if (this.form.celular == '') {
                            this.mensajeEnviar = this.mensajeEnviar + ' celular,';
                        }
                        if (this.form.mail == '') {
                            this.mensajeEnviar = this.mensajeEnviar + ' mail,';
                        }
                        if (this.form.nombre == '') {
                            this.mensajeEnviar = this.mensajeEnviar + ' nombre,';
                        }
                        if (this.form.apellido == '') {
                            this.mensajeEnviar = this.mensajeEnviar + ' apellido,';
                        }
                        this.mensajeEnviar = this.mensajeEnviar.slice(0, -1);
                    }
                }
                else {
                    this.realizoCompra = 2;
                    this.mensajeEnviar = 'Debes aceptar las condiciones';
                }

            },
            confirmarCompra(){

            },
            verProductoDetalle($nomCat, $nombre){
                this.$inertia.get('/verProductoDetalle/' + $nomCat + '/' + $nombre);
            },
            cambiarFoto(key){
                this.fotoPrincipal = this.producto.path[key].path;
            },
            minimo($uno, $dos){
                if ($uno > $dos){return $dos;}
                else{return $uno;}
            },
            filterOtros($num) {
                for (let i = 0; i < this.minimo(this.otrosCategoria.length,5); i++) {
                    let param = (i + $num);
                    if (param >= this.otrosCategoria.length){
                        param = param - this.otrosCategoria.length;
                    }
                    this.primerosOtros[i] = this.otrosCategoria[param];
                }
            },
            filterOtrosVendedor($num) {
                for (let i = 0; i < this.minimo(this.otrosVendedor.length, 5); i++) {
                    let param = (i + $num);
                    if (param >= this.otrosVendedor.length){
                        param = param - this.otrosVendedor.length;
                    }
                    this.primerosVendedor[i] = this.otrosVendedor[param];
                }
            },

            moverIzqOtros(){
                if (this.min == 0){
                    this.min = this.otrosCategoria.length - 1;
                }
                else{
                    this.min = this.min - 1;
                }

                this.filterOtros(this.min);
            },
            moverDerOtros(){
                this.min = this.min + 1;
                if (this.min >= this.otrosCategoria.length){
                    this.min = 0;
                }
                this.filterOtros(this.min);
            },
            moverIzqVendedor(){
                if (this.minVen == 0){
                    this.minVen = this.otrosVendedor.length - 1;
                }
                else{
                    this.minVen = this.minVen - 1;
                }

                this.filterOtrosVendedor(this.minVen);
            },
            moverDerVendedor(){
                this.minVen = this.minVen + 1;
                if (this.minVen >= this.otrosVendedor.length){
                    this.minVen = 0;
                }
                this.filterOtrosVendedor(this.minVen);
            },
            activarComprar(){
                this.acivado = 1;
            }
        },

    mounted() {
        setInterval(this.moverDer, 5000); // Change image every 2 seconds
    },
    created() {
        this.filterOtros(0);
        this.filterOtrosVendedor(0);
    },
}
</script>


<style scoped>
@media (max-width: 500px) {
    .flechita{
        width: 30px;
        height: 30px;
    }
    .celuCarrusel{
        overflow: auto;
    }
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
        text-align: center;
    }
    h2.card-text{
        font-size: 20px;
        text-align: center;
    }
    h1.card-text{
        font-size: 25px;
        text-align: center;
    }
    .container2 {
        background-color: white;
        margin: 1%;
        width: 200px;
        float: left;
        border-radius: 5px;
    }
    .colum2 {
        flex-direction: column;
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

    .image2{
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .image2 img{
        max-width: 100%;
        max-height: 100%;
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
    .flechita{
        width: 50px;
        height: 50px;
    }
    .altura{
        height: 118px;
    }
    #cambio{
        margin-top: 118px;
    }
    p.card-text{
        font-size: 20px;
        text-align: center;
    }
    h2.card-text{
        font-size: 25px;
        text-align: center;
    }
    h1.card-text{
        font-size: 30px;
        text-align: center;
    }
    .container2 {
        background-color: white;
        width: 250px;
        margin: 1%;
        float: left;
        border-radius: 5px;
    }

    .colum2 {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
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
        height: 250px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .image2 img{
        max-width: 100%;
        max-height: 100%;
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
