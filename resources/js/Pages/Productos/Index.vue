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
                                <th scope="col">Nombre</th>
                                <th scope="col">Negocio</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Precio Max.</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Fecha Fin</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Habilato</th>
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
                                <td>{{pro.nombre}}</td>
                                <td>{{pro.nomNeg}}</td>
                                <td>{{pro.nomCat}}</td>
                                <td>{{pro.nomEstado}}</td>
                                <td>{{pro.precio_max}}</td>
                                <td>{{pro.cantidad}}</td>
                                <td>{{pro.fecha_fin}}</td>
                                <td>{{pro.descripcion}}</td>
                                <td v-if="pro.estado == 0"><button @click="habilitarProducto(pro.id)" class="btn btn-primary" style="background-color: red">No Aceptado</button></td>
                                <td v-if="pro.estado == 1"><button @click="habilitarProducto(pro.id)" class="btn btn-primary" style="background-color: green">Aceptado</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-bottom: 5%">
                    <h2 style="margin: 20px">Nombre Producto:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                    <br>
                    <h2 style="margin: 20px">Negocio:</h2>
                    <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.negocio_id">
                        <option v-for="neg in negocios" :value="neg.id">{{neg.nombre}}</option>
                    </select>
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
    props: ['productos','negocios','categorias','estados'],
    components: {
        AppLayout,
    },
    data()
    {
        return{
            id:'',
            listo: 0,
            form:{
                nombre:'',
                negocio_id:'',
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
            guardarProducto()
            {
                if(this.listo == 0 && this.form.nombre  != '' && this.form.categoria_id  != ''  && this.form.estado_id != '' && this.form.precio_max  != '' && this.form.fecha_fin  != '' && this.form.descripcion  != '' && this.form.cantidad  != '' && this.form.cant_min  != '' && this.form.path  != '')
                {
                    if(this.form.cantidad > this.form.cant_min) {
                        this.listo = 1;
                        this.$inertia.post('/guardarProducto', this.form);
                    }
                }
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
