<template>
   <div>
      <div class="form-row align-items-center">
            <div class="col-md-3">
               <label for="validationnomeCompleto"> Nome Completo </label>
               <label class="sr-only" for="inlineFormInput">Nome Completo</label>
               <input type="text" class="form-control mb-2" id="inlineFormInput" v-model="pesquisa.nome_completo" placeholder="Nome Completo">
            </div>
            <div class="col-md-3">
               <label> Cpf</label>
               <label class="sr-only" for="inlineFormInput">Cpf</label>
               <input type="text" class="form-control mb-2" id="inlineFormInput" v-model="pesquisa.cpf" placeholder="Cpf">
            </div>
            <div class="col-auto">
               <br>
               <button type="submit" class="btn btn-primary mb-2" @click="pesquisar()">Pesquisar</button>
               <button type="button" class="btn btn-primary mb-2" @click="cadastrar()">Cadastrar</button>
            </div>
      </div>

        <table class="table table-bordered col-md-7">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome Completo</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Cpf</th>
                    <th scope="col">Idade</th>
                    <th scope="col">Qtd.Telefones</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="pessoa in pessoas" v-bind:key="pessoa.id">
                    <th scope="row">{{ pessoa.id }}</th>
                    <td>{{ pessoa.nome_completo}}</td>
                    <td>{{ pessoa.email }}</td>
                    <td>{{ pessoa.cpf}}</td>
                    <td>{{ pessoa.data_nascimento }}</td>
                    <td>{{pessoa.telefones.length}}</td>
                    <td>
                        <a @click="editar(pessoa.id)" class="actions edit">
                            <span class="glyphicon glyphicon-pencil"> </span>
                        </a>
                        <a @click="excluir(pessoa.id)" class="actions edit">
                            <span class="glyphicon glyphicon-trash"> </span>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
   </div>
</template>


<script>
    export default {
        data() {
            return {
                pesquisa: {},
                pessoas: []
            }
        },
        methods: {
            pesquisar: function () {
               var ctr = this;
               axios.post('/pessoas/pesquisar', this.pesquisa).then(function (response) {
                  console.log(response.data);
                  ctr.pessoas = response.data;
               }, function (error) {
                  console.log('Erro: '+error.data);
               })
            },
            cadastrar: function () {
               window.location = "/pessoas/create";
            },
            editar: function (id) {
               window.location = "/pessoas/"+id+"/edit";
            },
            excluir: function (id) {
               if(window.confirm('Tem certeza disso?')) {
                  var ctr = this;
                  axios.delete('/pessoas/'+id).then(function (response) {
                     window.alert("Deletado com sucesso");

                     let index = ctr.pessoas.map((e) => {
                        return e.id;
                     }).indexOf(id);

                     this.pessoas.splice(index, 1);           

                  }, function (error) {
                     console.log('Erro: '+error.data);
                  });
               }
            }
        }
    }
</script>
      