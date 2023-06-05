<template>
    <app-layout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Categorias Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Foto</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Padre</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tabla-categorias v-for="(cat, index) in categorias"  v-bind:cat="cat"  v-bind:categorias="categorias"  v-bind:key="index">
                                </tabla-categorias>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="margin-bottom: 5%">
                    <h2 style="margin: 20px">Nombre Categoria:</h2>
                    <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                    <br>
                    <h2 style="margin: 20px">Categoria Padre:</h2>
                    <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.padre_id">
                        <option disabled>Seleccionar si es una subcategoria</option>
                        <option  v-for="cat in categorias" :value="cat.id">{{cat.nombre}}</option>
                    </select>
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
                    <button class="btn btn-success" style="width: 70%; margin-left: 15%; background-color: black" @click="guardarCategoria">Guardar Categoria</button>
                    <h2 v-if="this.listo == 1" style="text-align: center; color: darkgreen"> Se Creo exitosamente la Categoria </h2>

                </div>
            </div>

        </div>

    </app-layout>

</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import tablaCategorias from '../Tablas/tablaCategorias.vue';


export default {
    name: "index",
    props: ['categorias'],
    components: {
        AppLayout,
        tablaCategorias
    },
    data()
    {
        return{
            listo: 0,
            form:{
                nombre:'',
                path: [],
                padre_id:''
            }
        }
    },
    methods:
        {
            borrarCategoria($id)
            {
                this.$inertia.post('/borrarCategoria/' + $id);
            },
            guardarCategoria()
            {
                if(this.listo == 0)
                {
                    this.listo = 1;
                    this.$inertia.post('/guardarCategoria', this.form);
                }
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
