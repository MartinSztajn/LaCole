<template>
    <app-layout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Provincias Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tabla-provincias v-for="(pro, key) in provincias"  v-bind:pro="pro"  v-bind:key="key">
                                </tabla-provincias>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-bottom: 5%">
                    <h2 style="margin: 20px">Nombre Provincia:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                    <br>
                    <h2 style="margin: 20px">Precio:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="number"   class="form-control" v-model="form.precio" >
                    <br>
                    <button class="btn btn-success" @click="guardarProvincia">Guardar Provincia</button>
                    <h2 v-if="this.listo == 1" style="text-align: center; color: darkgreen"> Se Creo exitosamente la Provincia </h2>

                </div>
            </div>

        </div>

    </app-layout>

</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import tablaProvincias from '../Tablas/tablaProvincias.vue';


export default {
    name: "index",
    props: ['provincias'],
    components: {
        AppLayout,
        tablaProvincias
    },
    data()
    {
        return{
            listo: 0,
            form:{
                nombre:'',
                precio: ''
            }
        }
    },
    methods:
        {
            borrarProvincia($id)
            {
                this.$inertia.post('/borrarProvincia/' + $id);
            },
            guardarProvincia()
            {
                if(this.listo == 0)
                {
                    this.listo = 1;
                    this.$inertia.post('/guardarProvincia', this.form);
                }
            },
        }
}
</script>
