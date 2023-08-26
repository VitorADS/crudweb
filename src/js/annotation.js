async function getAnnotation(id){
    const headers = new Headers({
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    })

    let response = await fetch(`/crudweb/annotation?id=${id}`, {
        method: 'GET',
        headers: headers,
        credentials: 'same-origin'
    });

    let responseResult = await response.json();

    if(responseResult.success){
        await buildForm(responseResult);
    } else{
        alert(responseResult.message);
        window.location.reload();
    }
}

async function buildForm(response){
    let id = document.querySelector('#id');
    let title = document.querySelector('#title');
    let header = document.querySelector('#header');
    let text = document.querySelector('#text');
    let modalTitle = document.querySelector('#modal-title')

    if(document.body.contains(id) && document.body.contains(title) && document.body.contains(header) && document.body.contains(text)){
        id.value = response.annotation.id;
        title.value = response.annotation.title;
        header.value = response.annotation.header;
        text.value = response.annotation.text;
        modalTitle.textContent = 'Edite sua anotação:';
    }
}

function unbuildForm(){
    let id = document.querySelector('#id');
    let title = document.querySelector('#title');
    let header = document.querySelector('#header');
    let text = document.querySelector('#text');
    let modalTitle = document.querySelector('#modal-title')

    if(document.body.contains(id) && document.body.contains(title) && document.body.contains(header) && document.body.contains(text)){
        id.value = '';
        title.value = '';
        header.value = '';
        text.value = '';
        modalTitle.textContent = 'Crie sua anotação:';
    }
}