<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Send Mass DM</div>

                    <div class="panel-body">
                        <textarea v-model="message" class="form-control" placeholder="Add DM Here"></textarea>
                        <button class="btn btn-info" v-on:click="sendDM()">
                    </div>
                </div>
            </div>
        </div>
      </div>
</template>

<script>
export default {
    mounted() {

        console.log('Component mounted.')
    },
    data(){
      return {
        message: ''
      }
    },
    created(){

    },
  methods: {
    sendDM: function(){
      var that = this;
      axios.post('/api/dm/send',{
        'message' : this.message
      }).then(function(data){
        alert(data.data.message);
      }).catch(function(error){
        alert(error.message);
      });
    }

  }
}
</script>
