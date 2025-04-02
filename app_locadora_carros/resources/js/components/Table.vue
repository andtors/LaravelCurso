

<template>
    <div>
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="titulo, key in titulos" :key="key">{{ titulo.titulo }}</th>
                    <th v-if="visualizar.visivel || atualizar || remover"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'text'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/'+valor" width="50" height="50">
                        </span>
                    </td>
                    <td v-if="visualizar.visivel || atualizar || remover">
                        <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm me-1" :data-toggle="visualizar.dataToggle" :data-target="visualizar.dataTarget">Visualizar</button>
                        <button v-if="atualizar" class="btn btn-outline-primary btn-sm me-1">Atualizar</button>
                        <button v-if="remover" class="btn btn-outline-danger btn-sm">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'visualizar', 'atualizar', 'remover'],
        computed: {
            dadosFiltrados(){
                let campos = Object.keys(this.titulos)
                let dadosFiltrados = []

                this.dados.map((item, chave) => {
        
                    let itemFiltrado = {}
                    campos.forEach(campo => {

                        itemFiltrado[campo] = item[campo] // Sintaxe de array para atribuir valores a objetos
                
                    })
                    
                    dadosFiltrados.push(itemFiltrado)
        
                })
                
                return dadosFiltrados
            }
        }
    }
</script>
