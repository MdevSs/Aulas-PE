function endereco(value) {
    var request = new XMLHttpRequest();

    request.open("GET", "https://viacep.com.br/ws/" + value + "/json/");
    request.send();
    
    request.onload = function(){
        resposta = JSON.parse(request.responseText);

        document.querySelector("label.resposta").innerText = resposta.logradouro + ", " + resposta.bairro + ", " + resposta.localidade + ", " + resposta.uf
        document.querySelector("input.logradouro").value = resposta.logradouro
        document.querySelector("input.bairro").value = resposta.bairro
        document.querySelector("input.cidade").value = resposta.localidade
        document.querySelector("input.estado").value = resposta.uf
    }
}