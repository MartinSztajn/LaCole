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
        <div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="padding: 50px; margin: 3%">
                <h1 v-if="editrnombre == false " @dblclick="editarNombre()" style="text-align: center; position: center; font-size: 50px;">{{producto.nombre}}</h1>
                <input ref="cellinput" type="text" v-show="editrnombre == true" v-model="producto.nombre" style="text-align: center; width: 96%; position: center; font-size: 50px; margin: 3%;" @keyup.enter="guardarNombre">

                <div style="width: 100%; display: flex">
                    <div v-for="(imagen, index) in producto.path" style="margin-right: 5%; margin-bottom: 5%; ">
                        <img v-if="editrfoto[index] == false && imagen.path != ''" @dblclick="editarFoto(index)" :src="'/fotos/' + imagen.path" style="min-height:200px; max-width: 250px; border-radius: 30px;">
                        <div  v-show="editrfoto[index] == true" style="margin-bottom: 5%">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cambiar La imagen:</h2>
                            <p style="margin-bottom: 20px">Se puede seleccionar mas de una</p>
                            <input type="file" @change="establecerFoto1"/>
                            <button class="btn" style="width: 100%; margin-top: 3%; background-color: red; color: white" @click="eliminarFoto(imagen.id)">Eliminar Esta Foto</button>
                            <button class="btn" style="width: 100%; margin-top: 3%; background-color: black; color: white" @click="guardarFoto(index, imagen.id)">Modificar Foto</button>
                        </div>
                    </div>
                </div>

                <h1 v-if="editrprecio == false " @dblclick="editarPrecio()"  style="font-size: 30px;"><b><b>Precio:</b> ${{producto.precio}}</b></h1>
                <input ref="cellinput" type="text" v-show="editrprecio == true" v-model="producto.precio" style="width: 100%font-size: 40px; margin-bottom: 2%; text-align: center; position: center" @keyup.enter="guardarPrecio">
                <br>
                <h1 v-if="editrcant_min == false " @dblclick="editarCantidadMinima()"  style="font-size: 20px;"><b>Cantidad Minimo: {{producto.cant_minimo}}</b></h1>
                <input ref="cellinput" type="number" v-show="editrcant_min == true" v-model="producto.cant_minimo" style="width: 100%font-size: 40px; margin-bottom: 2%; text-align: center; position: center" @keyup.enter="guardarCantidadMinima">
                <br>
                <h1 v-if="editrdesc == false " @dblclick="editarDesc()" style="font-size: 20px; "><b>Descripcion:</b> {{producto.descripcion}}</h1>
                <input ref="cellinput" type="text" v-show="editrdesc == true" v-model="producto.descripcion" style="font-size: 20px; width: 100%" @keyup.enter="guardarDesc">
                <br>
                <p v-if="editrestado == false " @dblclick="editarEstado()" style="font-size: 20px"><b>Estado:</b> {{producto.nomEstado}}</p><br>
                <select v-show="editrestado == true" style="width: 60%; margin-right: 2%; margin-left: 2%; float: left" class="form-control" v-model="producto.estado_id">
                    <option v-for="est in estados" :value="est.id">{{est.nombre}}</option>
                </select>
                <button  v-show="editrestado == true" class="btn btn-success" style="background-color: black" @click="guardarEstado">Guardar Estado</button>
                <br>
                <p v-if="editrcolor == false " @dblclick="editarColor()" style="font-size: 20px"><b>Color:</b> {{producto.nomColor}}</p><br>
                <select v-show="editrcolor == true" style="width: 60%; margin-right: 2%; margin-left: 2%; float: left" class="form-control" v-model="producto.color_id" >
                    <option v-for="col in colores" :value="col.id">{{col.nombre}}</option>
                </select>
                <button  v-show="editrcolor == true" class="btn btn-success" style="background-color: black" @click="guardarColor">Guardar Estado</button>
                <br>
                <p v-if="editrcat == false " @dblclick="editarCategoria()" style="font-size: 20px"><b>Categoria:</b> {{producto.nomCat}}</p><br>
                <select v-show="editrcat == true" style="width: 60%; margin-right: 2%; margin-left: 2%; float: left" class="form-control" v-model="producto.categoria_id" @keyup.enter="guardarCategoria">
                    <option v-for="cat in categorias" :value="cat.id">{{cat.nombre}}</option>
                </select>
                <button  v-show="editrcat == true" class="btn btn-success" style="background-color: black" @click="guardarCategoria">Guardar Categoria</button>
                <button v-if="eliminar == 0" @click="deseaEliminar(producto.id)" class="btn btn-primary" style="background-color: #FF9292; margin-bottom: 10px">Eliminar Producto</button>
                <button v-if="eliminar == 1" @click="borrarProducto(producto.id)" class="btn btn-primary" style="background-color: red; margin-bottom: 10px">Confirmar</button>


            </div>
        </div>
    </cliente-layout>
</template>
<script>
import ClienteLayout from '@/Layouts/ClienteLayout.vue'

export default {
    name: "perfilProducto",
    props: ['producto', 'negocios', 'categorias','colores','estados','fotosBanner'],
    components: {
        ClienteLayout
    },
    data()
    {
        return{
            mitad: this.producto.precio_max/2,
            hola:'',
            rango: 0,
            num: 0,
            eliminar: 0,

            path:[],
            form:{
                provincia_id:'',
                producto_id: this.producto.id,
                mail:'',
                precio:'',
                cantidad: '',
                nombre:'',
                apellido:'',
                negocio_id: '',
                categoria_id: ''
            },
            editrnombre: false,
            editrprecio: false,
            editrcantidad: false,
            editrdesc: false,
            editrfecha: false,
            editrfoto: [false, false, false, false,false,false,false,false,false,false,false,false],
            editrcant_min: false,
            editrneg: false,
            editrcat: false,
            editrcolor: false,
            editrestado: false,
        }
    },
    methods:
        {
            deseaEliminar(){
                this.eliminar = 1;
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
            editarNombre()
            {
                this.editrnombre = true;
            },
            editarColor()
            {
                this.editrcolor = true;
            },
            editarEstado()
            {
                this.editrestado = true;
            },
            editarFoto($i)
            {
                this.editrfoto[$i] = true;
            },
            editarPrecio()
            {
                this.editrprecio = true;
            },
            editarCantidad()
            {
                this.editrcantidad = true;
            },
            editarDesc()
            {
                this.editrdesc = true;
            },
            editarCategoria()
            {
                this.editrcat = true;
            },
            editarCantidadMinima(){
                this.editrcant_min = true;
            },
            guardarNombre()
            {
                this.editrnombre = false;
                axios.post('/editarProducto', {tipo: 'Nombre', valor: this.producto.nombre,
                    id: this.producto.id}).then();
            },
            guardarPrecio()
            {
                this.editrprecio = false;
                axios.post('/editarProducto', {tipo: 'Precio', valor: this.producto.precio,
                    id: this.producto.id}).then();
            },
            guardarCantidad()
            {
                this.editrcantidad = false;
                axios.post('/editarProducto', {tipo: 'Stock', valor: this.producto.stock,
                    id: this.producto.id}).then();
            },
            guardarDesc()
            {
                this.editarDesc = false;
                axios.post('/editarProducto', {tipo: 'Descripcion', valor: this.producto.descripcion,
                    id: this.producto.id}).then();
            },
            guardarCategoria()
            {
                this.editrcategoria = false;
                axios.post('/editarProducto', {tipo: 'Categoria', valor: this.producto.categoria_id,
                    id: this.producto.id}).then();
            },
            guardarFoto($i, $imagen)
            {
                this.editrfoto[$i] = false;
                axios.post('/editarProducto', {tipo: 'Foto', valor: this.path, imagen: $imagen,
                    id: this.producto.id}).then();
            },
            guardarCantidadMinima(){
                this.editrcant_min = false;
                axios.post('/editarProducto', {tipo: 'cant_minimo', valor: this.producto.cant_minimo,
                    id: this.producto.id}).then();
            },
            guardarEstado()
            {
                this.editrestado = false;
                axios.post('/editarProducto', {tipo: 'Estado', valor: this.producto.estado_id,
                    id: this.producto.id}).then();
            },
            guardarColor(){
                this.editrcolor = false;
                axios.post('/editarProducto', {tipo: 'Color', valor: this.producto.color_id,
                    id: this.producto.id}).then();
            },
            eliminarFoto($i){
                axios.post('/eliminarFotoProducto/' + $i);
            },
            establecerFoto1(e) {
                this.path = [];
                let file = e.target.files[0];
                let reader = new FileReader();

                reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                    this.path.push(reader.result);
                }
                reader.readAsDataURL(file);
            },
            borrarProducto($id)
            {
                this.$inertia.post('/borrarProducto/' + $id);
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

    .compu{
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
    }

    .colum2 div {
        background-color: #28285b;
        font-size: 1.4rem;
        padding: 5px 0;
        border-bottom: 1px solid white;
    }
}
</style>
