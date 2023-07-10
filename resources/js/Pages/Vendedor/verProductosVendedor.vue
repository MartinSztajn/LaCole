<template>
    <cliente-layout>
        <div class="altura" style="background-color: #121212;"></div>
        <div  id="carouselExampleControls" class="carousel slide" data-ride="carousel">
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



        <div  style="font-family: 'circular'" class="py-12" v-if="user.aceptado == 1">
            <div class="overflow-hidden shadow-xl sm:rounded-lg" style="margin: 1%; padding: 15px;">
                <h1 v-if="productos.length > 0" style="font-size: 45px; text-align: center; position: center; margin-bottom: 3%;"><b>Tus productos</b></h1>
                <h1 v-if="productos.length == 0" style="font-size: 45px; text-align: center; position: center; margin-bottom: 3%;"><b>No hay productos publicados</b></h1>
                <div style="display: flex;  flex-wrap: wrap;">
                    <div class="container2" v-for="pro in productos" style="margin-bottom: 10px">
                        <div v-if="pro.cantOfertas > 0" class="ofertas">{{pro.cantOfertas}}</div>
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
                             <button v-if="pro.cantOfertas > 0" @click="verOfertas(pro.id)" class="btn" style="background-color: orange; color: white; margin-bottom: 10px">Ver ofertas</button>
                             <button v-if="pro.cantOfertas == 0" class="btn" style="width: 100%; background-color: black; color: white; margin-bottom: 10px">Sin ofertas</button>
                            <button @click="verPerfilProducto(pro.id)" class="btn btn-primary" style="width: 100%; margin-bottom: 10px">Editar</button>
                            <button @click="compartirEnWhatsApp(pro)"  class="btn btn-primary" style="width: 100%; margin-bottom: 10px; background-color: green">Compartir en WhatsApp</button>
                        </div>
                    </div>
                </div>
            </div>

            <button @click="activarCrear()" class="btn btn-primary" style="width: 90%; background-color: black; color: white; margin-left: 5%; margin-right: 5%; position: center; text-align: center; margin-top: 1%;">Agregar Producto</button>
        </div>
        <div  style="font-family: 'circular'" class="py-12" v-if="user.aceptado == 0">
            <div class="overflow-hidden shadow-xl sm:rounded-lg" style="margin: 1%; padding: 15px;">
                <h1 class="texto" style="text-align: center; position: center; margin-bottom: 3%;"><b>Tu usuario aun no ha sido aceptado</b></h1>
                <p class="texto" style=" text-align: center; position: center; margin-bottom: 3%;">
                    Como una medida de seguridad y para garantizar el buen uso de “La Cole Market” antes de que puedas publicar <br>
                    tus productos para vender vamos a chequear tu informacion asi de forma segura podes formar parte de nuestra comunidad.
                    <br>
                    <br>
                    <b>¡En esta comunidad, todos nos cuidamos entre todos!</b>
                </p>

            </div>
        </div>

        <Footer></Footer>
    </cliente-layout>
</template>


<script>
import ClienteLayout from '@/Layouts/ClienteLayout.vue'
import Footer from '@/Layouts/Footer.vue'


export default {
    name: "verProductosVendedor",
    props: ['productos','categorias','fotosBanner','estados','colores','user'],
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
            mensajeFalta: '',
            form:{
                nombre:'',
                categoria_id:'',
                estado_id: '',
                color_id: '',
                precio:'',
                descripcion:'',
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
                this.$inertia.get('/verCrearProducto');
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
            verOfertas($id){
                this.$inertia.get('/verOfertas/' + $id);
            },
            verPerfilProducto($id){
                this.$inertia.get('/verPerfilProducto/' + $id);
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
            compartirEnWhatsApp(producto) {
                const nombreProducto = producto.nombre.replace(/ /g, '%20');
                const cateProducto = producto.nomCat.replace(/ /g, '%20');

                const mensaje = `¡Mira mi producto de la Cole Market!\n\nNombre: ${producto.nombre}\nPrecio: $${producto.precio}\nCategoría: ${producto.nomCat}\n${producto.descripcion}\n\n[Mira el producto en la Cole Market](https://phplaravel-1014987-3587857.cloudwaysapps.com/verProductoDetalle/${cateProducto}/${nombreProducto})`;

               const enlaceWhatsApp = `https://wa.me/?text=${encodeURIComponent(mensaje)}`;

                // Abrir enlace en una nueva ventana o redireccionar a la URL
                window.open(enlaceWhatsApp, '_blank');
            }
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
    p{
       font-size: 18px;
    }
    h1{
        font-size: 30px;
    }
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
    .image2 {
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .image2 img {
        max-width: 100%;
        max-height: 100%;
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
    p{
        font-size: 25px;
    }
    h1{
        font-size: 45px;
    }
    .image2 {
        height: 250px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .image2 img {
        max-width: 100%;
        max-height: 100%;
    }
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
.ofertas{
    position: absolute;
    background-color: red;
    width: 25px;
    height: 25px;
    text-align: center;
    border-radius: 10px;
}


.zoomable {
    transition: transform 0.3s;
}

.zoomable.zoomed {
    transform: scale(1.1);
}
</style>
