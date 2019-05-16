// -------------------------------------------------------------
// Contact Form
// -------------------------------------------------------------

let myForm = {

    initForm: function(){

        $('#contactForm').on('submit',function(e){
            e.preventDefault();

            // retourne GET()
            let $action = $(this).prop('action');
            // retourne le données en une chaîne de caractères compatible dans un req Ajax
            let $data = $(this).serialize();
            let $this = $(this);

            $this.prevAll('.alert').remove();

            // Envoyer une réponse
            $.post($action, $data, function(data){

                if(data.response === 'error'){
                    
                    $this.before('<div class="alert alert-danger">'+ data.msgAlert +'</div>');
                    $this.find('input, textarea').css('border', 'thin solid #ff0000');
                }

                if(data.response === 'success'){

                    $this.after('<div class="alert alert-success">'+ data.msgAlert +'</div>');
                    $this.find('input, textarea').css('border', 'thin solid #00ff00').val();
                }
            }, "json");
        });


    }
};