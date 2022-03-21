<template>
<div>
    <form class="form mt-10" action="" @submit.stop.prevent="sendContact">
        <div class="form__row">
            <div class="form__input-group">
                <div class="form__label-group">
                    <p><label for="name" class="">Nome <abbr title="Obrigatório">*</abbr></label>
                    </p>
                </div><input v-model="formData.name" id="name" autocomplete="false" tabindex="0" class="form__input">
            </div>
        </div>
        <div class="form__row">
            <div class="form__input-group">
                <div class="form__label-group">
                    <p><label for="email" class="">Email <abbr title="Obrigatório">*</abbr></label>
                    </p>
                </div><input v-model="formData.email" id="email" name="email" autocomplete="false" tabindex="0" class="form__input" required>
            </div>
        </div>
        <div class="form__row">
            <div class="form__input-group">
                <div class="form__label-group">
                    <p><label for="subject" class="subject">Assunto <abbr title="Obrigatório">*</abbr></label></p>
                </div><input v-model="formData.subject" id="subject" name="subject" autocomplete="false" tabindex="0" class="form__input" required>
            </div>
        </div>
        <div class="form__row">
            <div class="form__input-group">
                <div class="form__label-group">
                    <p><label for="message" class="bg-white text-gray-600 px-1">Mensagem <abbr title="Obrigatório">*</abbr></label></p>
                </div><textarea v-model="formData.message" id="message" name="message" class="form__input" rows="4" required></textarea>
            </div>
        </div>
        <div class="mt-6 pt-3 text-center"><button type="submit" :disabled="preloader" class="button button--filled button--primary">{{ preloader ? 'Enviando ...' : 'Enviar'}}</button></div>
    </form>
</div>
</template>

<script>
import axios from "axios"

export default {
    data() {
        return {
            preloader: false,
            formData: {
                name: '',
                email: '',
                subject: '',
                message: ''
            }
        }
    },
    methods: {
        sendContact() {
            this.preloader = true;
            axios.post('/api/contact', this.formData)
                .then(res => {
                    alert('Mensagem enviado');
                })
                .catch((error) => console.log(error))
                .finally(() => {
                    this.preloader = false;
                    this.reset();
                });
        },
        reset() {
            this.formData = {
                name: '',
                email: '',
                subject: '',
                message: ''
            }
        }
    },
}
</script>
