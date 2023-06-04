<script setup>

import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ClienteLayout from '@/Layouts/ClienteLayout.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
<template>
    <cliente-layout>
        <Head title="Log in" />
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <div class="altura" style="background-color: #121212;"></div>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div v-if="fotosBanner && fotosBanner[num] " class="carousel-item active">
                    <a :href="'https://' + fotosBanner[num].url" target="_blank">
                        <img v-if="fotosBanner[num]" class="d-block w-100"  :src="'/fotos/' + fotosBanner[num].path" style="width: 100%" alt="First slide">
                    </a>
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

        <form @submit.prevent="submit" style="margin-bottom: 80px; padding-left: 10%; padding-right: 10%">
            <div class="row celular" style="margin-top: 10%; margin-bottom: 10%">
                <div class="col-6">
                    <h1 style="font-size: 50px; text-align: center; padding: 30px">¡Bienvenido!</h1>
                    <h1 style="font-size: 30px; text-align: center; padding: 10px">Nos alegra tenerte nuevamente</h1>
                </div>
                <div class="col-6" style="background-color: white; padding: 30px; border-radius: 5px">
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="password" value="Contraseña" />
                        <TextInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-full"
                            required
                            autocomplete="current-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox v-model:checked="form.remember" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                        </label>
                    </div>
                    <div class="flex items-center justify-content-lg-center mt-4">
                        <a v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                            <p style="text-align: center; font-size: 20px; margin-right: 20px;">¿Olvidaste tu contraseña?</p>
                        </a>
                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Log in
                        </PrimaryButton>

                    </div>
                </div>
            </div>
            <div class="row computadora" style="margin-top: 10%; margin-bottom: 10%">
                <div class="col-12" style="margin-bottom: 10%;">
                    <h1 style="font-size: 40px; text-align: center;">¡Bienvenido!</h1>
                    <h1 style="font-size: 20px; text-align: center; ">Nos alegra tenerte nuevamente</h1>
                    <h1 style="font-size: 20px; text-align: center;"> Inicia sesión</h1>
                </div>
                <div class="col-12" style="background-color: white; padding: 30px; border-radius: 5px">
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="password" value="Contraseña" />
                        <TextInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-full"
                            required
                            autocomplete="current-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox v-model:checked="form.remember" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                        </label>
                    </div>
                    <div class="flex items-center justify-content-lg-center mt-4">
                        <a v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                            <p style="text-align: center; font-size: 20px; margin-right: 20px;">¿Olvidaste tu contraseña?</p>
                        </a>
                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Log in
                        </PrimaryButton>

                    </div>
                </div>
            </div>

        </form>

        <Footer></Footer>

    </cliente-layout>
</template>
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

<style>
@media (max-width: 500px) {
    .celular{
        display: none;
    }
    .altura {
        height: 63px;
    }
}
@media (min-width: 501px) {
    .computadora{
        display: none;
    }
    .altura {
        height: 118px;
    }
}

</style>
