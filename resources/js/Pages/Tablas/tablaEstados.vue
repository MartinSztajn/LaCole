<template>
    <tr>
        <td>
            <p> {{key}}</p>
        </td>
        <td>
            <p v-if="editrNombre == false" @dblclick="editarNombre()">  {{est.nombre}}</p>
            <input ref="cellinput" type="text" v-show="editrNombre == true"
                   v-model="est.nombre"
                   @keyup.enter="guardarNombre">
        </td>
    </tr>
</template>

<script>
export default {
    name: "tablaEstados",
    props: ['est', 'key'],
    data()
    {
        return{
            editrNombre: false,
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
            guardarNombre()
            {
                this.editrNombre = false;
                axios.post('/editarEstado', {tipo: 'Nombre', valor: this.est.nombre,
                    id: this.est.id}).then();
                alert('Has modificado '+ this.est.nombre)
            },
        }
}
</script>

<style scoped>

</style>
