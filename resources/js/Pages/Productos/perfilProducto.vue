<template>
        <div>
            <h1 v-if="editrnombre == false " @dblclick="editarNombre()" style="text-align: center; position: center; font-size: 100px; margin-top: 3%">{{producto.nombre}}</h1>
            <input ref="cellinput" type="text" v-show="editrnombre == true" v-model="producto.nombre" style="text-align: center; position: center; font-size: 100px; margin-top: 3%; margin-left: 10%" @keyup.enter="guardarNombre">


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="padding: 50px; margin: 3%">

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
                <input ref="cellinput" type="text" v-show="editrprecio == true" v-model="producto.precio" style="font-size: 40px; margin-bottom: 2%; text-align: center; position: center" @keyup.enter="guardarPrecio">
                <br>
                <h1 v-if="editrcant_min == false " @dblclick="editarCantidadMinima()"  style="font-size: 20px;"><b>Cantidad Minimo: {{producto.cant_minimo}}</b></h1>
                <input ref="cellinput" type="text" v-show="editrcant_min == true" v-model="producto.cant_minimo" style="font-size: 40px; margin-bottom: 2%; text-align: center; position: center" @keyup.enter="guardarCantidadMinima">
                <br>
                <h1 v-if="editrcantidad == false " @dblclick="editarCantidad()"  style="font-size: 20px;"><b>Stock: {{producto.stock}}</b></h1>
                <input ref="cellinput" type="text" v-show="editrcantidad == true" v-model="producto.stock" style="font-size: 20px;" @keyup.enter="guardarCantidad">
                <br>
                <h1 v-if="editrdesc == false " @dblclick="editarDesc()" style="font-size: 20px; "><b>Descripcion:</b> {{producto.descripcion}}</h1>
                <input ref="cellinput" type="text" v-show="editrdesc == true" v-model="producto.descripcion" style="font-size: 20px;" @keyup.enter="guardarDesc">
                <br>
                <p v-if="editrestado == false " @dblclick="editarEstado()" class="card-text" style="font-size: 20px"><b>Estado:</b> {{producto.nomEstado}}</p><br>
                <select v-show="editrestado == true" style="width: 60%; margin-right: 2%; margin-left: 2%; float: left" class="form-control" v-model="producto.estado_id">
                    <option v-for="est in estados" :value="est.id">{{est.nombre}}</option>
                </select>
                <button  v-show="editrestado == true" class="btn btn-success" style="background-color: black" @click="guardarEstado">Guardar Estado</button>
                <br>
                <p v-if="editrcolor == false " @dblclick="editarColor()" class="card-text" style="font-size: 20px"><b>Color:</b> {{producto.nomColor}}</p><br>
                <select v-show="editrcolor == true" style="width: 60%; margin-right: 2%; margin-left: 2%; float: left" class="form-control" v-model="producto.color_id" >
                    <option v-for="col in colores" :value="col.id">{{col.nombre}}</option>
                </select>
                <button  v-show="editrcolor == true" class="btn btn-success" style="background-color: black" @click="guardarColor">Guardar Estado</button>
                <br>
                <p v-if="editrcat == false " @dblclick="editarCategoria()" class="card-text" style="font-size: 20px"><b>Categoria:</b> {{producto.nomCat}}</p><br>
                <select v-show="editrcat == true" style="width: 60%; margin-right: 2%; margin-left: 2%; float: left" class="form-control" v-model="producto.categoria_id" @keyup.enter="guardarCategoria">
                    <option v-for="cat in categorias" :value="cat.id">{{cat.nombre}}</option>
                </select>
                <button  v-show="editrcat == true" class="btn btn-success" style="background-color: black" @click="guardarCategoria">Guardar Categoria</button>
            </div>
        </div>
</template>
<script>

export default {
    name: "perfilProducto",
    props: ['producto', 'negocios', 'categorias','colores','estados'],
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
        },
}
</script>
