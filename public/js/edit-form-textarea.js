class TextareaInput{

    render(data){
        let content = `
            <div class="form-section-heading d-flex justify-content-between">
                    <div class="menu"><span></span><span></span><span></span></div>
                    <div class="title">Название поля</div>
                    <div class="delete"><i class="bi bi-trash3-fill"></i></div>
                </div>
                <div class="form-section-settings" id="form-section-settings">
                <div class="form-section-type d-flex" id="${data.id}">
                    <div class="label">Тип поля</div>
                    <select name="form_section_type">
                        <option value="text">Текст</option>
                        <option value="textarea" selected>Текстовое поле</option>
                        <option value="select">Выбор</option>
                        <option value="file">Загрузка файла</option>
                    </select>
                </div>

                <div class="form-input d-flex">
                    <div class="label">Название поля</div>
                    <div class="input"><input type="text" placeholder="${data.question}" name='question-${data.id}}'"/></div>
                </div>
                <div class="form-input d-flex">
                    <div class="label">Служебное имя</div>
                    <div class="input"><input type="text" placeholder="${data.name}" name="placeholder-${data.id}"/></div>
                </div>
                <div class="form-input d-flex">
                    <div class="label">Подсказка</div>
                    <div class="input"><input type="text" placeholder="${data.placeholder}" name='placeholder-${data.id}'/></div>
                </div>
                <div class="form-input d-flex">
                    <div class="label">Обязательно для заполнения</div>
                    <div class="input">
                        <div>
                            <input type="radio" id="yes" name="required-${data.id}" value="yes" checked />
                            <label for="yes">Да</label>
                        </div>

                        <div>
                            <input type="radio" id="no" name="required-${data.id}" value="no" />
                            <label for="no">Нет</label>
                        </div>
                    </div>
                </div>
            </div>
        `
        return htmlContainer('div', content, ['form-section'])
    }
}