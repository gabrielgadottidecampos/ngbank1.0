<template>

    <div class="card mb-3">
        <h5 class="card-header text-center bg-info text-white"><i class="fas fa-users"><b> {{titulo}}</b></i> </h5>

        <div class="card-body text-center">
            <slot name="conteudo"></slot>
        </div>

        <div class="card-footer">
            <slot name="rodape"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['titulo']
}
</script>
