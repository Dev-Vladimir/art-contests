let counter = initCounter(false);

class InputText{
    getHtml(id){
        let formSection = html('div', false, ['form-section']);
        let formSectionSettings = html('div', false, ['form-section-settings']);
        let formSectionHeading = html('div', getFormSectionHeading(), ['form-section-heading', 'd-flex', 'justify-content-between']);
        let formSectionTypes = html('div', getFormSectionTypes(), ['form-section-type', 'd-flex']);
        // console.log(formSection);
        let inputRadio = html('div', getInputRadio(id), ['form-input', 'd-flex']);
        let inputTitle = formInput('text', 'Введите название поля', 'title-' + id);
        let inputSerciceName = formInput('text', 'Введите служебное имя', 'service_name-' + id);
        let inputPlaceholder = formInput('text', 'Введите подсказку для заполнения', 'placeholder-' + id);

        formSectionSettings.append(formSectionTypes, inputTitle, inputSerciceName, inputPlaceholder, inputRadio)
        formSection.append(formSectionHeading, formSectionSettings)
        // console.log(formSection);
        return formSection;
    }
}
function getFormSectionHeading(){
    return `<div class="menu"><span></span><span></span><span></span></div>
                    <div class="title">Название поля</div>
                    <div class="delete"><i class="bi bi-trash3-fill"></i></div>
                </div>
            `
}

function getFormSectionTypes(){
    return `<div class="form-section-type d-flex">
            <div class="label">Тип поля</div>
            <div class="field-types d-flex justify-content-between">
                <div class="field-types-button active">текст</div>
                <div class="field-types-button">текстовое поле</div>
                <div class="field-types-button">выбор</div>
                <div class="field-types-button">загрузка файла</div>
            </div>
    
    `
}

//создание тега
function html(tagName, content = false, classes = []){
    // console.log(classes)
    let tag = document.createElement(tagName);
    if (content) tag.innerHTML = content;
    if (classes.lenght !== 0){
        classes.forEach(className => {
            tag.classList.add(className);
        })
    }
    return tag;
}

// создание инпута
function input(varName, type, placeholder = false, classes = []){
    let inputDiv = html('div', false, ['input']);
    let input = document.createElement('input');
    input.type = type
    if (placeholder) input.placeholder = placeholder;
    input.name = varName;
    if (classes.lenght !== 0){
        classes.forEach(className => {
            tag.classList.add(className);
        })
    }
    inputDiv.append(input);
    return inputDiv;
}

// создание радио кнопки
function getInputRadio(id){
    return `
        <div class="label">Обязательно для заполнения</div>
        <div class="input">
            <div>
                <input type="radio" id="yes-${id}" name="required-${id}" value="yes" checked />
                <label for="yes-${id}">Да</label>
            </div>

            <div>
                <input type="radio" id="no-${id}" name="required-${id}" value="no" />
                <label for="no">Нет</label>
            </div>
        </div>
    `
}





function formInput(type, message, serviceName){
    let formInput = html('div', false, ['form-input', 'd-flex']);
    let label = html('div', message, ['label']);
    let inputHtml = input(serviceName, type, message);
    formInput.append(label, inputHtml);
    return formInput;
}



function initCounter(id = false){
    // console.log(id);
    if (id) return id + 1;
    else return document.querySelectorAll('.form-section').length + 1;
}

document.getElementById('add-field').addEventListener('click', function(){
    counter = initCounter(counter);
    let input = new InputText();
    let formSection = input.getHtml(counter);
    initDeleteButton(formSection)
    document.getElementById('form-settings').append(formSection);
})


function initDeleteButton(formSection){
    // console.log(formSection.querySelector('.delete'));
    formSection.querySelector('.delete').addEventListener('click', () => formSection.remove());
}

(function() {
    counter = initCounter(counter);
    toggleManager.init();
    document.querySelectorAll('.form-section').forEach(formSection => {initDeleteButton(formSection)})
})();
