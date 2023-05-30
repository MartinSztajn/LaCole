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
        <Head title="Log in" />
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <div class="altura" style="background-color: #121212;"></div>

        <form @submit.prevent="submit" style="margin-bottom: 80px; padding-left: 10%; padding-right: 10%">
            <div class="row celular" style="margin-top: 10%; margin-bottom: 10%">
                <div class="col-6">
                    <h1 style="font-size: 50px; text-align: center; padding: 30px">¡Bienvenido!</h1>
                    <h1 style="font-size: 30px; text-align: center; padding: 10px">Nos alegra tenerte nuevamente</h1>
                    <h1 style="font-size: 30px; text-align: center;"> Inicia sesión</h1>
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
