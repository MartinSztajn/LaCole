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



        <div class="py-12">
            <div class="overflow-hidden shadow-xl sm:rounded-lg" style="margin: 1%; padding: 15px;">
                <h1 style="font-size: 45px; text-align: center; position: center; margin-bottom: 3%;"><b>Negocio: {{nombre}}</b></h1>
                <div style="">
                    <div class="container2" v-for="pro in productos" style="margin-bottom: 10px">
                        <div  @click="verProductoDetalle(pro.nomCat, pro.nombre)" class="image2">
                            <img :src="'/fotos/' + pro.path">
                        </div>
                        <hr>
                        <div class="colum2">
                            <h2 class="card-text"><b> {{pro.nombre}}</b> </h2>
                            <h2 class="card-text">{{pro.nomEstado}}</h2>
                            <br>
                            <h1 class="card-text" >${{pro.precio}}</h1>
                            <br>
                            <button v-if="id != pro.id" @click="deseaEliminar(pro.id)" class="btn btn-primary" style="background-color: #FF9292; margin-bottom: 10px">Eliminar</button>
                            <button v-if="id == pro.id" @click="borrarProducto(pro.id)" class="btn btn-primary" style="background-color: red; margin-bottom: 10px">Confirmar</button>
                            <button @click="verOfertas(pro.id)" class="btn" style="background-color: green; color: white; margin-bottom: 10px">Ofertas</button>
                            <button @click="verPerfilProducto(pro.id)" class="btn btn-primary" style="margin-bottom: 10px">Editar</button>
                        </div>
                    </div>
                </div>
            </div>

            <button @click="activarCrear()" class="btn btn-primary" style="width: 90%;  margin-left: 5%; margin-right: 5%; position: center; text-align: center; margin-top: 1%;">Agregar Producto</button>
            <div v-if="btnActivado" class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-top: 5%; padding: 2%; width: 70%; margin-left: 15%;">
                <h2 style="margin: 20px">Nombre Producto:</h2>
                <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                <br>
                <h2 style="margin: 20px">Categoria:</h2>
                <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.categoria_id">
                    <option v-for="cat in categorias" :value="cat.id">{{cat.nombre}}</option>
                </select>
                <br>
                <h2 style="margin: 20px">Estado:</h2>
                <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.estado_id">
                    <option v-for="est in estados" :value="est.id">{{est.nombre}}</option>
                </select>
                <br>
                <h2 style="margin: 20px">Color:</h2>
                <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.color_id">
                    <option v-for="col in colores" :value="col.id">{{col.nombre}}</option>
                </select>
                <br>
                <h2 style="margin: 20px">Precio:</h2>
                <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="number"   class="form-control" v-model="form.precio" >
                <br>
                <h2 style="margin: 20px">Stock:</h2>
                <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="number"   class="form-control" v-model="form.stock" >
                <br>
                <h2 style="margin: 20px">Cantidad Oferta Minima:</h2>
                <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="number"   class="form-control" v-model="form.cant_minimo" >
                <br>
                <h2 style="margin: 20px">Descripcion:</h2>
                <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.descripcion" >
                <br>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Imagenes:</h2>
                <p style="margin-bottom: 20px">Se puedea seleccionar mas de una</p>
                <div class="row">
                    <img v-for="imagen in form.path" style="width: 250px" :src="imagen" class="img-thumbnail">
                </div>
                <input type="file" @change="establecerFoto1"/>


                <button class="btn btn-success" @click="guardarProducto" style="width: 70%; margin-left: 15%; background-color: black; margin-top: 2%">Guardar Producto</button>
                <h2 v-if="this.listo == 1" style="text-align: center; color: darkgreen"> Se Creo exitosamente el Producto </h2>
            </div >
        </div>

        <Footer></Footer>
    </cliente-layout>
</template>


<script>
import ClienteLayout from '@/Layouts/ClienteLayout.vue'
import Footer from '@/Layouts/Footer.vue'


export default {
    name: "verProductosNegocio",
    props: ['productos','categorias','fotosBanner','estados','colores'],
    components:{
        Footer,
        ClienteLayout
    },
    data()
    {
        return{
            btnActivado: false,
            btnVentas: 0,
            btnDuenos: 0,
            listo: 0,
            num: 0,
            id:'',
            idUser:'',
            form:{
                nombre:'',
                categoria_id:'',
                estado_id: '',
                color_id: '',
                precio:'',
                descripcion:'',
                    stock:'',
                cant_minimo:'',
                path:[]
            }

        }
    },
    methods:
        {
            deseaEliminar($id){
                this.id = $id;
            },
            activarCrear()
            {
                this.btnActivado = !this.btnActivado;
            },
            verProductoDetalle($nomCat, $nombre){
                this.$inertia.get('/verProductoDetalle/' + $nomCat + '/' + $nombre);
            },
            activarDuenos(){
                if (this.btnDuenos == 0){
                    this.btnDuenos = 1;
                    this.btnActivado = 0;
                    this.btnVentas = 0;
                }
                else{
                    this.btnDuenos = 0;
                }
            },
            borrarNegocio($id)
            {
                this.$inertia.post('/borrarNegocio/' + $id);
            },
            guardarNegocio()
            {
                if(this.listo == 0)
                {
                    this.listo = 1;
                    this.$inertia.post('/guardarNegocio', this.form);
                }
            },
            verOfertas($id){
                this.$inertia.get('/verOfertas/' + $id);
            },
            verPerfilProducto($id){
                this.$inertia.get('/verPerfilProducto/' + $id);

            },
            borrarProducto($id)
            {
                this.$inertia.post('/borrarProducto/' + $id);
            },
            borrarDueno($id){
                this.$inertia.post('/borrarDueno/' + $id);
            },
            guardarProducto()
            {
                if(this.form.nombre  != '' && this.form.categoria_id  != '' && this.form.estado_id  != ''  && this.form.precio  != '' && this.form.descripcion  != '' && this.form.stock  != '' && this.form.cant_minimo  != '' && this.form.color_id  != '' && this.form.path  != '')
                {
                    this.listo = 1;
                    this.$inertia.post('/guardarProducto', this.form);
                }
            },
            actualizarDueno(){
                this.$inertia.post('/actualizarDueno', this.form2);
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
            establecerFoto1(e) {
                let file = e.target.files[0];
                let reader = new FileReader();

                reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                    this.form.path.push(reader.result);
                }
                reader.readAsDataURL(file);
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
    .celuCarrusel{
        overflow: auto;
    }
    .altura{
        height: 63px;
    }
    .svgItem{
        width: 50px;
        height: 50px;
        margin-left: 30%
    }
    .titulo{
        text-align: center; font-size: 40px; padding: 20px
    }
    .textito{
        text-align: center; font-size: 15px; padding-top: 0px; margin-bottom: 15px
    }
    .itemsTexto{
        text-align: center; font-size: 20px;
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
    .computadora{
        display: flex;
    }
}

@media (min-width: 501px) {
    .computadora{
        display: none;
    }
    .celular{
        display: flex;
    }
    .svgItem{
        width: 60px;
        height: 60px;
        margin-left: 40%

    }
    .titulo{
        text-align: center; font-size: 60px; padding: 20px
    }
    .textito{
        text-align: center; font-size: 20px; padding-top: 0px; margin-bottom: 35px
    }
    .itemsTexto{
        text-align: center; font-size: 30px;
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
        width: 250px;
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
        width: 250px;
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
    display: flex;
    align-items: center;
}


.zoomable {
    transition: transform 0.3s;
}

.zoomable.zoomed {
    transform: scale(1.1);
}
</style>
