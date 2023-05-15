<template>
        <div>
            <h1 v-if="editrnombre == false " @dblclick="editarNombre()" style="text-align: center; position: center; font-size: 100px; margin-top: 3%">{{producto.nombre}}</h1>
            <input ref="cellinput" type="text" v-show="editrnombre == true" v-model="producto.nombre" style="text-align: center; position: center; font-size: 100px; margin-top: 3%; margin-left: 10%" @keyup.enter="guardarNombre">


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="padding: 50px; margin: 3%">
                <img v-if="editrfoto == false && producto.path != ''" @dblclick="editarFoto()" :src="'/fotos/' + producto.path" style="min-height:400px; max-width: 450px; float: left; margin-right: 5%; margin-bottom: 5%; border-radius: 30px;">
                <div  v-show="editrfoto == true" style="margin-bottom: 5%">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Imagenes:</h2>
                    <p style="margin-bottom: 20px">Se puede seleccionar mas de una</p>
                    <div class="row">
                        <img v-for="imagen in path" style="width: 250px" :src="imagen" class="img-thumbnail">
                    </div>
                    <input type="file" @change="establecerFoto1"/>
                    <button class="btn" style="width: 100%; margin-top: 3%; background-color: black; color: white" @click="guardarFoto">Modificar Foto</button>
                </div>
                <h1 v-if="editrprecio == false " @dblclick="editarPrecio()"  style="font-size: 40px; margin-bottom: 2%; text-align: center; position: center "><b><b>Precio Maximo:</b> ${{producto.precio_max}}</b></h1>
                <input ref="cellinput" type="text" v-show="editrprecio == true" v-model="producto.precio_max" style="font-size: 40px; margin-bottom: 2%; text-align: center; position: center" @keyup.enter="guardarPrecio">

                <h1 v-if="editrcant_min == false " @dblclick="editarCantidadMinima()"  style="font-size: 40px; margin-bottom: 2%; text-align: center; position: center "><b>Cantidad Minimo: {{producto.cant_minimo}}</b></h1>
                <input ref="cellinput" type="text" v-show="editrcant_min == true" v-model="producto.cant_minimo" style="font-size: 40px; margin-bottom: 2%; text-align: center; position: center" @keyup.enter="guardarCantidadMinima">

                <h1 v-if="editrcantidad == false " @dblclick="editarCantidad()"  style="font-size: 40px; margin-bottom: 2%; text-align: center; position: center "><b>Cantidad: {{producto.cantidad}}</b></h1>
                <input ref="cellinput" type="text" v-show="editrcantidad == true" v-model="producto.cantidad" style="font-size: 40px; margin-bottom: 2%; text-align: center; position: center" @keyup.enter="guardarCantidad">

                <h1 v-if="editrdesc == false " @dblclick="editarDesc()" style="font-size: 25px; margin-bottom: 5%; text-align: center; position: center "><b>Descripcion:</b> {{producto.descripcion}}</h1>
                <input ref="cellinput" type="text" v-show="editrdesc == true" v-model="producto.descripcion" style="font-size: 40px; margin-bottom: 2%; text-align: center; position: center" @keyup.enter="guardarDesc">

                <p v-if="editrneg == false " @dblclick="editarNegocio()" class="card-text" style="font-size: 20px"><b>Negocio:</b> {{producto.nomNeg}}</p><br>
                <select v-show="editrneg == true" style="width: 60%; margin-right: 2%; margin-left: 2%; float: left" class="form-control" v-model="producto.negocio_id" @keyup.enter="guardarNegocio">
                    <option v-for="neg in negocios" :value="neg.id">{{neg.nombre}}</option>
                </select>
                <button  v-show="editrneg == true" class="btn btn-success" style="background-color: black" @click="guardarNegocio">Guardar Negocio</button>

                <p v-if="editrcat == false " @dblclick="editarCategoria()" class="card-text" style="font-size: 20px"><b>Categoria:</b> {{producto.nomCat}}</p><br>
                <select v-show="editrcat == true" style="width: 60%; margin-right: 2%; margin-left: 2%; float: left" class="form-control" v-model="producto.categoria_id" @keyup.enter="guardarCategoria">
                    <option v-for="cat in categorias" :value="cat.id">{{cat.nombre}}</option>
                </select>
                <button  v-show="editrcat == true" class="btn btn-success" style="background-color: black" @click="guardarCategoria">Guardar Categoria</button>

                <p v-if="editrfecha == false" @dblclick="editarFecha()" class="card-text" style="font-size: 20px"><b>Fecha:</b> {{producto.fecha_fin}}</p>
                <input ref="cellinput" type="date" v-show="editrfecha == true" v-model="producto.fecha_fin" style="font-size: 40px; margin-bottom: 2%; text-align: center; position: center" @keyup.enter="guardarFecha">

            </div>
        </div>
</template>
<script>

export default {
    name: "perfilProducto",
    props: ['producto', 'negocios', 'categorias'],
    components: {
    },
    data()
    {
        return{
            mitad: this.producto.precio_max/2,
            hola:'',
            rango: 0,
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
            editrfoto: false,
            editrcant_min: false,
            editrneg: false,
            editrcat: false
        }
    },
    methods:
        {
            editarNombre()
            {
                this.editrnombre = true;
            },
            editarFoto()
            {
                this.editrfoto = true;
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
            editarFecha()
            {
                this.editrfecha = true;
            },
            editarNegocio()
            {
                this.editrneg = true;
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
                axios.post('/editarProducto', {tipo: 'Precio', valor: this.producto.precio_max,
                    id: this.producto.id}).then();
            },
            guardarCantidad()
            {
                this.editrcantidad = false;
                axios.post('/editarProducto', {tipo: 'Cantidad', valor: this.producto.cantidad,
                    id: this.producto.id}).then();
            },
            guardarDesc()
            {
                this.editarDesc = false;
                axios.post('/editarProducto', {tipo: 'Descripcion', valor: this.producto.descripcion,
                    id: this.producto.id}).then();
            },
            guardarFecha()
            {
                this.editrfecha = false;
                axios.post('/editarProducto', {tipo: 'Fecha', valor: this.producto.fecha_fin,
                    id: this.producto.id}).then();
            },
            guardarNegocio()
            {
                this.editarneg = false;
                axios.post('/editarProducto', {tipo: 'Negocio', valor: this.producto.negocio_id,
                    id: this.producto.id}).then();
            },
            guardarCategoria()
            {
                this.editrcategoria = false;
                axios.post('/editarProducto', {tipo: 'Categoria', valor: this.producto.categoria_id,
                    id: this.producto.id}).then();
            },
            guardarFoto()
            {
                this.editrfoto = false;
                axios.post('/editarProducto', {tipo: 'Foto', valor: this.path,
                    id: this.producto.id}).then();
            },
            guardarCantidadMinima(){
                this.editrcant_min = false;
                axios.post('/editarProducto', {tipo: 'cant_minimo', valor: this.producto.cant_minimo,
                    id: this.producto.id}).then();
            },

            establecerFoto1(e) {
                let file = e.target.files[0];
                let reader = new FileReader();

                reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                    this.path.push(reader.result);
                }
                reader.readAsDataURL(file);
            },
        },
}
</script>
