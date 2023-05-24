<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <h1 style="text-align: center; font-size: 25px">Cosultas</h1>
                <div style="margin-bottom: 5%; margin-top: 2%">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Mail</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Mensaje</th>
                            <th scope="col"></th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(con, key) in consultas">
                            <td>{{key + 1}}</td>
                            <td>{{con.nombre}} {{con.apellido}}</td>
                            <td>{{con.email}}</td>
                            <td>{{(con.numero)}}</td>
                            <td>{{(con.mensaje)}}</td>
                            <td>
                                <button type="submit" v-if="id != con.id"  class="btn" @click="deseaEliminar(con.id)"  style="width: 100%; background-color: #FF9292">Eliminar</button>
                                <button type="submit" v-if="id == con.id" class="btn" @click="eliminarConsulta(con.id)"  style="width: 100%; background-color: red">Confirmar</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </app-layout>

</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    name: "Index",
    props: ['consultas'],
    components: {

        AppLayout,
    },
    data()
    {
        return{
            id:'',
            listo: 0,
            form:{
            }
        }
    },
    methods:
        {
            deseaEliminar($id){
                this.id = $id;
            },
            eliminarConsulta($id){
                this.$inertia.post('/eliminarConsulta/' + $id);
            },
        }

}
</script>
<style>
.botones{
    float: left; margin-left: 5%; width: 40%; margin-right: 5%;
    background-color: #00b3ee;
    text-align: center;
    font-size: 25px;
    margin-bottom: 5%;
    height: 100px;
    border-radius: 25px;
}
</style>
