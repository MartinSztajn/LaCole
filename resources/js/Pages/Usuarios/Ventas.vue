<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                  <h1 style="margin: 20px; text-align: center; font-size: 40px">Ventas</h1>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Negocio</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Precio Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Provincia</th>
                        <th scope="col">Precio Prov.</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(ven, key) in ventas">
                        <td>{{key + 1}}</td>
                        <td>{{ven.negNom}}</td>
                        <td>{{ven.cliNombre}}</td>
                        <td>{{ven.cliMail}}</td>
                        <td>{{ven.prodNombre}}</td>
                        <td>{{ven.prodPrecio}}</td>
                        <td>{{ven.cantidad}}</td>
                        <td>{{ven.cliProvNom}}</td>
                        <td>{{ven.cliProvPre}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </app-layout>

</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue'
export default {
    name: "ventas",
    props: ['ventas'],
    components: {
        AppLayout,
    },
    data()
    {
        return{
            btnActivado: 0,
            btnVentas: 0,
            listo: 0,
        }
    },
    methods:
        {

        }
}
</script>
