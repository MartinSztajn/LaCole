<template>
    <app-layout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Colores Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Color</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tabla-colores v-for="(col, key) in colores"  v-bind:col="col"  v-bind:key="key">
                            </tabla-colores>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-bottom: 5%">
                    <h2 style="margin: 20px">Nombre Color:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                    <br>
                    <h2 style="margin: 20px">Color:</h2>

                    <input type="color" v-model="form.color" class="form-control">

                    <button class="btn btn-success" @click="guardarColor">Guardar Color</button>
                </div>
            </div>

        </div>

    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import tablaColores from '../Tablas/tablaColores.vue';


export default {
    name: "coloresProducto",
    props: ['colores'],
    components: {
        AppLayout,
        tablaColores
    },
    data()
    {
        return{
            form:{
                nombre:'',
                color: ''
            }
        }
    },
    methods:
        {
            borrarEstado($id)
            {
                this.$inertia.post('/borrarEstadoProducto/' + $id);
            },
            guardarColor()
            {
                if (this.form.nombre != '' && this.form.color != '') {
                    this.$inertia.post('/guardarColorProducto', this.form);
                }
            },
        }
}
</script>


<style scoped>

</style>
