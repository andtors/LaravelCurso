<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="Busca de locacoes">

                    <template v-slot:conteudo>
                        <div class="form-group row">
                            <div class="col form-group mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o id do Locacação">
                                     <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>
        
                            </div>
                            <div class="col form-group mb-3">
                                <input-container-component titulo="Nome do Locacação" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome do Locacação">
                                     <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome do Locacação" v-model="busca.nome">
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

                <card-component titulo="Relação de locacoes">

                    <template v-slot:conteudo>
                        <table-component :dados="locacoes.data" 
                                        :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget:'#modalModeloVisualizar'}"
                                        :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget:'#modalModeloAtualizar'}"
                                        :remover="{ visivel: true, dataToggle: 'modal', dataTarget:'#modalModeloRemover'}"
                                        :titulos="{
                            id: {titulo: 'ID', tipo: 'text', visivel: true},
                            cliente_id: {titulo: 'Cliente', tipo: 'text', visivel: true},
                            carro_id: {titulo: 'Carro', tipo: 'text', visivel: true},
                            data_inicio_periodo: {titulo: 'Inicio', tipo: 'data', visivel: false},
                            data_final_previsto_periodo: {titulo: 'Previsto', tipo: 'data', visivel: false},
                            data_final_realizado_periodo: {titulo: 'Final', tipo: 'data', visivel: false},
                            valor_diaria: {titulo: 'Valor diario', tipo: 'text', visivel: false},
                            km_inicial: {titulo: 'Km inicial', tipo: 'text', visivel: false},
                            km_final: {titulo: 'Km final', tipo: 'text', visivel: false},
                            created_at: {titulo: 'Data de criação', tipo: 'data', visivel: false},
                        }">
                        </table-component>
                    </template>

                    <template v-slot:rodape>
                       
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in locacoes.links" :class="l.active ? 'page-item active' : 'page-item' " :key="key" @click="paginacao(l)">
                                        <a class="page-link"  v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-end" data-toggle="modal" data-target="#modalModelo">Adicionar</button>
                            </div>
                        </div>
                    
                    </template>
                    
                </card-component>
            </div>
        </div>
        <modal-component id="modalModelo" titulo="Adicionar Locacação">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a Locacação" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do Locacação" id="novoNome" id-help="novonomeHelp" texto-ajuda="Informe o nome do Locacação">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novonomeHelp" placeholder="Nome do Locacação" v-model="nomeModelo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <label for="" class="form-label">Marca</label>
                    <select v-model="modeloMarca" class="form-select" aria-label="Default select example">
                        <option value="" disabled selected>Selecione</option>
                        <option v-for="marca in marcas" :key="marca.id" :value="marca.id">{{ marca.nome }}</option>
                    </select>
                    <small class="text-muted">Selecione a marca do carro</small>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>

                <div class="form-group">
                <input-container-component titulo="Número de portas" id="novoNumeroPortas" id-help="novoNumeroPortasHelp" texto-ajuda="Informe a quantidade de número de portas">
                    <input type="number" class="form-control" id="novoNumeroPortas" aria-describedby="novoNumeroPortasHelp" placeholder="Quantidade portas" v-model="modeloNumeroPortas">
                </input-container-component>
            </div>

            <div class="form-group">
                <input-container-component titulo="Lugares" id="novoLugares" id-help="novoLugaresHelp" texto-ajuda="Informe a quantidade de lugares">
                    <input type="number" class="form-control" id="novoLugares" aria-describedby="novoLugaresHelp" placeholder="Quantidade lugares" v-model="modeloLugares">
                </input-container-component>
            </div>

            <div class="form-group">
                <label for="" class="form-label">Air Bag</label>
                <select v-model="modeloAirBag" class="form-select" aria-label="Default select example">
                    <option value="" disabled selected>Selecione</option>
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
                <small class="text-muted">Selecione se o Locacação possui air bag</small>
            </div>
            
            <div class="form-group">
                <label for="" class="form-label">ABS</label>
                <select v-model="modeloABS" class="form-select" aria-label="Default select example">
                    <option value="" disabled selected>Selecione</option>
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
                <small class="text-muted">Selecione se o Locacação possui ABS</small>
            </div>

            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                <button type="button" class="btn btn-secondary" @click="fechar()" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>

        <modal-component id="modalModeloVisualizar" titulo="Visualizar Locacação">
            <template v-slot:alertas>
            </template>

            <template v-slot:conteudo>

                <input-container-component titulo="ID">
                    <input type="text" :value="$store.state.item.id" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Marca">
                <img :src="'/storage/'+$store.state.item.marca_id" v-if="$store.state.item.marca_id" width="50" height="50">
                </input-container-component>

                <input-container-component titulo="Nome do Locacação">
                    <input type="text" :value="$store.state.item.nome" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Imagem">                    
                    <img :src="'/storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem" width="50" height="50">
                </input-container-component>

                <input-container-component titulo="Data de criação">
                    <span class="form-control bg-body-secondary ">{{ formatarDatas($store.state.item.created_at) }}</span>
                </input-container-component>

                <input-container-component titulo="Número de portas">
                    <input type="text" :value="$store.state.item.numero_portas" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Lugares">
                    <input type="text" :value="$store.state.item.lugares" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Air Bag">
                    <input type="text" :value="$store.state.item.air_bag ? 'Sim' : 'Não' " disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="ABS">
                    <input type="text" :value="$store.state.item.abs ? 'Sim' : 'Não' " disabled class="form-control">
                </input-container-component>

            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>

        <modal-component id="modalModeloRemover" titulo="Remover Locacação">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao"  v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">

                <input-container-component titulo="ID">
                    <input type="text" :value="$store.state.item.id" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Marca">
                <img :src="'/storage/'+$store.state.item.marca_id" v-if="$store.state.item.marca_id" width="50" height="50">
                </input-container-component>

                <input-container-component titulo="Nome do Locacação">
                    <input type="text" :value="$store.state.item.nome" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Imagem">                    
                    <img :src="'/storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem" width="50" height="50">
                </input-container-component>

                <input-container-component titulo="Data de criação">
                    <input type="text" :value="$store.state.item.created_at" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Número de portas">
                    <input type="text" :value="$store.state.item.numero_portas" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Lugares">
                    <input type="text" :value="$store.state.item.lugares" disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="Air Bag">
                    <input type="text" :value="$store.state.item.air_bag ? 'Sim' : 'Não' " disabled class="form-control">
                </input-container-component>

                <input-container-component titulo="ABS">
                    <input type="text" :value="$store.state.item.abs ? 'Sim' : 'Não' " disabled class="form-control">
                </input-container-component>

            </template>

            <template v-slot:rodape >
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>

        <modal-component id="modalModeloAtualizar" titulo="Atualizar Locacação">

        <template v-slot:alertas>
            <alert-component tipo="success" titulo="Atualização realizada com sucesso" :detalhes="$store.state.transacao"  v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
            <alert-component tipo="danger" titulo="Erro na Atualização" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
        </template>
        <template v-slot:conteudo  v-if="$store.state.transacao.status != 'sucesso'">
            <div class="form-group">
                <input-container-component titulo="Nome do Locacação" id="atualizarNome" id-help="atualizarnomeHelp" texto-ajuda="Informe o novo nome do Locacação">
                    <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarnomeHelp" placeholder="Nome do Locacação" v-model="$store.state.item.nome">
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

            <div class="form-group">
                <input-container-component titulo="Número de portas" id="atualizarNumeroPortas" id-help="atualizarNumeroPortasHelp" texto-ajuda="Informe a nova quantidade de número de portas">
                    <input type="number" class="form-control" id="atualizarNumeroPortas" aria-describedby="atualizarNumeroPortasHelp" placeholder="Quantidade portas" v-model="$store.state.item.numero_portas">
                </input-container-component>
            </div>

            <div class="form-group">
                <input-container-component titulo="Lugares" id="atualizarLugares" id-help="atualizarLugaresHelp" texto-ajuda="Informe a nova quantidade de lugares">
                    <input type="number" class="form-control" id="atualizarLugares" aria-describedby="atualizarLugaresHelp" placeholder="Quantidade lugares" v-model="$store.state.item.lugares">
                </input-container-component>
            </div>

            <div class="form-group">
                <label for="" class="form-label">Air Bag</label>
                <select v-model="$store.state.item.air_bag" class="form-select" aria-label="Default select example">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
                <small class="text-muted">Selecione se o Locacação possui air bag</small>
            </div>
            
            <div class="form-group">
                <label for="" class="form-label">ABS</label>
                <select v-model="$store.state.item.abs" class="form-select" aria-label="Default select example">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
                <small class="text-muted">Selecione se o Locacação possui ABS</small>
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
                urlBase: "http://localhost:8000/api/v1/locacao",
                urlBaseCarros: "http://localhost:8000/api/v1/carros-lista",
                urlBaseClientes: "http://localhost:8000/api/v1/clientes-lista",
                urlPaginacao: '',
                urlFiltro: '',
                nomeModelo: '',
                modeloNumeroPortas: '',
                modeloABS: '',
                modeloAirBag: '',
                modeloMarca: '',
                modeloLugares: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                locacoes: { data: [] },
                marcas: [],
                busca: { id: '', nome: '' }
            }
        },
        methods: {
            formatarDatas(d){
                const formattedDate = useDateFormat(d, "DD/MM/YYYY HH:mm:ss")
                return formattedDate
            },
            carregarCarros(){

                axios.get(this.urlBaseMarca)
                    .then(response => {
                        this.carros = response.data
                    }) 
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            carregarClientes(){

            axios.get(this.urlBaseMarca)
                .then(response => {
                    this.clientes = response.data
                }) 
                .catch(errors => {
                    console.log(errors)
                })
            },
            atualizar(){

                let formData = new FormData()

                formData.append('_method', 'patch')
                if(this.arquivoImagem[0]){
                    formData.append('imagem', this.arquivoImagem[0])
                }

                formData.append('nome', this.$store.state.item.nome)
                formData.append('numero_portas', this.$store.state.item.numero_portas)
                formData.append('lugares', this.$store.state.item.lugares)
                formData.append('air_bag', Number(this.$store.state.item.air_bag))
                formData.append('abs', Number(this.$store.state.item.abs))
                
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
                novoImagem.value = '',
                this.transacaoStatus = '',
                this.transacaoDetalhes = {},
                this.nomeModelo = '',
                this.modeloNumeroPortas = '',
                this.modeloABS = '',
                this.modeloAirBag = '',
                this.modeloLugares = ''
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
                    this.$store.state.transacao.mensagem = 'Registro de Locacação atualizado com sucesso!'
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

                        filtro += chave + ":like:%" + this.busca[chave] + "%"

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
                        this.locacoes = response.data
                        console.log(this.locacoes)

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

                formData.append('nome', this.nomeModelo)
                formData.append('imagem', this.arquivoImagem[0])
                formData.append('abs', this.modeloABS)
                formData.append('air_bag', this.modeloAirBag)
                formData.append('lugares', this.modeloLugares)
                formData.append('numero_portas', this.modeloNumeroPortas)
                formData.append('marca_id', this.modeloMarca)

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
            this.carregarLista(),
            this.carregarCarros()
            this.carregarClientes()
        }
    }
</script>