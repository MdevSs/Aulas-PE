    let oDadosAjax;

    let tabelas = document.querySelectorAll('.toogle-button');

    let ativado = document.querySelector('.toogleOn');

    function fnReqURL(value){
        let txtURL;
        value.classList.forEach(classes =>{
            switch(classes)
            {
                case 'tables':
                    txtURL = `nTipo=1&txtTabela=${value.dataset.tipo}&nFuncao=null`;    
                break;
                case 'relatorio':
                    txtURL = `nTipo=2&$txtTabela=null&nFuncao=${value.dataset.tipo}&txtParametro=${value.value}`;
                break;
            }
        })
        
        return txtURL;     
    }

    function MostraDados(dados){
        let oConteudo = document.querySelector('.content-itens table');

        oConteudo.innerHTML = '<thead></thead>'
                            +'<tbody></tbody>';
                            
        let oTabelaCabeca = oConteudo.children[0];
        let oTabelaCorpo = oConteudo.children[1];

        let indices = Object.keys(dados[0]);
        console.log(indices);
        indices.forEach(valor =>{
            let tColuna = document.createElement('th');
            tColuna.textContent = valor.toUpperCase();    
            oTabelaCabeca.append(tColuna);
        })
        indices = null;
        dados.forEach((valor, indice)=>{
            let oLinha = document.createElement('tr');
            
            for(index in valor)
            {
                console.log(valor[index]);
                let oValores = document.createElement('td');
                oValores.textContent = valor[index];
                oLinha.append(oValores);
            }
            console.log(oLinha);
            oTabelaCorpo.append(oLinha);
        });
        console.log(oTabelaCorpo);


    }

    function fnAjax(value){
        console.log(`API/api-json.php?${fnReqURL(value)}`);
        fetch(`API/api-json.php?${fnReqURL(value)}`)
            .then(response => response.json())
            .then(data =>{
                oDadosAjax = data;
                console.log(oDadosAjax);
                MostraDados(oDadosAjax);
            }).catch(error => console.error('Erro:'+ error));
    }

    tabelas.forEach(element => {
        element.addEventListener('click', (e)=>{
            ativado = document.querySelector('.toogleOn');
            if(ativado.classList.contains('toogleOn')){
                ativado.classList.remove('toogleOn')
                ativado.style.color = "#eeeeff";
            }
            element.classList.add('toogleOn');
            element.style.color = "#00CC00";
            fnAjax(e.target);
    })
    });

    const buttonOpen = document.querySelector('.openButton');

    buttonOpen.addEventListener('click', (e)=>{
        let sideBarContents = document.querySelectorAll('.tables, .reports');
        let sideBar = document.querySelector('.side-bar');
        if(!sideBar.classList.contains('close')){
            buttonOpen.style.transform = 'translate(0px)';
            buttonOpen.children[0].style.transform = 'rotate(0deg)';
            sideBar.classList.toggle('close');
            sideBar.children[1].classList.toggle('invisible');
            sideBar.children[2].classList.toggle('invisible');
        }
        else{

            buttonOpen.style.transform = 'translate(20vw)';
            buttonOpen.children[0].style.transform = 'rotate(180deg)';
            sideBar.classList.toggle('close');
            sideBar.children[1].classList.toggle('invisible');
            sideBar.children[2].classList.toggle('invisible');
        }
        
    })

    document.querySelectorAll('.reports .search .form-relatorio').forEach(element =>{
        element.addEventListener('submit', (e)=>{
            e.preventDefault();
            console.log(e.target);
            console.log(e.target.children[0]);
            e.target.children[0].classList.add('relatorio');
            fnAjax(e.target.children[0]);
            // fnAjax(e.target);
        })
    })

    document.querySelectorAll('.search .search-header i.fa-chevron-right').forEach(elemento =>{
        console.log(elemento);
        elemento.addEventListener('click', (e)=>{
            if(e.target.style.transform == 'rotate(90deg)')
                e.target.style.transform = 'rotate(0deg)';
            else
                e.target.style.transform = 'rotate(90deg)';

            e.target.parentElement.parentElement.classList.toggle('show');
        });
    })

    document.querySelector('select').addEventListener('change', (e)=>{
        console.log('Mudow');
        console.log(e);
        console.log(e.target);
        console.log(e.target.value);
        fnAjax(e.target);
    });

    document.querySelectorAll('#form-radios input[type="radio"]').forEach(element =>{
        element.addEventListener('change', (e)=>{
            console.log(e.target);
            fnAjax(e.target);
        })
    });

    document.querySelector('#button-submit').addEventListener('click', (e)=>{
        let dtValores = document.querySelectorAll('.interval input');

        dtValores.forEach(valor =>{
            console.log(valor.value);
        })
    });

    document.querySelector('input[name="optRange"]').addEventListener('change', (e)=>{
        let content = document.querySelector('.interval-range');
            content.classList.add('down');
        });

    document.querySelectorAll('input[name="optRange"]')[1].addEventListener('click', ()=>{
        document.querySelector('.interval-range').classList.remove('down');
    })

    document.querySelector('#form-emprestimo').addEventListener('submit', (e)=>{
        e.preventDefault();
        console.log("enviou");
        let data={};
        data.date={};
        if(document.querySelector('input#RangeData').checked){
            data.date={};
            if(document.querySelector('#datainicio').value!=""){
                data.date.datainicio =  document.querySelector('#datainicio').value;
                document.querySelector('#datainicio').style.border = "2px solid #00AA00";
            }else{
                data.date.datainicio = undefined;
                document.querySelector('#datainicio').scrollIntoView({behavior: 'smooth', block: 'center'});
                document.querySelector('#datainicio').style.border = "3px solid #FF0000";
            }

            if(document.querySelector('#datafim').value!=""){
                data.date.datafim = document.querySelector('#datafim').value;
                document.querySelector('#datafim').style.border = "2px solid #00AA00";
            }else{
                data.date.datafim = undefined;
                document.querySelector('#datafim').scrollIntoView({behavior: 'smooth', block: 'center'});
                document.querySelector('#datafim').style.border = "3px solid #FF0000";
            }   
        }else{
            data.date = {
                'datainicio': null,
                'datafim': null
            };
        }

        if(document.querySelector('input[name="optAtrasados"]').checked) {

            data.atrasados = true;

        }else
        {
            data.atrasados = null;
        }

        if(document.querySelector('input#RangeToday').checked) {
            data.today = true;
        }else
            data.today = null;
        console.log(data);
        

        console.log(`API/api-json.php?nTipo=2&txtTabela=null&nFuncao=6&atrasados=${data.atrasados}&today=${data.today}&datainicio=${data.date.datainicio}&datafim=${data.date.datafim}`);
        fetch(`API/api-json.php?nTipo=2&txtTabela=null&nFuncao=6&atrasados=${data.atrasados}&today=${data.today}&datainicio=${data.date.datainicio}&datafim=${data.date.datafim}`)
        .then(response=>response.json())
        .then(data => {
            oDadosAjax = data;
                console.log(oDadosAjax);
                MostraDados(oDadosAjax);
            }).catch(error => console.error('Erro:'+ error));
        });
    