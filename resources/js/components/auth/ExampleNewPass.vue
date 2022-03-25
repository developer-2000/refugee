<template>

    <div class="block_auth">

        <v-alert :value="reset_p" type="success" >
            На указанный Email отправлено письмо с подтверждением восстановления пароля !
        </v-alert>

        <v-alert :value="!reset_p" type="warning" >
           Указанный Email не найден в базе !
        </v-alert>

    </div>

</template>


<script>
    export default {
        props: ["reset_p"],
    }
</script>
