<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="Busca de marcas">

                    <template v-slot:conteudo>
                        <div class="form-group row">
                            <div class="col form-group mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o id da marca">
                                     <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" >
                                </input-container-component>
        
                            </div>
                            <div class="col form-group mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca">
                                     <input type="number" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca" >
                                </input-container-component>

                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                        </div>
                    </template>
                </card-component>

                <card-component titulo="Relação de marcas">

                    <template v-slot:conteudo>
                        <table-component>
                        </table-component>
                    </template>

                    <template v-slot:rodape>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm float-end" data-toggle="modal" data-target="#modalMarca">Adicionar</button>
                        </div>
                    </template>

                </card-component>
            </div>
        </div>
        <modal-component id="modalMarca" titulo="Adicionar marca">
            <template v-slot:alertas>
                <alert-component tipo="success"></alert-component>
                <alert-component tipo="danger"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca" id="novoNome" id-help="novonomeHelp" texto-ajuda="Informe o novo nome da marca">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novonomeHelp" placeholder="Nome da marca" v-model="nomeMarca">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
    </div>
</template>

<script>
    export default{
        computed: {
                token(){
                    let token = document.cookie.split(';').find(indice => indice.includes('token='))

                    token = token.split('=')[1]
                    token = "Bearer " + token

                    return token
                }
            },
        data() {
            return {
                urlBase: "http://localhost:8000/api/v1/marca",
                nomeMarca: '',
                arquivoImagem: []
            }
        },
        methods: {
            carregarImagem(e){
                this.arquivoImagem = e.target.files
            },
            salvar(){
                let formData = new FormData()

                formData.append('nome', this.nomeMarca)
                formData.append('imagem', this.arquivoImagem[0])

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization' : this.token
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        console.log(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
        }
    }
</script>