<template>
    <tr>
        <td>
            <p> {{key}}</p>
        </td>
        <td>
            <p> {{pre.nombre}}</p>
        </td>
        <td>
            <p>${{pre.precio_max}}</p>
        </td>
        <td>
            <p v-if="editrPorcentaje == false" @dblclick="editarPorcentaje()">  {{pre.porcentaje}}</p>
            <input ref="cellinput" type="text" v-show="editrPorcentaje == true"
                   v-model="pre.porcentaje"
                   @keyup.enter="guardarPorcentaje">
        </td>
        <td>
            <p v-if="editrDias == false" @dblclick="editarDias()">  {{pre.dias}}</p>
            <input ref="cellinput" type="text" v-show="editrDias == true"
                   v-model="pre.dias"
                   @keyup.enter="guardarDias">
        </td>
        <td>
            <p> {{pre.dias_restantes}}</p>
        </td>
        <td>
            <p>{{pre.veces}}</p>
        </td>
    </tr>
</template>

<script>

export default {
    name: "tablaPrecios",
    props: ['pre', 'key'],
    data()
    {
        return{
            editrPorcentaje: false,
            editrDias: false,
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
            editarPorcentaje()
            {
                this.editrPorcentaje = true;
            },
            editarDias()
            {
                this.editrDias = true;
            },
            guardarPorcentaje()
            {
                this.editrPorcentaje = false;
                axios.post('/editarPrecio', {tipo: 'Porcentaje', valor: this.pre.porcentaje,
                    id: this.pre.id}).then();
                alert('Has modificado '+ this.pre.nombre)
            },
            guardarDias()
            {
                this.editrDias = false;
                axios.post('/editarPrecio', {tipo: 'Dias', valor: this.pre.dias,
                    id: this.pre.id}).then();
                alert('Has modificado '+ this.pre.nombre)
            },
        }
}
</script>

<style scoped>

</style>
