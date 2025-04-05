
<template>
    
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    
                    <th scope="col"  v-for="titulo, key in titulos" :key="key" >
                        <span v-if="titulo.visivel">{{ titulo.titulo }}</span>
                    </th>
                    <th ></th>
                    <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
    
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        
                        <span v-if="titulos[chaveValor].tipo == 'text' && titulos[chaveValor].visivel == true && titulos[chaveValor].titulo != 'Disponivel' ">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].titulo == 'Disponivel'">{{ valor == 0 ? 'Livre' : 'Alugado' }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/'+valor" width="50" height="50">
                        </span>
                    </td>
                    <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                        <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm me-1" :data-toggle="visualizar.dataToggle" :data-target="visualizar.dataTarget" @click="setStore(obj)">Visualizar</button>
                        <button v-if="atualizar.visivel" class="btn btn-outline-primary btn-sm me-1" :data-toggle="atualizar.dataToggle" :data-target="atualizar.dataTarget" @click="setStore(obj)">Atualizar</button>
                        <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm" :data-toggle="remover.dataToggle" :data-target="remover.dataTarget" @click="setStore(obj)">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'visualizar', 'atualizar', 'remover'],
        methods: {
             
            setStore(obj){
                this.$store.state.transacao.status = ''
                this.$store.state.transacao.mensagem = ''
                this.$store.state.transacao.dados = ''
                this.$store.state.item = obj
            },
        },  
        computed: {
            dadosFiltrados(){
                
                let campos = Object.keys(this.titulos)
                let dadosFiltrados = [] 
                
                this.dados.map((item, chave) => {
        
                    let itemFiltrado = {}
                    campos.forEach(campo => {
                        
                        itemFiltrado[campo] = item[campo] // Sintaxe de array para atribuir valores a objetos
                        
                        if(campo == 'marca_id'){
                           
                            itemFiltrado[campo] = item.marca.imagem
                        }

                        if(campo == 'modelo_id'){
                           
                           itemFiltrado[campo] = item.modelo.nome
                       }

                       if(campo == 'cliente_id'){
                            itemFiltrado[campo] = item.cliente.nome
                       }

                       if(campo == 'carro_id'){
                            itemFiltrado[campo] = item.carro.placa
                       }
                    })
                    
                    dadosFiltrados.push(itemFiltrado)
        
                })
                
                console.log(dadosFiltrados)
                return dadosFiltrados
            }
        }
    }
</script>
