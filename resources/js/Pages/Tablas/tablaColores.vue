<template>
    <tr>
        <td>
            <p> {{key}}</p>
        </td>
        <td>
            <p v-if="editrNombre == false" @dblclick="editarNombre()">  {{col.nombre}}</p>
            <input ref="cellinput" type="text" v-show="editrNombre == true"
                   v-model="col.nombre"
                   @keyup.enter="guardarNombre">
        </td>
        <td>
            <div v-if="editrColor == false" @dblclick="editarColor()" class="rounded-circle" :style="'width: 50px; height: 50px; background-color:' + col.color"></div>
            <input type="color" v-model="col.color" class="form-control" v-show="editrColor == true"   @keyup.enter="guardarColor">

        </td>
    </tr>
</template>

<script>
export default {
    name: "tablaColores",
    props: ['col', 'key'],
    data()
    {
        return{
            editrNombre: false,
            editrColor: false,

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
            editarNombre()
            {
                this.editrNombre = true;
            },
            editarColor()
            {
                this.editrColor = true;
            },
            guardarNombre()
            {
                this.editrNombre = false;
                axios.post('/editarColor', {tipo: 'Nombre', valor: this.col.nombre,
                    id: this.col.id}).then();
                alert('Has modificado '+ this.col.nombre)
            },
            guardarColor()
            {
                this.editrColor = false;
                axios.post('/editarColor', {tipo: 'Color', valor: this.col.color,
                    id: this.col.id}).then();
                alert('Has modificado '+ this.col.nombre)
            },
        }
}
</script>

<style scoped>

</style>
