<template>
    <app-layout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Banner Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Url</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ban, key) in fotosBanner">
                                <td>{{key + 1}}</td>
                                <td>{{ban.nombre}}</td>
                                <td><img :src="'/fotos/' + ban.path"></td>
                                <td>{{ban.url}}</td>
                                <td>
                                    <button v-if="ban.activo == 0" class="btn btn-success" style="background-color: green" @click="activarBanner(ban.id)">Activar</button>
                                    <button v-if="ban.activo == 1" class="btn btn-success" style="background-color: red" @click="desactivarBanner(ban.id)">Desactivar</button>
                                </td>
                                <td>
                                    <button type="submit" v-if="id != ban.id"  class="btn" @click="deseaEliminar(ban.id)"  style="width: 100%; background-color: #FF9292">Eliminar</button>
                                    <button type="submit" v-if="id == ban.id" class="btn" @click="borrarBanner(ban.id)"  style="width: 100%; background-color: red">Confirmar</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-bottom: 5%">
                    <h2 style="margin: 20px">Nombre Banner:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                    <br>
                    <div style="margin-left: 20px">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Imagenes:</h2>
                        <p style="margin-bottom: 20px">Se puede seleccionar mas de una</p>
                        <div class="row">
                            <img v-for="imagen in form.path" style="width: 250px" :src="imagen" class="img-thumbnail">
                        </div>
                        <input type="file" @change="establecerFoto1"/>
                    </div>
                    <br>
                    <h2 style="margin: 20px">Url:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.url" placeholder="www.ejemplo.com" >
                    <br>
                    <button class="btn btn-success" style="width: 70%; margin-left: 15%; background-color: black" @click="guardarBanner">Guardar Banner</button>
                    <h2 v-if="this.listo == 1" style="text-align: center; color: darkgreen"> Se Creo exitosamente el Banner </h2>
                </div>
            </div>
        </div>
    </app-layout>
</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue'
export default {
    name: "banner",
    props: ['fotosBanner'],
    components: {
        AppLayout,
    },
    data()
    {
        return{
            listo: 0,
            id: '',
            form:{
                nombre:'',
                path: [],
                url: ''
            }
        }
    },
    methods:
        {
            deseaEliminar($id){
                this.id = $id;
            },
            borrarBanner($id)
            {
                this.$inertia.post('/borrarBanner/' + $id);
            },
            guardarBanner()
            {
                if(this.form.nombre != '' && this.form.path != ''  && this.form.url != '' )
                {
                    this.$inertia.post('/guardarBanner', this.form);
                }
            },
            activarBanner($id)
            {
                    this.$inertia.post('/activarBanner/' + $id);
             },
            desactivarBanner($id){
                    this.$inertia.post('/desactivarBanner/' + $id);
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
