<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ClienteLayout from '@/Layouts/ClienteLayout.vue'

const form = useForm({
    name: '',
    email: '',
    password: '',
    numero: '',
    nacimiento: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
<script>
import Footer from '@/Layouts/Footer.vue'
export default {
    components: {
        Footer
    },
    data()
    {
        return{
            fotosBanner: [],
            num: 0
        }
    },
    methods:
        {
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
            buscarBanner(){
                axios.get('/buscarBanner', {
                })
                    .then(response => {
                        this.fotosBanner = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
        },

    mounted() {

        setInterval(this.moverDer, 5000); // Change image every 2 seconds
    },
    created() {
        this.buscarBanner();
    },
};

</script>

<template>
    <cliente-layout>
        <Head title="Register" />
        <div class="altura" style="background-color: #121212;"></div>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img v-if="fotosBanner[num]" class="d-block w-100"  :src="'/fotos/' + fotosBanner[num].path" style="width: 100%" alt="First slide">
                </div>
            </div>
            <a class="carousel-control-prev" @click="moverIzq()" role="button" data-slide="prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                </svg>
            </a>
            <a class="carousel-control-next" @click="moverDer()" role="button" data-slide="next">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                </svg>
            </a>
        </div>
        <form @submit.prevent="submit" style="margin-bottom: 80px; padding-left: 15%; padding-right: 15%">

           <div>
               <h1 style="font-size: 40px; text-align: center; padding: 20px"> Registrate como vendedor</h1>
               <a :href="route('login')">
                   <p style="text-align: center; font-size: 20px;  margin-bottom: 10px">¿Ya estas registrado?
                   </p>
               </a>
           </div>
            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="mt-4">
                <InputLabel for="numero" value="Numero" />
                <TextInput
                    id="numero"
                    v-model="form.numero"
                    type="number"
                    class="mt-1 block w-full"
                    required
                />
                <InputError class="mt-2" :message="form.errors.numero" />
            </div>
            <div class="mt-4">
                <InputLabel for="nacimiento" value="Nacimiento" />
                <TextInput
                    id="nacimiento"
                    v-model="form.nacimiento"
                    type="date"
                    class="mt-1 block w-full"
                    required
                />
                <InputError class="mt-2" :message="form.errors.date" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Repetir contraseña" />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ml-2">
                           Estoy de acuerdo <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">con los terminos de servicio</a> y <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">con la politica de privacidad</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-content-lg-center mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar
                </PrimaryButton>
            </div>
        </form>
        <Footer></Footer>
    </cliente-layout>
</template>
<style>
@media (max-width: 500px) {
    .altura {
        height: 63px;
    }
}
@media (min-width: 501px) {
    .altura {
        height: 118px;
    }
}

</style>
