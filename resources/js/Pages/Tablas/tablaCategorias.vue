<template>
    <tr>
        <td>
            <p> {{key}}</p>
        </td>
        <td>
            <img v-if="editrPath == false" @dblclick="editarPath()" :src="'/fotos/' + cat.path" style="width: 100px;">
            <div class="row" v-show="editrPath == true">
                <img v-for="imagen in path" style="width: 250px" :src="imagen" class="img-thumbnail">
            </div>
            <input v-show="editrPath == true" type="file" @change="establecerFoto1"/>
            <button v-show="editrPath == true" class="btn btn-success" style="width: 70%; margin-left: 15%; background-color: black" @click="guardarFoto">Guardar Foto</button>

        </td>
        <td>
            <p v-if="editrNombre == false" @dblclick="editarNombre()">  {{cat.nombre}}</p>
            <input ref="cellinput" type="text" v-show="editrNombre == true"
                   v-model="cat.nombre"
                   @keyup.enter="guardarNombre">
        </td>
        <td>
            <p v-if="editrcat == false " @dblclick="editarCategoria()">{{cat.nomPadre}}</p><br>
            <select v-show="editrcat == true" style="width: 60%; margin-right: 2%; margin-left: 2%; float: left" class="form-control" v-model="cat.padre_id" >
                <option v-for="cat in categorias" :value="cat.id">{{cat.nombre}}</option>
            </select>
            <button  v-show="editrcat == true" class="btn btn-success" style="background-color: black" @click="guardarCategoria">Guardar CatPadre</button>
        </td>
    </tr>
</template>

<script>
export default {
    name: "tablaCategorias",
    props: ['cat','categorias', 'key'],
    data()
    {
        return{
            editrNombre: false,
            editrcat: false,
            editrPath: false,
            path: []
        }
    },
    watch: {
        producto: {
            handler: function(newValue) {
                console.log("Person with ID:" + newValue.id + " modified")
                console.log("New age: " + newValue.age)
            },
            deep: true
        }
    },
    methods:
        {
            borrarCliente(id)
            {
                axios.post('/borrarCliente/' + id).then(()=>{});
            },
            editarNombre()
            {
                this.editrNombre = true;
            },
            editarCategoria()
            {
                this.editrcat = true;
            },
            editarPath()
            {
                this.editrPath = true;
            },
            guardarNombre()
            {
                this.editrNombre = false;
                axios.post('/editarCategoria', {tipo: 'Nombre', valor: this.cat.nombre,
                    id: this.cat.id}).then();
                alert('Has modificado '+ this.cat.nombre);
            },
            guardarCategoria()
            {
                this.editrNombre = false;
                axios.post('/editarCategoria', {tipo: 'Padre', valor: this.cat.padre_id,
                    id: this.cat.id}).then();
                alert('Has modificado '+ this.cat.nombre);
            },
            guardarFoto()
            {
                this.editrPath = false;
                axios.post('/editarCategoria', {tipo: 'Foto', valor: this.path,
                    id: this.cat.id}).then();
                alert('Has modificado '+ this.cat.nombre);
                this.path = [];

            },
            establecerFoto1(e) {
                let file = e.target.files[0];
                let reader = new FileReader();

                reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                    this.path.push(reader.result);
                }
                reader.readAsDataURL(file);
            },
        }
}
</script>

<style scoped>

</style>
