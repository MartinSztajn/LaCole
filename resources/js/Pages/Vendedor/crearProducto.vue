<template>
    <cliente-layout>
        <div class="altura" style="background-color: #121212;"></div>

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img v-if="fotosBanner[num]" class="d-block w-100"  :src="'/fotos/' + fotosBanner[num].path" style="width: 100%" alt="First slide">
                </div>
            </div>
            <a class="carousel-control-prev compu" @click="moverIzq()" role="button" data-slide="prev">
                <svg xmlns="http://www.w3.org/2000/svg"  width="50" height="50" fill="black" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                    <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z"/>
                </svg>
            </a>
            <a class="carousel-control-next compu" @click="moverDer()" role="button" data-slide="next">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                    <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z"/>
                </svg>
            </a>
        </div>

        <div class="py-12" v-if="user.aceptado == 1">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin: 5%; padding: 2%; width: 90%;">
                    <div>
                        <h2 style="margin: 20px">Nombre Producto:</h2>
                        <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="text"   class="form-control" v-model="form.nombre" >
                        <br>
                        <h2 style="margin: 20px">Categoria:</h2>
                        <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.categoria_id">
                            <option v-for="cat in categorias" :value="cat.id">{{cat.nombre}}</option>
                        </select>
                        <br>
                        <h2 style="margin: 20px">Estado:</h2>
                        <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="form.estado_id">
                            <option v-for="est in estados" :value="est.id">{{est.nombre}}</option>
                        </select>
                        <br>
                        <h2 style="margin: 20px">Color (Puede seleccionar más de uno):</h2>
                        <div style="display: flex; flex-wrap: wrap;">
                            <div v-for="(color, index) in form.color_id" :key="index" style="margin: 2%; text-align: center;">
                                <div class="rounded-circle" :style="'width: 60px; height: 60px; margin-bottom: 5%; border: 2px solid black; background-color:' + color.color"></div>
                                <h1 style="font-size: 15px; margin-bottom: 5%;">{{color.nombre}}</h1>

                                <button class="btn" style="background-color: red;" @click="eliminarColor(index)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                        <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <select style="width: 95%; margin-right: 2%; margin-left: 2%" class="form-control" v-model="color" @change="establecerColores">
                            <option v-for="col in colores" :value="col">{{col.nombre}}</option>
                        </select>
                        <br>
                        <h2 style="margin: 20px">Precio:</h2>
                        <input style="width: 95%; margin-right: 2%; margin-left: 2%" type="number" class="form-control" v-model="form.precio" >
                        <br>
                        <h2 style="margin: 20px">Descripcion:</h2>
                        <textarea style="width: 95%; margin-right: 2%; margin-left: 2%; height: 200px" class="form-control" v-model="form.descripcion"></textarea>
                        <br>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Imagenes:</h2>
                        <h3 style="margin-bottom: 20px">Se puede seleccionar mas de una</h3>
                        <div style="display: flex; flex-wrap: wrap;">
                            <div v-for="(imagen, index) in form.path" :key="index" style="margin: 2%; text-align: center">
                                <img style="width: 250px;" :src="imagen" class="img-thumbnail">
                                <button class="btn" style="background-color: red;" @click="eliminarFoto(index)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                        <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <input type="file" accept="image/*"  @change="establecerFoto1" multiple/>

                        <button class="btn btn-success" @click="guardarProducto" style="width: 70%; margin-left: 15%; background-color: black; margin-top: 2%">Guardar Producto</button>
                        <p v-if="listo == 1" style="color: black;text-align: center;margin-top: 10px;display: flex;justify-content: center;">
                            <svg style="float: left; margin-right: 10px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                            </svg>
                            {{mensajeFalta}}
                        </p>
                    </div>
                    <div v-if="listo == 3" style="display: flex; flex-direction: column;  align-items: center;">
                        <h1 style="font-size: 40px; text-align: center; color: darkgreen; margin-bottom: 20px"> {{mensajeFalta}}</h1>
                        <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="green" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                        </svg>
                    </div>
                </div>
        </div>
        <div class="py-12" v-if="user.aceptado == 0">
            <div class="overflow-hidden shadow-xl sm:rounded-lg" style="margin: 1%; padding: 15px;">
                <h1 class="texto" style="text-align: center; position: center; margin-bottom: 3%;"><b>Tu usuario aun no ha sido aceptado</b></h1>
                <p class="texto" style=" text-align: center; position: center; margin-bottom: 3%;">
                    Como una medida de seguridad y para garantizar el buen uso de “La Cole Market” antes de que puedas publicar <br>
                    tus productos para vender vamos a chequear tu informacion asi de forma segura podes formar parte de nuestra comunidad.
                    <br>
                    <br>
                    <b>¡En esta comunidad, todos nos cuidamos entre todos!</b>
                </p>
            </div>
        </div>



        <Footer></Footer>
    </cliente-layout>
</template>


<script>
import ClienteLayout from '@/Layouts/ClienteLayout.vue'
import Footer from '@/Layouts/Footer.vue'

export default {
    name: "crearProducto",
    props: ['categorias','fotosBanner','estados','colores', 'user'],
    components: {
        ClienteLayout,
        Footer
    },
    data()
    {
        return{
            notaTexto: '',
            mensajeFalta: '',
            listo: 0,
            num: 0,
            color: '',
            form:{
                nombre:'',
                categoria_id:'',
                estado_id: '',
                color_id: [],
                precio:'',
                descripcion:'',
                path:[]
            }
        }
    },
    methods:
        {
            eliminarFoto(index) {
                this.form.path.splice(index, 1);
            },
            eliminarColor(index) {
                this.form.color_id.splice(index, 1);
            },
            establecerFoto1(e) {
                let files = Array.from(e.target.files);
                let promises = [];

                files.forEach((file) => {
                    promises.push(this.leerArchivo(file));
                });

                Promise.all(promises)
                    .then((results) => {
                        this.form.path.push(...results);
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            },
            establecerColores() {
                if (!this.form.color_id.includes(this.color)) {
                    this.form.color_id.push(this.color);
                }
            },

            leerArchivo(file) {
                return new Promise((resolve, reject) => {
                    let reader = new FileReader();
                    reader.onloadend = () => {
                        resolve(reader.result);
                    };
                    reader.onerror = () => {
                        reject(new Error('Error al leer el archivo.'));
                    };
                    reader.readAsDataURL(file);
                });
            },
            guardarProducto()
            {
                if (this.form.nombre.length <= 30) {
                    if (this.form.precio <= 2000000000 && this.form.precio >= 1) {
                        if (this.form.nombre != '' && this.form.categoria_id != '' && this.form.estado_id != '' && this.form.precio != '' && this.form.descripcion != '' && this.form.color_id != '' && this.form.path != '') {
                            this.form.descripcion = this.form.descripcion.replace(/\n/g, '<br>');
                            axios.post('/guardarProducto', this.form)
                                .then(response => {
                                    this.listo = 3;
                                    this.mensajeFalta = 'Se creó exitosamente el producto';
                                    this.form.nombre = '';
                                    this.form.categoria_id = '';
                                    this.form.estado_id = '';
                                    this.form.precio = '';
                                    this.form.descripcion = '';
                                    this.form.color_id = [];
                                    this.color = '';
                                    this.form.path = [];
                                })
                                .catch(error => {
                                    console.error(error);
                                });

                        } else {
                            this.listo = 1;
                            this.mensajeFalta = "Falta ingresar:";
                            if (this.form.nombre == '') {
                                this.mensajeFalta = this.mensajeFalta + " nombre,";
                            }
                            if (this.form.categoria_id == '') {
                                this.mensajeFalta = this.mensajeFalta + " categoria,";
                            }
                            if (this.form.estado_id == '') {
                                this.mensajeFalta = this.mensajeFalta + " estado,";
                            }
                            if (this.form.precio == '') {
                                this.mensajeFalta = this.mensajeFalta + " precio,";
                            }
                            if (this.form.descripcion == '') {
                                this.mensajeFalta = this.mensajeFalta + " descripcion,";
                            }
                            if (this.form.color_id == '') {
                                this.mensajeFalta = this.mensajeFalta + " color,";
                            }
                            if (this.form.path == '') {
                                this.mensajeFalta = this.mensajeFalta + " fotos,";
                            }
                            this.mensajeFalta = this.mensajeFalta.slice(0, -1);
                        }
                    } else {
                        this.listo = 1;
                        this.mensajeFalta = "El precio debe estar entre 1 y 2,000,000,000";
                    }
                }
                else{
                    this.listo = 1;
                    this.mensajeFalta = "El nombre debe ser mas corto";
                }

            },
            moverIzq(){
                if (this.num == 0){
                    this.num = this.fotosBanner.length - 1;
                }
                else{
                    this.num = this.num - 1;
                }
            },
            moverDer(){
                this.num =  (this.num+1) % this.fotosBanner.length;
            },
            onTextChange()
            {
                const quill = this.$refs.editor.quill
                const len = quill.getLength()
                if (len > this.limit) {
                    quill.deleteText(this.limit, len);
                }
            },

        },
    mounted() {
        setInterval(this.moverDer, 5000); // Change image every 2 seconds
    }
}
</script>
<style>
@media (max-width: 500px) {
    h1{
        font-size: 30px;
    }
    .celular{
        display: none;
    }
    .filtros {
        background-color: #17428A;
        margin-top: -1px;
        padding-left: 12%;
        padding-top: 2%;
        padding-bottom: 2%;
        height: 55px;
        top: 80px;
    }
    .compu{
        display: none;
    }
    .altura{
        height: 63px;
    }
}
@media (min-width: 501px) {

    h1{
        font-size: 45px;
    }
    .filtros{
        background-color: #17428A;
        margin-top: -1px;
        padding-bottom: 1%;
        height: 40px;
        top: 79px;
    }
    .compu{
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
    }
    .altura{
        height: 118px;
    }
}

</style>
