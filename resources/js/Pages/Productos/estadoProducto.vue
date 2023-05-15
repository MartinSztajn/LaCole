<template>
    <app-layout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Estados Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tabla-estados v-for="(est, key) in estados"  v-bind:est="est"  v-bind:key="key">
                                </tabla-estados>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-bottom: 5%">
                    <h2 style="margin: 20px">Nombre Estado:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                    <br>
                    <button class="btn btn-success" @click="guardarEstado">Guardar Estado</button>
                    <h2 v-if="this.listo == 1" style="text-align: center; color: darkgreen"> Se Creo exitosamente el Estado </h2>

                </div>
            </div>

        </div>

    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import tablaEstados from '../Tablas/tablaEstados.vue';


export default {
    name: "estadoProducto",
    props: ['estados'],
    components: {
        AppLayout,
        tablaEstados
    },
    data()
    {
        return{
            listo: 0,
            form:{
                nombre:'',
            }
        }
    },
    methods:
        {
            borrarEstado($id)
            {
                this.$inertia.post('/borrarEstadoProducto/' + $id);
            },
            guardarEstado()
            {
                if(this.listo == 0)
                {
                    this.listo = 1;
                    this.$inertia.post('/guardarEstadoProducto', this.form);
                }
            },
        }
}
</script>


<style scoped>

</style>
