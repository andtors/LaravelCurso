<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Busca de marcas</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col form-group mb-3">
                                <label for="inputId" class="form-label">ID</label>
                                <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                <small id="emailHelp" class="form-text text-muted">Opcional. Informe o ID do registro</small>
                            </div>
                            <div class="col form-group mb-3">
                                <label for="inputNome" class="form-label">Nome</label>
                                <input type="Nome" class="form-control" id="inputNome" placeholder="Nome da marca">
                                <small id="emailHelp" class="form-text text-muted">Opcional. Informe o nome da marca</small>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
</script>