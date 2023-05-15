<template>
    <tr>
        <td>
            <p> {{key}}</p>
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
            guardarNombre()
            {
                this.editrNombre = false;
                axios.post('/editarCategoria', {tipo: 'Nombre', valor: this.cat.nombre,
                    id: this.cat.id}).then();
                alert('Has modificado '+ this.cat.nombre)
            },
            guardarCategoria()
            {
                this.editrNombre = false;
                axios.post('/editarCategoria', {tipo: 'Padre', valor: this.cat.padre_id,
                    id: this.cat.id}).then();
                alert('Has modificado '+ this.cat.nombre)
            },
        }
}
</script>

<style scoped>

</style>
