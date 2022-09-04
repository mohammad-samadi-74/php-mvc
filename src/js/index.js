import $ from 'jquery';
require('bootstrap/dist/js/bootstrap.bundle')

$(document).ready(function(){
    if (document.getElementById('timer') !== null){
        let timer = document.getElementById('timer');
        let email = document.getElementById('email').value;
        console.log(email)
        let t = setInterval(function(timer){
            if(timer.innerHTML == '0'){
                clearInterval(t);
                timer.parentNode.innerHTML = `<span class='btn btn-sm btn-primary' id='addNewToken'> make new token</span>`

                $('#addNewToken').click((e)=>{
                    $.ajax({
                        url: '/generateNewToken',
                        method: 'post',
                        data: {email},
                        success: function (r) {
                            location.reload();
                        },
                        error : (r)=>{
                            console.log(r)
                        }
                    })
                })
                return;
            }
            timer.innerHTML = eval(timer.innerHTML) - 1;
        },1000,timer)
    }

})



