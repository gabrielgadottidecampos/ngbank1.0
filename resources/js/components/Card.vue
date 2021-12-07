<template>

    <div class="card mb-3">
        <h5 class="card-header text-center corTeste text-white"><i class="fas fa-users"><b> {{titulo}}</b></i> </h5>

        <div class="card-body text-center ">
            <slot name="conteudo"></slot>
        </div>

        <div class="card-footer ">
            <slot name="rodape"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['titulo']
}
</script>
<style>
.corTeste{
    background: rgb(60,58,58);
    background: linear-gradient(0deg, rgba(60,58,58,1) 0%, rgba(98,98,98,1) 100%);
}
.carDentroTeste{
    background:  #454d55;
}
</style>
