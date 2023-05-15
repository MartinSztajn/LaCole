<template>
    <tr>
        <td>
            <p> {{key}}</p>
        </td>
        <td>
            <p v-if="editrNombre == false" @dblclick="editarNombre()">  {{pro.nombre}}</p>
            <input ref="cellinput" type="text" v-show="editrNombre == true"
                   v-model="pro.nombre"
                   @keyup.enter="guardarNombre">
        </td>
        <td>
            <p v-if="editrPrecio == false" @dblclick="editarPrecio()">  {{pro.precio}}</p>
            <input ref="cellinput" type="text" v-show="editrPrecio == true"
                   v-model="pro.precio"
                   @keyup.enter="guardarPrecio">
        </td>
    </tr>
</template>

<script>

export default {
    name: "tablaProvincias",
    props: ['pro', 'key'],
    data()
    {
        return{
            editrNombre: false,
            editrPrecio: false,
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
            editarPrecio()
            {
                this.editrPrecio = true;
            },
            guardarNombre()
            {
                this.editrNombre = false;
                axios.post('/editarProvincia', {tipo: 'Nombre', valor: this.pro.nombre,
                    id: this.pro.id}).then();
                alert('Has modificado '+ this.pro.nombre)
            },
            guardarPrecio()
            {
                this.editrPrecio = false;
                axios.post('/editarProvincia', {tipo: 'Precio', valor: this.pro.precio,
                    id: this.pro.id}).then();
                alert('Has modificado '+ this.pro.nombre)
            },
        }
}
</script>

<style scoped>

</style>
