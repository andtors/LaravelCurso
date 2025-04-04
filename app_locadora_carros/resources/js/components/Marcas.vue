<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="Busca de marcas">

                    <template v-slot:conteudo>
                        <div class="form-group row">
                            <div class="col form-group mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o id da marca">
                                     <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>
        
                            </div>
                            <div class="col form-group mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca">
                                     <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca" v-model="busca.nome">
                                </input-container-component>

                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm float-end" @click="pesquisar()">Pesquisar</button>
                        </div>
                    </template>
                </card-component>

                <card-component titulo="Relação de marcas">

                    <template v-slot:conteudo>
                        <table-component :dados="marcas.data" 
                                        :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget:'#modalMarcaVisualizar'}"
                                        :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget:'#modalMarcaAtualizar'}"
                                        :remover="{ visivel: true, dataToggle: 'modal', dataTarget:'#modalMarcaRemover'}"
                                        :titulos="{
                            id: {titulo: 'ID', tipo: 'text', visivel: true},
                            nome: {titulo: 'Nome', tipo: 'text', visivel: true},
                            imagem: {titulo: 'Imagem', tipo: 'imagem', visivel: true},
                            created_at: {titulo: 'Data de criação', tipo: 'data', visivel: false},
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
                <button type="button" class="btn btn-secondary" @click="fechar()" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>

        <modal-component id="modalMarcaVisualizar" titulo="Visualizar marca">
            <template v-slot:alertas>
            </template>

            <template v-slot:conteudo>

                <input-container-component titulo="ID">
                    <input type="text" :value="$store.state.item.id" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Nome da marca">
                    <input type="text" :value="$store.state.item.nome" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Imagem">                    
                    <img :src="'/storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem" width="50" height="50">
                </input-container-component>

                <input-container-component titulo="Data de criação">
                <span class="form-control bg-body-secondary ">{{ formatarDatas($store.state.item.created_at) }}</span>
                </input-container-component>

            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>

        <modal-component id="modalMarcaRemover" titulo="Remover marca">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao"  v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">

                <input-container-component titulo="ID">
                    <input type="text" :value="$store.state.item.id" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Nome da marca">
                    <input type="text" :value="$store.state.item.nome" disabled class="form-control">
                </input-container-component>

            </template>

            <template v-slot:rodape >
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>

        <modal-component id="modalMarcaAtualizar" titulo="Atualizar marca">

        <template v-slot:alertas>
            <alert-component tipo="success" titulo="Atualização realizada com sucesso" :detalhes="$store.state.transacao"  v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
            <alert-component tipo="danger" titulo="Erro na Atualização" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
        </template>
        <template v-slot:conteudo  v-if="$store.state.transacao.status != 'sucesso'">
            <div class="form-group">
                <input-container-component titulo="Nome da marca" id="atualizarNome" id-help="atualizarnomeHelp" texto-ajuda="Informe o novo nome da marca">
                    <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarnomeHelp" placeholder="Nome da marca" v-model="$store.state.item.nome">
                </input-container-component>
            </div>

            <div class="form-group">
                
                <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                    <input type="file" class="form-control" id="atualizarImagem" aria-describedby="atualizarImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                </input-container-component>

                <input-container-component titulo="Imagem atual">                    
                    <img :src="'/storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem" width="50" height="50">
                </input-container-component>
            </div>
        </template>
        <template v-slot:rodape>
            <button type="button" class="btn btn-primary" @click="atualizar()"  v-if="$store.state.transacao.status != 'sucesso'">Atualizar</button>
            <button type="button" class="btn btn-secondary" @click="fechar()" data-dismiss="modal">Fechar</button>
        </template>

        </modal-component>

    </div>
</template>

<script>
import { useDateFormat } from '@vueuse/core'

    export default{
        computed: {
                
            },
        data() {
            return {
                urlBase: "http://localhost:8000/api/v1/marca",
                urlPaginacao: '',
                urlFiltro: '',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                marcas: { data: [] },
                busca: { id: '', nome: '' }
            }
        },
        methods: {
            formatarDatas(d){
                const formattedDate = useDateFormat(d, "DD/MM/YYYY HH:mm:ss")
                return formattedDate
            },
            atualizar(){

                let formData = new FormData()

                formData.append('_method', 'patch')
                if(this.arquivoImagem[0]){
                    formData.append('imagem', this.arquivoImagem[0])
                }
                formData.append('nome', this.$store.state.item.nome)
                
                let url = this.urlBase + '/' + this.$store.state.item.id

                let config = {
                    headers: {
                        'Content-Type' : 'multipart/form-data',
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
        
                    })
                
            },
            fechar(){
                this.nomeMarca =  '',
                novoImagem.value = '',
                this.transacaoStatus = '',
                this.transacaoDetalhes = {}
            },
            remover(){
                let confirmacao = confirm("Tem certeza que deseja remover esse registro?")
                
                if(!confirmacao){
                    return false
                }

                let url = this.urlBase + '/' + this.$store.state.item.id

                let formData = new FormData()
                formData.append('_method', 'delete')

                axios.post(url, formData)
                .then(response=> {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro de marca atualizado com sucesso!'
                    this.carregarLista()
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = errors.response.data.message
                    this.$store.state.transacao.dados = errors.response.data.errors
                })
            },
            pesquisar(){
                
                let filtro = ''
                for(let chave in this.busca){    

                    if(this.busca[chave]){
                        
                        if(filtro != ''){
                            filtro += ";"
                        }

                        filtro += chave + ":like:" + this.busca[chave]

                    }
                }

                if(filtro != ''){
                    this.urlPaginacao = 'page=1'
                    this.urlFiltro = '&filtro=' + filtro
                } else {
                    this.urlFiltro = ''
                }

                this.carregarLista()
            },  
            paginacao(l){
                if(l.url){
                    //this.urlBase = l.url // ajustando a url de consulta
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista() // requisitando a url conforme consulta
                }
            },
            carregarLista(){
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

                axios.get(url)
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
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'adicionado'
                        this.transacaoDetalhes = {
                            mensagem: 'ID do registro: ' + response.data.id 
                        }

                        this.carregarLista()
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