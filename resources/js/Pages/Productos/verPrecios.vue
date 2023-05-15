<template>
    <app-layout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%; padding-bottom: 3%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Aumentar Todos los productos</h1>
                        <input style="width: 60%; margin-right: 2%; margin-left: 2%; float: left" type="number" class="form-control" v-model="cantidad" placeholder="Escribir solo el porcentaje (sin el %) = XX">
                        <button style="width: 30%;"  class="btn btn-success" @click="actualizarTodosPrecios">Actualizar Precios</button>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Precios Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Producto</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Porcenetaje</th>
                                <th scope="col">Dias</th>
                                <th scope="col">Dias restantes</th>
                                <th scope="col">Veces Aumentado</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tabla-precios v-for="(pre, key) in precios"  v-bind:pre="pre"  v-bind:key="key">
                                </tabla-precios>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-bottom: 5%">
                    <h2 style="margin: 20px">Producto:</h2>
                    <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.producto_id">
                        <option v-for="pro in productos" :value="pro.id">{{pro.nombre}}</option>
                    </select>
                    <br>
                    <h2 style="margin: 20px">Porcentaje de Aumento:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="number" class="form-control" v-model="form.porcentaje" >
                    <br>
                    <h2 style="margin: 20px">Cantidad de Dias:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="number" class="form-control" v-model="form.dias" >
                    <br>
                    <button class="btn btn-success" @click="guardarPrecioProducto">Guardar Precio</button>
                    <h2 v-if="this.listo == 1" style="text-align: center; color: darkgreen"> Se Creo exitosamente el precio </h2>
                </div>
            </div>

        </div>

    </app-layout>

</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import TablaPrecios from "../Tablas/tablaPrecios.vue";



export default {
    name: "verPrecios",
    props: ['productos','precios'],
    components: {
        TablaPrecios,
        AppLayout,
    },
    data()
    {
        return{
            listo: 0,
            cantidad: '',
            form:{
                producto_id:'',
                dias: '',
                porcentaje: ''
            }
        }
    },
    methods:
        {
            borrarProvincia($id)
            {
                this.$inertia.post('/borrarProvincia/' + $id);
            },
            guardarPrecioProducto()
            {
                if(this.listo == 0)
                {
                    this.listo = 1;
                    this.$inertia.post('/guardarPrecioProducto', this.form);
                }
            },
            actualizarTodosPrecios(){
                if(this.cantidad != ''){
                    this.$inertia.post('/actualizarTodosPrecios/' + this.cantidad);
                }
            }
        }
}
</script>
