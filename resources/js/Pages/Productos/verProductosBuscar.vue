<template>
    <cliente-layout>
        <div class="altura" style="background-color: #121212;"></div>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div v-if="fotosBanner && fotosBanner[num] " class="carousel-item active">
                    <a :href="'https://' + fotosBanner[num].url" target="_blank">
                        <img v-if="fotosBanner[num]" class="d-block w-100"  :src="'/fotos/' + fotosBanner[num].path" style="width: 100%" alt="First slide">
                    </a>
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

        <div class="overflow-hidden shadow-xl sm:rounded-lg" style="margin: 1%; padding: 15px;">
            <h1 style="font-size: 30px; text-align: center; position: center; margin-bottom: 3%;"><b>¡Encontramos estos productos!</b></h1>
            <div class="row celular">
                <div class="col-2" style="background-color: black; height: 100%; border-radius: 10px; padding: 20px">
                    <ul>
                        <h1 v-if="filtrosCategorias.length > 0 || filtrosColores.length > 0" style="color: white; font-size: 20px"><b>Filtro</b></h1>
                        <li v-if="filtrosCategorias.length > 0" v-for="fil in filtrosCategorias" style="">
                            <button  @click="quitarCategoria(fil)" class="btn" style="display: flex; color: lightgrey">
                                <svg style="margin-right: 10px; margin-top: 3px" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                </svg>
                                <p>{{fil}}</p>
                            </button>
                        </li>
                        <li v-if="filtrosColores.length > 0" v-for="fil in filtrosColores" style="">
                            <button  @click="quitarColor(fil)" class="btn" style="display: flex; color: lightgrey">
                                <svg style="margin-right: 10px; margin-top: 3px" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                </svg>
                                <p>{{fil}}</p>
                            </button>
                        </li>
                    </ul>
                    <hr  v-if="filtrosCategorias.length > 0 || filtrosColores.length > 0" style="width: 90%; margin: 5%; border: 2px solid white;">
                    <ul>
                        <h1 style="color: white; font-size: 20px"><b>Categorias</b></h1>
                        <li v-for="cate in categorias" style="">
                            <button  @click="agregarCategoria(cate.nombre)" class="btn" style="color: lightgrey">
                                <p>{{cate.nombre}}</p>
                            </button>
                        </li>
                    </ul>
                    <ul style="margin-top: 20px">
                        <h1 style="color: white; font-size: 20px"><b>Colores</b></h1>
                        <li v-for="col in colores" style="">
                            <button  @click="agregarColor(col.nombre)" class="btn" style="color: lightgrey; display: flex">
                                <div class="rounded-circle" :style="'width: 25px; height: 25px; border: 4px solid black; background-color:' + col.color"></div>
                                <p>{{col.nombre}}</p>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="col-10">
                    <div class="row" style="margin-bottom: 2%; width: 100%;">
                        <div class="col-4">
                            <select style="width: 60%; margin-right: 20%; margin-left: 20%;" class="form-control" v-model="estado_id" @change="filtrarEstado(estado_id)">
                                <option value="0" selected>Ambos</option>
                                <option v-for="est in estados" :value="est.id">{{est.nombre}}</option>
                            </select>
                        </div>
                        <div class="col-4" style="margin-right: 5%">
                            <input class='search-text' placeholder='Filtrar nombre...' style="padding-left: 10px"  v-model="buscador" @input="buscarFiltrado"/>
                        </div>
                        <div class="col-2">
                            <input style="width: 40%; margin-left: 5%; margin-right:5%; height: 35px; border: none" type="number"  v-model="minValue" placeholder="Min" @change="buscarFiltrado">
                            <input style="width: 40%; margin-left: 5%; margin-right:5%; height: 35px; border: none" type="number" v-model="maxValue" placeholder="Max"  @change="buscarFiltrado">
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: wrap;">
                        <div v-for="(pro, index) in productosFiltrados"  @click="verProductoDetalle(pro.nomCat, pro.nombre)"  @mouseover="handleMouseOverOfertados(index)" @mouseleave="handleMouseLeaveOfertados(index)"  class="container2" :style="productosFiltrados[index].zoomed  ? 'transform: scale(1.1); margin-bottom: 10px' : 'margin-bottom: 10px'">
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
                    </div>
                    <div v-if="cantPaginate > 1" style="display: flex; margin: 15px" >
                        <div v-for="n in cantPaginate" style="margin-right: 5px">
                            <button class="btn" style="background-color: #C5C5C5" @click="pasarPagina(n)">{{n}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row computadora">
                <div>
                    <div class="row" style="margin-bottom: 5%; margin-top: 5%">
                        <div class="col-6">
                            <select style="width: 80%; margin-right: 10%; margin-left: 10%;" class="form-control" v-model="estado_id" @change="filtrarEstado(estado_id)">
                                <option value="0" selected>Ambos</option>
                                <option v-for="est in estados" :value="est.id">{{est.nombre}}</option>
                            </select>
                        </div>
                        <div class="col-6" style="display: flex;">
                            <input style="width: 40%; margin-left: 8%; margin-right: 2%;" type="number" id="min" v-model="minValue" placeholder="Min" @change="buscarFiltrado">
                            <input style="width: 40%; margin-right: 8%; margin-left: 2%;" type="number" id="max" v-model="maxValue" placeholder="Max"  @change="buscarFiltrado">
                        </div>
                    </div>

                    <ul >
                        <h1 v-if="filtrosCategorias.length > 0 || filtrosColores.length > 0" style="color: black; font-size: 20px"><b>Filtro</b></h1>
                        <div v-if="filtrosCategorias.length > 0"  style="display: flex; overflow: auto;">
                            <button v-for="fil in filtrosCategorias" @click="quitarCategoria(fil)" class="btn">
                                <svg style="margin-right: 10px; margin-top: 3px" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="black" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                </svg>
                                <p>{{fil}}</p>
                            </button>
                        </div>
                        <div v-if="filtrosColores.length > 0" style="display: flex; overflow: auto;">
                            <button v-for="fil in filtrosColores" @click="quitarColor(fil)" class="btn">
                                <svg style="margin-right: 10px; margin-top: 3px" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="black" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                </svg>
                                <p>{{fil}}</p>
                            </button>
                        </div>
                    </ul>
                    <hr v-if="filtrosCategorias.length > 0 || filtrosColores.length > 0" style="width: 90%; margin: 5%; border: 2px solid white;">
                    <ul>
                        <h1 style="color: black; font-size: 20px"><b>Categorias</b></h1>
                        <div style="display: flex; overflow: auto;">
                            <button v-for="cate in categorias" @click="agregarCategoria(cate.nombre)" class="btn" >
                                <p>{{cate.nombre}}</p>
                            </button>
                        </div>
                    </ul>
                    <ul style="margin-top: 20px">
                        <h1 style="color: black; font-size: 20px"><b>Colores</b></h1>
                        <div style="display: flex; overflow: auto;" >
                            <button v-for="col in colores"  @click="agregarColor(col.nombre)" class="btn">
                                <div class="rounded-circle" :style="'width: 25px; height: 25px; border: 4px solid black; background-color:' + col.color"></div>
                                <p>{{col.nombre}}</p>
                            </button>
                        </div>
                    </ul>
                </div>
                <div style=" display: flex; margin-bottom: 1%; margin-top: 10%;flex-wrap: wrap;">
                    <div @click="verProductoDetalle(pro.nomCat, pro.nombre)" class="container2" v-for="pro in productosFiltrados" style="margin: 10px">
                    <div class="image2">
                        <img :src="'/fotos/' + pro.path">
                    </div>
                    <hr>
                    <div class="colum2">
                        <h2 class="card-text" style="font-size: 15px"><b> {{pro.nombre}}</b> </h2>
                        <h2 class="card-text" style="font-size: 12px">{{pro.nomEstado}}</h2>
                        <br>
                        <h1 class="card-text" style="font-size: 15px">${{pro.precio}}</h1>
                    </div>
                </div>
            </div>
                <div v-if="cantPaginate > 1" style="display: flex; margin: 15px" >
                    <div v-for="n in cantPaginate" style="margin-right: 5px">
                        <button class="btn" style="background-color: #C5C5C5" @click="pasarPagina(n)">{{n}}</button>
                    </div>
                </div>
            </div>
        </div>

    <Footer></Footer>
    </cliente-layout>
</template>


<script>
import ClienteLayout from '@/Layouts/ClienteLayout.vue'
import Footer from '@/Layouts/Footer.vue'

export default {
    name: "verProductosBuscar",
    props: ['productos','categorias','fotosBanner','colores','estados','cantPaginate'],
    components:{
        ClienteLayout,
        Footer
    },
    data()
    {
        return{
            filtrosCategorias: [],
            filtrosColores: [],
            productosFiltrados: this.productos,
            mensajeCate: '',
            mensajeColor: '',
            estado_id: 0,
            hola:'',
            pagina: 0,
            num: 0,
            minValue: '',
            maxValue: '',
            buscador: '',
        }
    },
    methods:
        {
            filtrarEstado($nombre){
                this.estado_id = $nombre;
                this.buscarFiltrado();
            },
            quitarCategoria($nombre){
                this.filtrosCategorias = this.filtrosCategorias.filter(item => item !== $nombre);
                this.buscarFiltrado();

            },
            quitarColor($nombre){
                this.filtrosColores = this.filtrosColores.filter(item => item !== $nombre);
                this.buscarFiltrado();
            },
            pasarPagina(n){
                this.pagina = n - 1;
                this.buscarFiltrado();
            },
            buscarFiltrado(){
                this.mensajeColor = ''; this.mensajeCate = '';

                for (var i = 0; i < this.filtrosColores.length; i++){
                    this.mensajeColor = this.mensajeColor + ',' + this.filtrosColores[i];
                }
                for (var i = 0; i < this.filtrosCategorias.length; i++){
                    this.mensajeCate = this.mensajeCate + ',' + this.filtrosCategorias[i];
                }
                axios.get('/filtrar?colores=' +this.mensajeColor.substr(1) + '&categorias=' +  this.mensajeCate.substr(1) + '&estado=' + this.estado_id  + '&buscador=' + this.buscador  + '&min=' + this.minValue + '&max=' + this.maxValue + '&pagina=' + this.pagina , {
                })
                    .then(response => {
                        this.productosFiltrados = response.data.productos;
                        this.cantPaginate = response.data.cant;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            agregarCategoria($nombre){
                if (!this.filtrosCategorias.includes($nombre)) {
                    this.filtrosCategorias.push($nombre);
                    this.buscarFiltrado();
                }
            },
            agregarColor($nombre){
                if (!this.filtrosColores.includes($nombre)) {
                    this.filtrosColores.push($nombre);
                    this.buscarFiltrado();
                }
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
            fetchProducts(url) {
                axios.get(url)
                    .then(response => {
                        this.products = response.data.data;
                        this.prevPageUrl = response.data.prev_page_url;
                        this.nextPageUrl = response.data.next_page_url;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            handleMouseOverOfertados($i) {
                this.productosFiltrados[$i].zoomed = true;
            },
            handleMouseLeaveOfertados($i) {
                this.productosFiltrados[$i].zoomed = false;
            },
        },
        mounted() {

            this.timer = setInterval(() => {
                this.moverDer();
            }, 5000);
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
        width: 150px;
        float: left;
        border-radius: 5px;
    }
    .colum2 {
        flex-direction: column;
        margin-right: 10px;
        flex: 1;
        text-align: center;
        width: 150px;
        padding: 10px;
    }

    .colum2 div {
        background-color: #17428A;
        font-size: 1.4rem;
        padding: 5px 0;
        border-bottom: 1px solid white;
    }
    .image2{
        display: flex;
        justify-content: center;
    }
    .image2 img {
        max-width: none;
        height: 150px;
        width: 150px;
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
    .computadora{
        display: none;
    }
    .altura{
        height: 118px;
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
        width: 200px;
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
    }


    .colum2 div {
        background-color: #17428A;
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
    .botones{
        float: left; margin-right: 3%; width: 20%; background-color: grey; color: white; font-size: 30px;
    }
    .card{
        width: 23%;
        margin-right: 2%;
        float: left;
        margin-bottom: 2%;
    }
    .celu{
        display: none;
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
.search-text {
    font-size: 14px;
    width: 100%;
    height: 35px;
}
</style>
