<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registrar</div>

                    <div class="card-body">
                        <form method="POST" action="">
                            

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Nome:</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control " name="name" value="" required autocomplete="name" autofocus>

                                
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">E-mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email">

                                    
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control " name="password" required autocomplete="new-password">

                                
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmação de senha</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Registrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['csrf_token'],
        data() {
            return {
                name: '',
                email:'',
                password: '',
                confirmPassword: ''
            }
        },
        methods: {
            login(e){
            
                let url = "http://localhost:8000/api/register"
                let configuracao = {
                    method: 'POST',
                    body: new URLSearchParams({
                        'email' : this.email,
                        'password' : this.password
                    })
                }

                fetch(url, configuracao)
                    .then(response => response.json())
                    .then(data => {
                        if(data.token){
                            document.cookie = 'token='+data.token+';SameSite=Lax'
                        }

                        // dar sequencia no envio do form de autenticação
                        e.target.submit()
                    })
            },
        } // Props não é data pois está vindo do back-end ao renderizar a vue, mas a usabilidade é semelhante
    }
</script>