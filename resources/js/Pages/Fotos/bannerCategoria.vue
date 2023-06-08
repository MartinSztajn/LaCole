<template>
    <app-layout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Banner Categorias Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Foto</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ban, key) in fotosBannerCategoria">
                                <td>{{key + 1}}</td>
                                <td><img :src="'/fotos/' + ban.path" style="width: 200px"></td>
                                <td>
                                    <button v-if="ban.activo == 0" class="btn btn-success" style="background-color: green" @click="activarBannerCategoria(ban.id)">Activar</button>
                                    <button v-if="ban.activo == 1" class="btn btn-success" style="background-color: red" @click="desactivarBannerCategoria(ban.id)">Desactivar</button>
                                </td>
                                <td>
                                    <button type="submit" v-if="id != ban.id"  class="btn" @click="deseaEliminarCategoria(ban.id)"  style="width: 100%; background-color: #FF9292">Eliminar</button>
                                    <button type="submit" v-if="id == ban.id" class="btn" @click="borrarBannerCategoria(ban.id)"  style="width: 100%; background-color: red">Confirmar</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-bottom: 5%">
                    <div style="margin-left: 20px">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Imagenes:</h2>
                        <div class="row">
                            <img v-for="imagen in form.path" style="width: 250px" :src="imagen" class="img-thumbnail">
                        </div>
                        <input type="file" @change="establecerFoto1"/>
                    </div>
                    <br>
                    <h2 style="margin: 20px">Categoria:</h2>
                    <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.categoria_id">
                        <option v-for="cat in categorias" :value="cat.id">{{cat.nombre}}</option>
                    </select>
                    <br>
                    <button class="btn btn-success" style="width: 70%; margin-left: 15%; background-color: black" @click="guardarBannerCategoria">Guardar Banner</button>
                    <h2 v-if="this.listo == 1" style="text-align: center; color: darkgreen"> Se Creo exitosamente el Banner </h2>
                </div>
            </div>
        </div>
    </app-layout>
</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue'
export default {
    name: "bannerCategoria",
    props: ['fotosBannerCategoria', 'categorias'],
    components: {
        AppLayout,
    },
    data()
    {
        return{
            listo: 0,
            id: '',
            form:{
                path: [],
                categoria_id: ''
            }
        }
    },
    methods:
        {
            deseaEliminarCategoria($id){
                this.id = $id;
            },
            borrarBannerCategoria($id)
            {
                this.$inertia.post('/borrarBannerCategoria/' + $id);
            },
            guardarBannerCategoria()
            {
                if(this.form.categoria_id != '' && this.form.path != '')
                {
                    this.$inertia.post('/guardarBannerCategoria', this.form);
                }
            },
            activarBannerCategoria($id)
            {
                this.$inertia.post('/activarBannerCategoria/' + $id);
            },
            desactivarBannerCategoria($id){
                this.$inertia.post('/desactivarBannerCategoria/' + $id);
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
