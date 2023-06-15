<template>
    <app-layout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Productos Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Celular</th>

                                <th scope="col">Producto</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Habilato</th>
                                <th scope="col">Eliminar</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="pro in productos">
                                <td>
                                    <button @click="verPerfilProducto(pro.id)" class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-arrow-up-square-fill" viewBox="0 0 16 16">
                                        <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0z"/>
                                        </svg>
                                    </button>
                                </td>
                                <td>{{pro.usuario.name}}</td>
                                <td>{{pro.usuario.numero}}</td>

                                <td>{{pro.nombre}}</td>
                                <td>{{pro.nomCat}}</td>
                                <td>${{pro.precio}}</td>
                                <td>
                                    <button  v-if="pro.estado == 0" @click="habilitarProducto(pro.id)" class="btn btn-primary" style="background-color: red">No Aceptado</button>
                                    <button v-if="pro.estado == 1" @click="habilitarProducto(pro.id)" class="btn btn-primary" style="background-color: green">Aceptado</button>
                                </td>
                                <td>
                                   <button type="submit" v-if="idProdu != pro.id"  class="btn" @click="deseaEliminarProdu(pro.id)"  style="width: 100%; background-color: #FF9292">Eliminar</button>
                                   <button type="submit" v-if="idProdu == pro.id" class="btn" @click="eliminarProducto(pro.id)"  style="width: 100%; background-color: red">Confirmar</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-bottom: 5%">
                    <h2 style="margin: 20px">Nombre Producto:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                    <br>
                    <h2 style="margin: 20px">Categoria:</h2>
                    <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.categoria_id">
                        <option v-for="cat in categorias" :value="cat.id">{{cat.nombre}}</option>
                    </select>
                    <br>
                    <h2 style="margin: 20px">Estados:</h2>
                    <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.estado_id">
                        <option v-for="est in estados" :value="est.id">{{est.nombre}}</option>
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
                    <h2 style="margin: 20px">Color:</h2>
                    <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.color">
                        <option v-for="col in colores" :value="col.id">
                            <div class="rounded-circle" :style="'width: 50px; height: 50px; background-color:' + col.color">
                                {{col.nombre}}
                            </div>
                        </option>
                    </select>
                    <h2 style="margin: 20px">Descripcion:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.descripcion" >
                    <br>
                    <div  style="margin: 20px">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Imagenes:</h2>
                        <p style="margin-bottom: 20px">Se puede seleccionar mas de una</p>
                        <div class="row">
                            <img v-for="imagen in form.path" style="width: 250px" :src="imagen" class="img-thumbnail">
                        </div>
                        <input type="file" @change="establecerFoto1"/>
                    </div>
                    <button class="btn btn-success" @click="guardarProducto" style="margin-left: 5%; width: 90%; margin-top: 5%; background-color: black">Guardar Producto</button>
                    <h2 v-if="this.listo == 1" style="text-align: center; color: darkgreen"> Se Creo exitosamente el Producto </h2>

                </div>
            </div>

        </div>

    </app-layout>

</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue'


export default {
    name: "index",
    props: ['productos','negocios','categorias','estados','colores'],
    components: {
        AppLayout,
    },
    data()
    {
        return{
            id:'',
            idProdu: '',
            listo: 0,
            form:{
                nombre:'',
                categoria_id:'',
                estado_id: '',
                precio:'',
                descripcion:'',
                color:'',
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
            guardarProducto()
            {
                if(this.form.nombre  != '' && this.form.categoria_id  != ''  && this.form.estado_id != '' && this.form.precio  != '' && this.form.descripcion  != '' && this.form.stock  != '' && this.form.cant_minimo  != '' && this.form.color  != '' && this.form.path  != '')
                {
                    if(this.form.stock > this.form.cant_minimo) {
                        this.$inertia.post('/guardarProducto', this.form);
                    }
                }
            },
            deseaEliminarProdu($id){
                this.idProdu = $id;
            },
            eliminarProducto($id){
                this.$inertia.post('/borrarProducto/' + $id);
            },
            habilitarProducto($id){
                this.$inertia.post('/habilitarProducto/' + $id);
            },
            verPerfilProducto($id){
                this.$inertia.get('/verPerfilProducto/' + $id);
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
        }
}
</script>
