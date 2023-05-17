<template>
    <app-layout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Negocios Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="neg in negocios">
                                <td>{{neg.id}}</td>
                                <td>
                                    <a :href="'/verNegocioDetalle/' + neg.id ">
                                        <button  class="btn">{{neg.nombre}}</button>
                                    </a>
                                </td>
                                <td>
                                    <button type="submit"  v-if="id != neg.id" class="btn" @click="deseaEliminar(neg.id)"  style="background-color: #FF9292">Borrar {{neg.nombre}}</button>
                                    <button type="submit"  v-if="id == neg.id" class="btn" @click="borrarNegocio(neg.id)"  style="background-color: red">Confirmar</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-bottom: 5%">
                    <h2 style="margin: 20px">Nombre Negocio:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                    <br>
                    <h2 style="margin: 20px">Usuarios:</h2>
                    <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.id_usuarios" multiple>
                        <option v-for="usu in usuarios" :value="usu.id">{{usu.name}}</option>
                    </select>
                    <br>
                    <button class="btn btn-success" @click="guardarNegocio">Guardar Negocio</button>
                    <h2 v-if="this.listo == 1" style="text-align: center; color: darkgreen"> Se Creo exitosamente el Negocio </h2>

                </div>
            </div>

        </div>

    </app-layout>

</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
export default {
    name: "index",
    props: ['negocios','usuarios'],
    components: {
        AppLayout,
    },
    data()
    {
        return{
            listo: 0,
            id:'',
            form:{
                nombre:'',
                id_usuarios:[],
            }
        }
    },
    methods:
        {

            deseaEliminar($id){
                this.id = $id;
            },
            verNegocioDetalle($id){
                alert($id);
                this.$inertia.get('/verNegocioDetalle/' + $id);
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
        }
}
</script>
