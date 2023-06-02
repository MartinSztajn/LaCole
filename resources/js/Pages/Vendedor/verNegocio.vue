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
                            <h1 class="card-text" >${{pro.precio_max}}</h1>
                            <h2 class="card-text"><b> {{pro.nombre}}</b> </h2>
                            <p class="card-text">Categoria: {{pro.nomCat}}</p>
                            <p class="card-text"><b>Unidades: {{pro.cantidad}} </b> </p>
                            <p class="card-text">Precio por unidad: ${{(pro.precio_max / pro.cantidad).toFixed(0)}}</p>
                            <p class="card-text">Faltan {{pro.fechaLanzamiento}}</p>
                            <p class="card-text">Estado: {{pro.nomEstado}}</p>

                            <br>
                            <p class="card-text" style="color: red;" v-if="pro.cantOfertas > 1"><b>YA HAY {{pro.cantOfertas}} OFERTAS</b></p>
                            <p class="card-text" style="color: red;" v-if="pro.cantOfertas == 1"><b>YA HAY {{pro.cantOfertas}} OFERTA</b></p>
                            <p class="card-text" v-if="pro.cantOfertas == 0"><b>NO HAY OFERTAS</b></p>
                            <br>
                            <button v-if="id != pro.id" @click="deseaEliminar(pro.id)" class="btn btn-primary" style="background-color: #FF9292; margin-bottom: 10px">Eliminar</button>
                            <button v-if="id == pro.id" @click="borrarProducto(pro.id)" class="btn btn-primary" style="background-color: red; margin-bottom: 10px">Confirmar</button>
                            <button @click="verOfertas(pro.id)" class="btn" style="background-color: green; color: white; margin-bottom: 10px">Ofertas</button>
                            <button @click="verPerfilProducto(pro.id)" class="btn btn-primary" style="margin-bottom: 10px">Editar</button>
                        </div>
                        <br>
                    </div>
                </div>
            </div>

            <button @click="activarVentas()" class="btn btn-primary" style="width: 90%; margin-left: 5%; margin-right: 5%; position: center; text-align: center; margin-top: 3%;">Ver Ventas</button>
            <button @click="activarCrear()" class="btn btn-primary" style="width: 90%;  margin-left: 5%; margin-right: 5%; position: center; text-align: center; margin-top: 1%;">Agregar Producto</button>
            <!-- <button @click="activarDuenos()" class="btn btn-primary" style="width: 90%;  margin-left: 5%; margin-right: 5%; position: center; text-align: center; margin-top: 1%;">Editar Duenos</button>
           -->
            <div v-if="btnActivado == 1" class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-top: 5%; padding: 2%; width: 70%; margin-left: 15%;">
                <h2 style="margin: 20px">Nombre Producto:</h2>
                <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                <br>
                <h2 style="margin: 20px">Categoria:</h2>
                <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.categoria_id">
                    <option v-for="cat in categorias2" :value="cat.id">{{cat.nombre}}</option>
                </select>
                <br>
                <h2 style="margin: 20px">Estados:</h2>
                <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.estado_id">
                    <option v-for="est in estados" :value="est.id">{{est.nombre}}</option>
                </select>
                <br>
                <h2 style="margin: 20px">Precio:</h2>
                <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="number"   class="form-control" v-model="form.precio_max" >
                <br>
                <h2 style="margin: 20px">Cantidad:</h2>
                <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="number"   class="form-control" v-model="form.cantidad" >
                <br>
                <h2 style="margin: 20px">Cantidad Oferta Minima:</h2>
                <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="number"   class="form-control" v-model="form.cant_min" >
                <br>
                <h2 style="margin: 20px">Fecha Finalizacion:</h2>
                <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="date"   class="form-control" v-model="form.fecha_fin" >
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
            <div v-if="btnVentas == 1" class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-top: 5%; padding: 2%; width: 70%; margin-left: 15%;">
                <h1 style="margin: 20px; text-align: center; font-size: 40px">Ventas</h1>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Provincia</th>
                        <th scope="col">Precio Prov.</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="ven in ventas">
                        <td>{{ven.prodNombre}}</td>
                        <td>{{ven.prodPrecio}}</td>
                        <td>{{ven.cantidad}}</td>
                        <td>{{ven.cliProvNom}}</td>
                        <td>{{ven.cliProvPre}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Footer></Footer>
    </cliente-layout>
</template>


<script>
import ClienteLayout from '@/Layouts/ClienteLayout.vue'
import Footer from '@/Layouts/Footer.vue'


export default {
    name: "verNegocio",
    props: ['idNeg','productos','nombre','categorias','ventas','duenos','estados', 'fotosBanner', 'categorias2'],
    components: {
        ClienteLayout,
        Footer
    },
    data()
    {
        return{
            btnActivado: 0,
            btnVentas: 0,
            btnDuenos: 0,
            listo: 0,
            num: 0,
            id:'',
            idUser:'',
            form2:{
              user_id: '',
              negocio_id: this.idNeg,
            },
            form:{
                nombre:'',
                negocio_id: this.idNeg,
                categoria_id:'',
                estado_id: '',
                precio_max:'',
                fecha_fin:'',
                descripcion:'',
                cantidad:'',
                cant_min:'',
                path:[]
            }
        }
    },
    methods:
        {
            deseaEliminar($id){
                this.id = $id;
            },
            deseaEliminarDueno($id){
                this.idUser = $id;
            },
            activarCrear()
            {
               if (this.btnActivado == 0){
                   this.btnActivado = 1;
                   this.btnVentas = 0;
                   this.btnDuenos = 0;
               }
               else{
                   this.btnActivado = 0;
               }
            },
            activarVentas()
            {
                if (this.btnVentas == 0){
                    this.btnVentas = 1;
                    this.btnActivado = 0;
                    this.btnDuenos = 0;
                }
                else{
                    this.btnVentas = 0;
                }
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
                if(this.listo == 0 && this.form.nombre  != '' && this.form.categoria_id  != '' && this.form.estado_id  != ''  && this.form.precio_max  != '' && this.form.fecha_fin  != '' && this.form.descripcion  != '' && this.form.cantidad  != '' && this.form.cant_min  != '' && this.form.path  != '')
                {
                    if(this.form.cantidad > this.form.cant_min){
                        this.form.negocio_id = this.idNeg;
                        this.listo = 1;
                        this.$inertia.post('/guardarProducto', this.form);
                    }
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
        setInterval(this.moverDer, 5000); // Change image every 2 seconds
    }
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
        width: 95%;
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
        height: 200px;
        width: 200px;
        display: block;}
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
    .cate{
        margin-top: 40px;
        float: left;
        margin-right: 30px;
    }
    .fotoCategoria{
        width: 125px;
        height: 125px;
    }
}

@media (min-width: 501px) {
    .cate{
        margin-top: 40px;
        float: left;
        margin-right: 30px;
    }

    .fotoCategoria{
        width: 175px;
        height: 175px;
    }
    .altura{
        height: 118px;
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
</style>
