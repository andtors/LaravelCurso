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
                        <table-component :dados="marcas.data" :titulos="{
                            id: {titulo: 'ID', tipo: 'text'},
                            nome: {titulo: 'Nome', tipo: 'text'},
                            imagem: {titulo: 'Imagem', tipo: 'imagem'},
                            created_at: {titulo: 'Data de criação', tipo: 'data'},
                        }">
                        </table-component>
                    </template>

                    <template v-slot:rodape>
                       
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in marcas.links" :class="l.active ? 'page-item active' : 'page-item' " :key="key" @click="paginacao(l)">
                                        <a class="page-link"  v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-end" data-toggle="modal" data-target="#modalMarca">Adicionar</button>
                            </div>
                        </div>
                    
                    </template>
                    
                </card-component>
            </div>
        </div>
        <modal-component id="modalMarca" titulo="Adicionar marca">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus == 'erro'"></alert-component>
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
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                marcas: { data: [] }
            }
        },
        methods: {
            paginacao(l){
                if(l.url){
                    this.urlBase = l.url // ajustando a url de consulta
                    this.carregarLista() // requisitando a url conforme consulta
                }
            },
            carregarLista(){

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization' : this.token
                    }
                }

                axios.get(this.urlBase, config)
                    .then(response => {
                        this.marcas = response.data
                       
                    }) 
                    .catch(errors => {
                        console.log(errors)
                    })
            },
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
                        this.transacaoStatus = 'adicionado'
                        this.transacaoDetalhes = {
                            mensagem: 'ID do registro: ' + response.data.id 
                        }
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        }
                    })
            },
        },
        mounted(){
            this.carregarLista()
        }
    }
</script>