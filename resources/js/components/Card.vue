<template>

    <div class="card mb-3 corTeste">
        <h5 class="card-header text-center carDentroTeste"><b> {{titulo}}</b></h5>

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
    background: rgba(0, 0, 0, 0.3);

}
.carDentroTeste{
    background:rgba(0, 0, 0, 0.3);
    color: #c2a925
}
</style>
