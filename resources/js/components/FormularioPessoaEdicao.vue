<template>
   <div>
      <div class="form-row align-items-center">
         <div class="col-md-3">
            <label for="validationnomeCompleto"> Nome Completo </label>
            <label class="sr-only" for="inlineFormInput">Nome Completo</label>
            <input type="text" class="form-control mb-2" v-model="model.nome_completo" name = "nomeCompleto" placeholder="Nome Completo">
         </div>
         <div class="col-md-3">
            <label for="validationnomeCompleto"> Cpf </label>
            <label class="sr-only" for="inlineFormInput">Cpf</label>
            <input type="text" class="form-control mb-2" v-model="model.cpf" name="cpf" placeholder="Cpf">
         </div>
      </div>
      
      <div class="form-row align-items-center">
         <div class="col-md-3">
            <label for="validationnomeCompleto"> E-mail</label>
            <label class="sr-only" for="inlineFormInput">E-mail</label>
            <input type="text" class="form-control mb-2" v-model="model.email" name="email" placeholder="E-mail">
         </div>
         <div class="col-md-3">
            <label for="validationnomeCompleto"> Data de Nascimento </label>
            <label class="sr-only" for="inlineFormInput">Data de Nascimento</label>
            <input type="date" class="form-control mb-2" v-model="model.data_nascimento" name="dataNascimento" placeholder="Data de Nascimento">
         </div>
      </div>
      
      <div class="form-row align-items-center">
         <div class="col-sm-1">
            <label for="validationnomeCompleto"> DDD </label>
            <label class="sr-only" for="inlineFormInput">DDD</label>
            <input type="text" class="form-control mb-2" v-model="telefone.ddd" name="ddd" placeholder="DDD">
         </div>
         <div class="col-md-2">
            <label for="validationnomeCompleto"> Telefone</label>
            <label class="sr-only" for="inlineFormInput">Telefone</label>
            <input type="text" class="form-control mb-2" v-model="telefone.numero" name="telefone" placeholder="Telefone">
         </div>
         <div class="col-auto">
            <br>
            <button type="button" @click="addTelefone(telefone)" class="btn btn-primary mb-2">Adicionar</button>
         </div>
      </div>
      <button type="submit" class="btn btn-primary mb-2" @click="salvar()">Editar</button>
      <table class="table table-bordered col-md-8">
         <thead>
            <tr>
               <th scope="col">Id</th>
               <th scope="col">DDD</th>
               <th scope="col">Telefone</th>
               <th scope="col">Ações</th>
            </tr>
         </thead>
         <tbody>
            <tr v-for="telefone in model.telefones" v-bind:key="telefone.rowid">
               <th scope="row">{{telefone.rowid}}</th>
               <td>{{telefone.ddd}}</td>
               <td>{{telefone.numero}}</td>
               <td>
                  <button @click="deletar(telefone.rowid)">deletar</button>
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
                telefone: {},
                model: {
                    telefones: []
                },
                rowid: 1
            }
        },
        props: ['pessoa'],
        mounted () {
           this.model = Object.assign({}, this.pessoa);
           for (const telefone of this.model.telefones) {
              telefone.rowid = this.rowid;
              this.rowid++;
           }
        },
        methods: {
            addTelefone: function (telefone) {
                let tel = Object.assign({}, telefone);

                tel.rowid = this.rowid;
                this.rowid++;

                this.model.telefones.push(tel);
            }, deletar: function (id) {
               let index = this.model.telefones.map((e) => {
                  return e.rowid;
               }).indexOf(id);

               this.model.telefones.splice(index, 1);
            }, salvar: function () {
               axios.put('/pessoas/'+ this.model.id, this.model).then((response) => {
                  window.location = '/pessoas';
               }, (err) => {
                  window.alert('Ops! Ocorreu um erro durante o cadastro, verifique suas informações.');
                  console.log('erro: '+err);
               });
            }
        }
    }
</script>
