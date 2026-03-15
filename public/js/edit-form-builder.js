// const fieldset = {
//   "formName": "Динамическая форма",
//   "fields": [
//     {
//       "id": "17711401410sasad806egvd",
//       "type": "text",
//       "question" : "Вопрос формы",
//       "placeholder": "Текст",
//       "name": "text",
//       "required": true,
//       "settings": {}
//     },
//     {
//       "id": "1771144201233sezsl",
//       "type": "textarea",
//       "question": "аччсм чс",
//       "placeholder": "подсказка для текстового поля",
//       "name": "jhkJh",
//       "required": true,
//       "settings": {}
//     }
//   ],
//   "createdAt": "2026-02-15T08:30:01.233Z",
//   "totalFields": 2
// }



// class FormBuilder {
//     constructor(containerId, initialJson = null) {
//         this.container = document.getElementById(containerId);
//         if (!this.container) {
//             throw new Error(`Container #${containerId} not found`);
//         }
        
//         this.formData = initialJson || this.getEmptyFormData();
//         this.init();
//     }
    
//     getEmptyFormData() {
//         return {
//             formName: "Новая форма",
//             fields: [],
//             createdAt: new Date().toISOString(),
//             totalFields: 0
//         };
//     }
    
//     init() {
//         this.render();
//         this.attachEventListeners();
//     }
    
//     render() {
//         this.container.innerHTML = '';
//         this.renderFormTitle();
        
//         this.formData.fields.forEach((field, index) => {
//             this.renderFieldSettings(field, index);
//         });
        
//         this.renderAddButton();
//         this.renderSubmitButton();
//         this.formData.totalFields = this.formData.fields.length;
//     }
    
//     renderFormTitle() {
//         const titleHtml = `

//          <div class="form-input d-flex">
//             <div class="label">Название формы</div>
//             <div class="input">
//                 <input type="text" 
//                            value="${this.escapeHtml(this.formData.formName)}" 
//                            placeholder="Название формы"
//                            class="form-title-input">
//             </div>
//         </div>
//         `;
//         this.container.insertAdjacentHTML('beforeend', titleHtml);
//     }
    
//     renderFieldSettings(field, index) {
//         const fieldId = field.id || `field_${Date.now()}_${index}_${Math.random().toString(36).substr(2, 5)}`;
//         field.id = fieldId;
        
//         const settingsId = `settings_${fieldId}`;
//         const toggleId = `toggle_${fieldId}`;
        
//         // Кнопки выбора типа поля (без select)
//         const typeButtons = [
//             { value: 'text', label: 'текст' },
//             { value: 'textarea', label: 'текстовое поле' },
//             { value: 'select', label: 'выбор' },
//             { value: 'file', label: 'загрузка файла' }
//         ];
        
//         const typeButtonsHtml = typeButtons.map(btn => 
//             `<div class="field-types-button ${field.type === btn.value ? 'active' : ''}" 
//                   data-type="${btn.value}">${btn.label}</div>`
//         ).join('');
        
//         // Кнопки сортировки (вверх/вниз)
//         const sortButtons = `
//             <a type class="sort-up-btn" data-field-id="${fieldId}" ${index === 0 ? 'disabled' : ''}>
//                 <i class="bi bi-arrow-up"></i>
//             </a>
//             <a type class="sort-down-btn" data-field-id="${fieldId}" ${index === this.formData.fields.length - 1 ? 'disabled' : ''}>
//                 <i class="bi bi-arrow-down"></i>
//             </a>
//         `;
        
//         // Основной HTML секции — изначально настройки скрыты
//         let html = `
//             <div class="form-section" data-field-id="${fieldId}" data-index="${index}">
//                 <div class="form-section-heading d-flex justify-content-between">
//                     <div class="sort-buttons d-flex">${sortButtons}</div>
//                     <div class="menu"><span></span><span></span><span></span></div>
//                     <div class="title">${this.escapeHtml(field.question || 'Новое поле')}</div>
//                     <div class="delete" data-field-id="${fieldId}"><i class="bi bi-trash3-fill"></i></div>
//                 </div>
//                 <div class="form-section-settings" id="${settingsId}">
//                     <div class="form-section-type d-flex">
//                         <div class="label">Тип поля</div>
//                         <div class="field-types d-flex justify-content-between">
//                             ${typeButtonsHtml}
//                         </div>
//                     </div>
//         `;
        
//         html += this.getFieldTypeSettings(field, fieldId, toggleId);
//         html += `</div></div>`;
        
//         this.container.insertAdjacentHTML('beforeend', html);
        
//         if (field.type === 'select') {
//             this.renderSelectOptions(field, fieldId);
//         }
//     }
    
//     getFieldTypeSettings(field, fieldId, toggleId) {
//         let settings = `
//             <div class="form-input d-flex">
//                 <div class="label">Название поля</div>
//                 <div class="input">
//                     <input type="text" 
//                            placeholder="введите название" 
//                            value="${this.escapeHtml(field.question || '')}"
//                            data-field-id="${fieldId}"
//                            data-setting="question">
//                 </div>
//             </div>
//             <div class="form-input d-flex">
//                 <div class="label">Служебное имя</div>
//                 <div class="input">
//                     <input type="text" 
//                            placeholder="введите имя" 
//                            value="${this.escapeHtml(field.name || '')}"
//                            data-field-id="${fieldId}"
//                            data-setting="name">
//                 </div>
//             </div>
//         `;
        
//         if (field.type === 'text' || field.type === 'textarea') {
//             settings += `
//                 <div class="form-input d-flex">
//                     <div class="label">Подсказка</div>
//                     <div class="input">
//                         <input type="text" 
//                                placeholder="введите подсказку" 
//                                value="${this.escapeHtml(field.placeholder || '')}"
//                                data-field-id="${fieldId}"
//                                data-setting="placeholder">
//                     </div>
//                 </div>
//             `;
//         }
        
//         if (field.type === 'select') {
//             settings += `
//                 <div class="form-input d-flex">
//                     <div class="label">Варианты ответов</div>
//                     <div class="input">
//                         <div class="select-options-container" id="options_${fieldId}"></div>
//                         <button type="button" 
//                                 class="add-option-btn" 
//                                 data-field-id="${fieldId}">
//                             <i class="bi bi-plus-circle"></i> Добавить вариант
//                         </button>
//                     </div>
//                 </div>
//             `;
//         }
        
//         if (field.type === 'file') {
//             const allowedFormats = field.allowedFormats || ['jpeg', 'png', 'pdf'];
//             const maxSize = field.maxSize || 2;
            
//             settings += `
//                 <div class="form-input d-flex">
//                     <div class="label">Поддерживаемые форматы</div>
//                     <div class="input">
//                         <div class="formats-checkboxes">
//                             <label><input type="checkbox" value="jpeg" ${allowedFormats.includes('jpeg') ? 'checked' : ''} data-field-id="${fieldId}" data-setting="allowedFormats" data-format="jpeg"> JPEG</label>
//                             <label><input type="checkbox" value="png" ${allowedFormats.includes('png') ? 'checked' : ''} data-field-id="${fieldId}" data-setting="allowedFormats" data-format="png"> PNG</label>
//                             <label><input type="checkbox" value="pdf" ${allowedFormats.includes('pdf') ? 'checked' : ''} data-field-id="${fieldId}" data-setting="allowedFormats" data-format="pdf"> PDF</label>
//                         </div>
//                     </div>
//                 </div>
//                 <div class="form-input d-flex">
//                     <div class="label">Максимальный размер</div>
//                     <div class="input">
//                         <input type="number" value="${maxSize}" min="1" max="10" data-field-id="${fieldId}" data-setting="maxSize"> МБ
//                     </div>
//                 </div>
//             `;
//         }
        
//         // Ползунок (toggle) для поля "Обязательно для заполнения"
//         settings += `
//             <div class="form-input d-flex">
//                 <div class="label">Обязательно для заполнения</div>
//                 <div class="input">
//                     <label class="toggle-switch" for="${toggleId}">
//                         <input type="checkbox" 
//                                id="${toggleId}"
//                                ${field.required ? 'checked' : ''}
//                                data-field-id="${fieldId}"
//                                data-setting="required">
//                         <span class="toggle-slider"></span>
//                     </label>
//                     <span class="toggle-label" id="label_${toggleId}">${field.required ? 'Да' : 'Нет'}</span>
//                 </div>
//             </div>
//         `;
        
//         return settings;
//     }
    
//     renderSelectOptions(field, fieldId) {
//         const container = document.getElementById(`options_${fieldId}`);
//         if (!container) return;
//         const options = field.options || [{ value: '', label: '' }];
//         container.innerHTML = options.map((opt, idx) => `
//             <div class="select-option-row d-flex" data-option-index="${idx}">
//                 <input type="text" class="option-value" placeholder="Значение" value="${this.escapeHtml(opt.value || '')}" data-field-id="${fieldId}" data-option-index="${idx}" data-option-field="value">
//                 <input type="text" class="option-label" placeholder="Текст" value="${this.escapeHtml(opt.label || '')}" data-field-id="${fieldId}" data-option-index="${idx}" data-option-field="label">
//                 <button type="button" class="remove-option-btn" data-field-id="${fieldId}" data-option-index="${idx}"><i class="bi bi-trash"></i></button>
//             </div>
//         `).join('');
//     }
    
//     renderAddButton() {
//         const buttonHtml = `<div class="button add-field" id="addFieldBtn"><i class="bi bi-plus-circle"></i> Добавить поле</div>`;
//         this.container.insertAdjacentHTML('beforeend', buttonHtml);
//     }
//     renderSubmitButton() {
//         const buttonHtml = `<button type="button" id="submit" class="form-builder-save-btn">Сохранить</button>`;
//         this.container.insertAdjacentHTML('beforeend', buttonHtml);
//     }
    
//     attachEventListeners() {
//         this.container.addEventListener('click', (e) => {
//             // Открытие/закрытие настроек по клику на бургер
//             if (e.target.closest('.menu')) {
//                 e.preventDefault(); // Предотвращаем случайное выделение текста или другие действия
//                 const section = e.target.closest('.form-section');
//                 if (section) {
//                     const settings = section.querySelector('.form-section-settings');
//                     if (settings) {
//                         settings.classList.toggle('visible');
//                     }
//                 }
//                 return;
//             }
            
//             // Добавление поля
//             if (e.target.closest('#addFieldBtn') || e.target.closest('.add-field-btn')) {
//                 e.preventDefault();
//                 this.addNewField();
//                 return;
//             }
            
//             // Кнопки выбора типа поля
//             const typeButton = e.target.closest('.field-types-button');
//             if (typeButton) {
//                 const section = typeButton.closest('.form-section');
//                 if (section) {
//                     const fieldId = section.dataset.fieldId;
//                     const newType = typeButton.dataset.type;
//                     section.querySelectorAll('.field-types-button').forEach(btn => btn.classList.remove('active'));
//                     typeButton.classList.add('active');
//                     this.updateFieldType(fieldId, newType);
//                 }
//                 return;
//             }
            
//             // Удаление поля
//             if (e.target.closest('.delete')) {
//                 const deleteBtn = e.target.closest('.delete');
//                 const fieldId = deleteBtn.dataset.fieldId;
//                 if (fieldId) this.deleteField(fieldId);
//                 return;
//             }
            
//             // Добавление варианта для select
//             if (e.target.closest('.add-option-btn')) {
//                 const btn = e.target.closest('.add-option-btn');
//                 const fieldId = btn.dataset.fieldId;
//                 this.addSelectOption(fieldId);
//                 return;
//             }
            
//             // Удаление варианта для select
//             if (e.target.closest('.remove-option-btn')) {
//                 const btn = e.target.closest('.remove-option-btn');
//                 const fieldId = btn.dataset.fieldId;
//                 const idx = btn.dataset.optionIndex;
//                 this.removeSelectOption(fieldId, parseInt(idx));
//                 return;
//             }
            
//             // Сортировка вверх
//             if (e.target.closest('.sort-up-btn')) {
//                 const btn = e.target.closest('.sort-up-btn');
//                 if (btn.disabled) return;
//                 this.moveFieldUp(btn.dataset.fieldId);
//                 return;
//             }
            
//             // Сортировка вниз
//             if (e.target.closest('.sort-down-btn')) {
//                 const btn = e.target.closest('.sort-down-btn');
//                 if (btn.disabled) return;
//                 this.moveFieldDown(btn.dataset.fieldId);
//                 return;
//             }
//             //отправка формы
//             if (e.target.closest('.form-builder-save-btn')) {
//                 e.preventDefault();
//                 this.saveFormData();
//                 return;
//             }


//         });
        
//         this.container.addEventListener('input', (e) => {
//             const target = e.target;
//             if (target.dataset.fieldId && target.dataset.setting) {
//                 this.updateFieldSetting(target.dataset.fieldId, target.dataset.setting, target.value);
//                 return;
//             }
//             if (target.dataset.fieldId && target.dataset.optionIndex !== undefined) {
//                 this.updateSelectOption(target.dataset.fieldId, parseInt(target.dataset.optionIndex), target.dataset.optionField, target.value);
//                 return;
//             }
//             if (target.classList.contains('form-title-input')) {
//                 this.formData.formName = target.value;
//                 this.saveToLocalStorage();
//                 this.rerenderFormFields();
//             }
//         });
        
//         this.container.addEventListener('change', (e) => {
//             const target = e.target;
//             if (target.matches('input[type="checkbox"][data-setting="required"]')) {
//                 const fieldId = target.dataset.fieldId;
//                 const checked = target.checked;
//                 const label = document.getElementById(`label_${target.id}`);
//                 if (label) label.textContent = checked ? 'Да' : 'Нет';
//                 this.updateFieldSetting(fieldId, 'required', checked);
//                 return;
//             }
//             if (target.matches('input[type="checkbox"][data-setting="allowedFormats"]')) {
//                 this.updateFileFormats(target.dataset.fieldId, target.dataset.format, target.checked);
//                 return;
//             }
//             if (target.matches('input[type="number"][data-setting="maxSize"]')) {
//                 this.updateFieldSetting(target.dataset.fieldId, 'maxSize', parseInt(target.value) || 2);
//                 return;
//             }
//         });
//     }
    
//     // Методы сортировки
//     moveFieldUp(fieldId) {
//         const index = this.formData.fields.findIndex(f => f.id === fieldId);
//         if (index <= 0) return;
//         this.reorderFields(index, index - 1);
//     }
    
//     moveFieldDown(fieldId) {
//         const index = this.formData.fields.findIndex(f => f.id === fieldId);
//         if (index === -1 || index >= this.formData.fields.length - 1) return;
//         this.reorderFields(index, index + 1);
//     }
    
//     reorderFields(oldIndex, newIndex) {
//         const fields = [...this.formData.fields];
//         const [moved] = fields.splice(oldIndex, 1);
//         fields.splice(newIndex, 0, moved);
//         this.formData.fields = fields;
//         this.render();
//         this.rerenderFormFields();
//         this.saveToLocalStorage();
//     }
    
//     // Обновление типа поля
//     updateFieldType(fieldId, newType) {
//         const index = this.formData.fields.findIndex(f => f.id === fieldId);
//         if (index === -1) return;
        
//         const old = this.formData.fields[index];
//         const updated = {
//             id: fieldId,
//             type: newType,
//             question: old.question || '',
//             name: old.name || '',
//             required: old.required || false,
//             settings: {}
//         };
        
//         // Переносим специфические поля
//         if (newType === 'text' || newType === 'textarea') {
//             updated.placeholder = old.placeholder || '';
//         } else if (newType === 'select') {
//             updated.options = old.options || [{ value: '', label: '' }];
//         } else if (newType === 'file') {
//             updated.allowedFormats = old.allowedFormats || ['jpeg', 'png', 'pdf'];
//             updated.maxSize = old.maxSize || 2;
//         }
        
//         this.formData.fields[index] = updated;
//         this.render();
//         this.rerenderFormFields();
//         this.saveToLocalStorage();
//     }
    
//     // Обновление отдельной настройки поля
//     updateFieldSetting(fieldId, setting, value) {
//         const field = this.formData.fields.find(f => f.id === fieldId);
//         if (!field) return;
        
//         field[setting] = value;
        
//         if (setting === 'question') {
//             const titleEl = this.container.querySelector(`.form-section[data-field-id="${fieldId}"] .title`);
//             if (titleEl) titleEl.textContent = value || 'Новое поле';
//         }
        
//         this.saveToLocalStorage();
//         this.rerenderFormFields();
//     }
    
//     // Работа с вариантами select
//     addSelectOption(fieldId) {
//         const field = this.formData.fields.find(f => f.id === fieldId);
//         if (!field || field.type !== 'select') return;
        
//         if (!field.options) field.options = [];
//         field.options.push({ value: '', label: '' });
//         this.renderSelectOptions(field, fieldId);
//         this.saveToLocalStorage();
//         this.rerenderFormFields();
//     }
    
//     removeSelectOption(fieldId, optionIndex) {
//         const field = this.formData.fields.find(f => f.id === fieldId);
//         if (!field || !field.options) return;
        
//         field.options.splice(optionIndex, 1);
//         if (field.options.length === 0) field.options.push({ value: '', label: '' });
        
//         this.renderSelectOptions(field, fieldId);
//         this.saveToLocalStorage();
//         this.rerenderFormFields();
//     }
    
//     updateSelectOption(fieldId, optionIndex, prop, value) {
//         const field = this.formData.fields.find(f => f.id === fieldId);
//         if (!field || !field.options || !field.options[optionIndex]) return;
        
//         field.options[optionIndex][prop] = value;
//         this.saveToLocalStorage();
//         this.rerenderFormFields();
//     }
    
//     // Работа с форматами файлов
//     updateFileFormats(fieldId, format, checked) {
//         const field = this.formData.fields.find(f => f.id === fieldId);
//         if (!field) return;
        
//         if (!field.allowedFormats) field.allowedFormats = [];
        
//         if (checked && !field.allowedFormats.includes(format)) {
//             field.allowedFormats.push(format);
//         } else if (!checked) {
//             field.allowedFormats = field.allowedFormats.filter(f => f !== format);
//         }
        
//         if (field.allowedFormats.length === 0) {
//             field.allowedFormats = ['jpeg'];
//             // Вернуть чекбокс
//             setTimeout(() => {
//                 const cb = this.container.querySelector(`input[type="checkbox"][data-field-id="${fieldId}"][data-format="jpeg"]`);
//                 if (cb) cb.checked = true;
//             }, 0);
//         }
        
//         this.saveToLocalStorage();
//         this.rerenderFormFields();
//     }
    
//     // Добавление нового поля
//     addNewField() {
//         const newField = {
//             id: `field_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`,
//             type: "text",
//             question: "Новое поле",
//             placeholder: "",
//             name: `field_${this.formData.fields.length + 1}`,
//             required: false,
//             settings: {}
//         };
//         this.formData.fields.push(newField);
//         this.render();
//         this.rerenderFormFields();
//     }
    
//     // Удаление поля
//     deleteField(fieldId) {
//         this.formData.fields = this.formData.fields.filter(f => f.id !== fieldId);
//         this.render();
//         this.rerenderFormFields();
//     }

//     //отправка формы
//     saveFormData() {
//         // 1. Находим форму, в которой лежит контейнер
//         const form = this.container.closest('form');
//         console.log('🔍 Форма:', form);

//         // 2. Проверяем, что форма действительно найдена
//         if (!form || !(form instanceof HTMLFormElement)) {
//             console.error('Форма не найдена. Убедитесь, что контейнер находится внутри <form>.');
//             return;
//         }

//         // 3. Проверяем наличие атрибута action (если нет — форма уйдёт на текущий URL, но лучше указать)
//         if (!form.action) {
//             console.warn('⚠️ У формы нет атрибута action, отправка произойдёт на текущий URL');
//         }

//         // 4. Удаляем предыдущее скрытое поле (чтобы не дублировать)
//         const oldField = form.querySelector('input[name="form_builder_data"]');
//         if (oldField) oldField.remove();

//         // 5. Создаём новое скрытое поле с данными
//         const hiddenField = document.createElement('input');
//         hiddenField.type = 'hidden';
//         hiddenField.name = 'form_builder_data';
//         try {
//             hiddenField.value = JSON.stringify(this.formData);
//         } catch (e) {
//             console.error('Ошибка JSON.stringify:', e);
//             alert('Не удалось преобразовать данные для отправки');
//             return;
//         }

//         // 6. Проверяем размер данных (необязательно, но полезно)
//         const dataSize = hiddenField.value.length;
//         console.log(`📦 Размер данных: ${dataSize} байт`);
//         if (dataSize > 5 * 1024 * 1024) {
//             console.warn('Данные слишком большие (>5MB), сервер может их не принять');
//         }

//         // 7. Добавляем поле в форму
//         form.appendChild(hiddenField);

//         // 8. Убеждаемся, что в форме есть CSRF-токен (для Laravel)
//         const csrfToken = form.querySelector('input[name="_token"]');
//         if (!csrfToken) {
//             console.warn('В форме не найден CSRF-токен. Сервер может вернуть ошибку 419.');
//         }

//         // 9. ВАЖНО: выводим всё, что будет отправлено, для отладки
//         console.log('Данные формы перед отправкой:');
//         const formData = new FormData(form);
//         for (let pair of formData.entries()) {
//             console.log(pair[0], pair[1]);
//         }

//         // 10. Отправляем форму с гарантией вызова оригинального метода
//         // Используем setTimeout, чтобы избежать возможных конфликтов с текущим стеком вызовов
//         setTimeout(() => {
//             try {
//                 // Самый надёжный способ вызова submit
//                 HTMLFormElement.prototype.submit.call(form);
//                 console.log('✅ Форма отправлена');
//             } catch (e) {
//                 console.error('❌ Ошибка при вызове submit:', e);
//                 // Пробуем запасной вариант
//                 form.submit();
//             }
//         }, 0);
//     }
    
//     // Генерация HTML предпросмотра полей
//     rerenderFormFields() {
//         const event = new CustomEvent('formBuilderChange', {
//             detail: {
//                 formData: this.formData,
//                 fieldsHtml: this.generateFormFields()
//             }
//         });
//         document.dispatchEvent(event);
//         if (this.onChangeCallback) this.onChangeCallback(this.formData);
//     }
    
//     generateFormFields() {
//         return this.formData.fields.map(field => {
//             const required = field.required ? 'required' : '';
//             switch (field.type) {
//                 case 'textarea':
//                     return `
//                         <div class="form-preview-field">
//                             <label>${this.escapeHtml(field.question)}</label>
//                             <textarea name="${this.escapeHtml(field.name)}" 
//                                       placeholder="${this.escapeHtml(field.placeholder || '')}" 
//                                       ${required}></textarea>
//                         </div>`;
//                 case 'select':
//                     const options = (field.options || []).map(opt => 
//                         `<option value="${this.escapeHtml(opt.value)}">${this.escapeHtml(opt.label)}</option>`
//                     ).join('');
//                     return `
//                         <div class="form-preview-field">
//                             <label>${this.escapeHtml(field.question)}</label>
//                             <select name="${this.escapeHtml(field.name)}" ${required}>
//                                 <option value="">Выберите...</option>
//                                 ${options}
//                             </select>
//                         </div>`;
//                 case 'file':
//                     const formats = (field.allowedFormats || ['jpeg', 'png', 'pdf']).join(', ');
//                     const maxSize = field.maxSize || 2;
//                     return `
//                         <div class="form-preview-field">
//                             <label>${this.escapeHtml(field.question)}</label>
//                             <input type="file" 
//                                    name="${this.escapeHtml(field.name)}" 
//                                    accept=".${(field.allowedFormats || ['jpeg', 'png', 'pdf']).join(',.')}"
//                                    data-max-size="${maxSize}"
//                                    ${required}>
//                             <small>Допустимые форматы: ${formats}. Макс. размер: ${maxSize}МБ</small>
//                         </div>`;
//                 default:
//                     return `
//                         <div class="form-preview-field">
//                             <label>${this.escapeHtml(field.question)}</label>
//                             <input type="text" 
//                                    name="${this.escapeHtml(field.name)}" 
//                                    placeholder="${this.escapeHtml(field.placeholder || '')}" 
//                                    ${required}>
//                         </div>`;
//             }
//         }).join('');
//     }
    
//     // Экранирование HTML
//     escapeHtml(text) {
//         if (!text) return '';
//         const div = document.createElement('div');
//         div.textContent = text;
//         return div.innerHTML;
//     }
    
//     // Сохранение/загрузка в localStorage
//     saveToLocalStorage() {
//         localStorage.setItem('formBuilderData', JSON.stringify(this.formData));
//     }
    
//     loadFromLocalStorage() {
//         const saved = localStorage.getItem('formBuilderData');
//         if (saved) {
//             this.formData = JSON.parse(saved);
//             this.render();
//         }
//     }
    
//     // API методы
//     getFormData() {
//         return this.formData;
//     }
    
//     getFormFieldsHtml() {
//         return this.generateFormFields();
//     }
    
//     onChange(callback) {
//         this.onChangeCallback = callback;
//     }
// }




// // Использование:
// // const formSettings = document.getElementById('form-data').?textContent : fieldset;
// let formDataSettings = document.getElementById('form-data')
// let formSettings = fieldset; // fieldset должна быть определена ранее

// if (formDataSettings) { // проверяем, что элемент существует
//     const content = formDataSettings.textContent || formDataSettings.value; // пробуем оба варианта
//     if (content && typeof content === 'string') {
//         const trimmed = content.trim();
//         if (trimmed) {
//             try {
//                 formSettings = JSON.parse(trimmed);
//             } catch (e) {
//                 console.warn('Ошибка парсинга JSON, используется fallback:', e);
//             }
//         }
//     }
// }
// const builder = new FormBuilder('form-builder', formSettings);

// // Подписка на изменения
// builder.onChange((formData) => {
//     console.log('Форма изменилась:', formData);
//     // Здесь можно обновлять предпросмотр формы
//     document.getElementById('form-preview').innerHTML = builder.getFormFieldsHtml();
// });

// // Для начального рендера предпросмотра
// document.getElementById('form-preview').innerHTML = builder.getFormFieldsHtml();
// document.getElementById('form-preview').insertAdjacentHTML('afterbegin', `<h3 class="form-preview-title">предпросмотр формы</h3> `);


































































const fieldset = {
  "formName": "Динамическая форма",
  "fields": [
    {
      "id": "17711401410sasad806egvd",
      "type": "text",
      "question" : "Вопрос формы",
      "placeholder": "Текст",
      "name": "text",
      "required": true,
      "settings": {}
    },
    {
      "id": "1771144201233sezsl",
      "type": "textarea",
      "question": "аччсм чс",
      "placeholder": "подсказка для текстового поля",
      "name": "jhkJh",
      "required": true,
      "settings": {}
    }
  ],
  "createdAt": "2026-02-15T08:30:01.233Z",
  "totalFields": 2
}

class FormBuilder {
    constructor(containerId, initialJson = null) {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            throw new Error(`Container #${containerId} not found`);
        }
        
        this.formData = initialJson || this.getEmptyFormData();
        this.init();
    }
    
    getEmptyFormData() {
        return {
            formName: "Новая форма",
            fields: [],
            createdAt: new Date().toISOString(),
            totalFields: 0
        };
    }
    
    init() {
        this.render();
        this.attachEventListeners();
    }
    
    render() {
        this.container.innerHTML = '';
        this.renderFormTitle();
        
        this.formData.fields.forEach((field, index) => {
            this.renderFieldSettings(field, index);
        });
        
        this.renderAddButton();
        this.renderSubmitButton();
        this.formData.totalFields = this.formData.fields.length;
    }
    
    renderFormTitle() {
        const titleHtml = `

         <div class="form-input d-flex">
            <div class="label">Название формы</div>
            <div class="input">
                <input type="text" 
                           value="${this.escapeHtml(this.formData.formName)}" 
                           placeholder="Название формы"
                           class="form-title-input">
            </div>
        </div>
        `;
        this.container.insertAdjacentHTML('beforeend', titleHtml);
    }
    
    renderFieldSettings(field, index) {
        const fieldId = field.id || `field_${Date.now()}_${index}_${Math.random().toString(36).substr(2, 5)}`;
        field.id = fieldId;
        
        const settingsId = `settings_${fieldId}`;
        const toggleId = `toggle_${fieldId}`;
        
        // Кнопки выбора типа поля (без select)
        const typeButtons = [
            { value: 'text', label: 'текст' },
            { value: 'textarea', label: 'текстовое поле' },
            { value: 'select', label: 'выбор' },
            { value: 'file', label: 'загрузка файла' }
        ];
        
        const typeButtonsHtml = typeButtons.map(btn => 
            `<div class="field-types-button ${field.type === btn.value ? 'active' : ''}" 
                  data-type="${btn.value}">${btn.label}</div>`
        ).join('');
        
        // Кнопки сортировки (вверх/вниз)
        const sortButtons = `
            <a type class="sort-up-btn" data-field-id="${fieldId}" ${index === 0 ? 'disabled' : ''}>
                <i class="bi bi-arrow-up"></i>
            </a>
            <a type class="sort-down-btn" data-field-id="${fieldId}" ${index === this.formData.fields.length - 1 ? 'disabled' : ''}>
                <i class="bi bi-arrow-down"></i>
            </a>
        `;
        
        // Основной HTML секции — изначально настройки скрыты
        let html = `
            <div class="form-section" data-field-id="${fieldId}" data-index="${index}">
                <div class="form-section-heading d-flex justify-content-between">
                    <div class="sort-buttons d-flex">${sortButtons}</div>
                    <div class="menu"><span></span><span></span><span></span></div>
                    <div class="title">${this.escapeHtml(field.question || 'Новое поле')}</div>
                    <div class="delete" data-field-id="${fieldId}"><i class="bi bi-trash3-fill"></i></div>
                </div>
                <div class="form-section-settings" id="${settingsId}">
                    <div class="form-section-type d-flex">
                        <div class="label">Тип поля</div>
                        <div class="field-types d-flex justify-content-between">
                            ${typeButtonsHtml}
                        </div>
                    </div>
        `;
        
        html += this.getFieldTypeSettings(field, fieldId, toggleId);
        html += `</div></div>`;
        
        this.container.insertAdjacentHTML('beforeend', html);
        
        if (field.type === 'select') {
            this.renderSelectOptions(field, fieldId);
        }
    }
    
    getFieldTypeSettings(field, fieldId, toggleId) {
        let settings = `
            <div class="form-input d-flex">
                <div class="label">Название поля</div>
                <div class="input">
                    <input type="text" 
                           placeholder="введите название" 
                           value="${this.escapeHtml(field.question || '')}"
                           data-field-id="${fieldId}"
                           data-setting="question">
                </div>
            </div>
            <div class="form-input d-flex">
                <div class="label">Служебное имя</div>
                <div class="input">
                    <input type="text" 
                           placeholder="введите имя" 
                           value="${this.escapeHtml(field.name || '')}"
                           data-field-id="${fieldId}"
                           data-setting="name">
                </div>
            </div>
        `;
        
        if (field.type === 'text' || field.type === 'textarea') {
            settings += `
                <div class="form-input d-flex">
                    <div class="label">Подсказка</div>
                    <div class="input">
                        <input type="text" 
                               placeholder="введите подсказку" 
                               value="${this.escapeHtml(field.placeholder || '')}"
                               data-field-id="${fieldId}"
                               data-setting="placeholder">
                    </div>
                </div>
            `;
        }
        
        if (field.type === 'select') {
            settings += `
                <div class="form-input d-flex">
                    <div class="label">Варианты ответов</div>
                    <div class="input">
                        <div class="select-options-container" id="options_${fieldId}"></div>
                        <button type="button" 
                                class="add-option-btn" 
                                data-field-id="${fieldId}">
                            <i class="bi bi-plus-circle"></i> Добавить вариант
                        </button>
                    </div>
                </div>
            `;
        }
        
        if (field.type === 'file') {
            const allowedFormats = field.allowedFormats || ['jpeg', 'png', 'pdf'];
            const maxSize = field.maxSize || 2;
            
            settings += `
                <div class="form-input d-flex">
                    <div class="label">Поддерживаемые форматы</div>
                    <div class="input">
                        <div class="formats-checkboxes">
                            <label><input type="checkbox" value="jpeg" ${allowedFormats.includes('jpeg') ? 'checked' : ''} data-field-id="${fieldId}" data-setting="allowedFormats" data-format="jpeg"> JPEG</label>
                            <label><input type="checkbox" value="png" ${allowedFormats.includes('png') ? 'checked' : ''} data-field-id="${fieldId}" data-setting="allowedFormats" data-format="png"> PNG</label>
                            <label><input type="checkbox" value="pdf" ${allowedFormats.includes('pdf') ? 'checked' : ''} data-field-id="${fieldId}" data-setting="allowedFormats" data-format="pdf"> PDF</label>
                        </div>
                    </div>
                </div>
                <div class="form-input d-flex">
                    <div class="label">Максимальный размер</div>
                    <div class="input">
                        <input type="number" value="${maxSize}" min="1" max="10" data-field-id="${fieldId}" data-setting="maxSize"> МБ
                    </div>
                </div>
            `;
        }
        
        // Ползунок (toggle) для поля "Обязательно для заполнения"
        settings += `
            <div class="form-input d-flex">
                <div class="label">Обязательно для заполнения</div>
                <div class="input">
                    <label class="toggle-switch" for="${toggleId}">
                        <input type="checkbox" 
                               id="${toggleId}"
                               ${field.required ? 'checked' : ''}
                               data-field-id="${fieldId}"
                               data-setting="required">
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label" id="label_${toggleId}">${field.required ? 'Да' : 'Нет'}</span>
                </div>
            </div>
        `;
        
        return settings;
    }
    
    renderSelectOptions(field, fieldId) {
        const container = document.getElementById(`options_${fieldId}`);
        if (!container) return;
        const options = field.options || [{ value: '', label: '' }];
        container.innerHTML = options.map((opt, idx) => `
            <div class="select-option-row d-flex" data-option-index="${idx}">
                <input type="text" class="option-value" placeholder="Значение" value="${this.escapeHtml(opt.value || '')}" data-field-id="${fieldId}" data-option-index="${idx}" data-option-field="value">
                <input type="text" class="option-label" placeholder="Текст" value="${this.escapeHtml(opt.label || '')}" data-field-id="${fieldId}" data-option-index="${idx}" data-option-field="label">
                <button type="button" class="remove-option-btn" data-field-id="${fieldId}" data-option-index="${idx}"><i class="bi bi-trash"></i></button>
            </div>
        `).join('');
    }
    
    renderAddButton() {
        const buttonHtml = `<div class="button add-field" id="addFieldBtn"><i class="bi bi-plus-circle"></i> Добавить поле</div>`;
        this.container.insertAdjacentHTML('beforeend', buttonHtml);
    }
    renderSubmitButton() {
        const buttonHtml = `<button type="button" id="submit" class="form-builder-save-btn">Сохранить</button>`;
        this.container.insertAdjacentHTML('beforeend', buttonHtml);
    }
    
    // Метод для генерации уникального имени поля
    generateUniqueFieldName(question = '') {
        // Берем первые 3 буквы из вопроса, очищаем от спецсимволов
        let base = question
            .toLowerCase()
            .replace(/[^a-z0-9]/gi, '')
            .substring(0, 10);
        
        // Если base пустой, используем 'field'
        if (!base) base = 'field';
        
        // Добавляем уникальный суффикс
        const suffix = Math.random().toString(36).substring(2, 6);
        const timestamp = Date.now().toString().slice(-4);
        
        return `${base}_${suffix}${timestamp}`;
    }
    
    attachEventListeners() {
        this.container.addEventListener('click', (e) => {
            // Открытие/закрытие настроек по клику на бургер
            if (e.target.closest('.menu')) {
                e.preventDefault();
                const section = e.target.closest('.form-section');
                if (section) {
                    const settings = section.querySelector('.form-section-settings');
                    if (settings) {
                        settings.classList.toggle('visible');
                    }
                }
                return;
            }
            
            // Добавление поля
            if (e.target.closest('#addFieldBtn') || e.target.closest('.add-field-btn')) {
                e.preventDefault();
                this.addNewField();
                return;
            }
            
            // Кнопки выбора типа поля
            const typeButton = e.target.closest('.field-types-button');
            if (typeButton) {
                const section = typeButton.closest('.form-section');
                if (section) {
                    const fieldId = section.dataset.fieldId;
                    const newType = typeButton.dataset.type;
                    section.querySelectorAll('.field-types-button').forEach(btn => btn.classList.remove('active'));
                    typeButton.classList.add('active');
                    this.updateFieldType(fieldId, newType);
                }
                return;
            }
            
            // Удаление поля
            if (e.target.closest('.delete')) {
                const deleteBtn = e.target.closest('.delete');
                const fieldId = deleteBtn.dataset.fieldId;
                if (fieldId) this.deleteField(fieldId);
                return;
            }
            
            // Добавление варианта для select
            if (e.target.closest('.add-option-btn')) {
                const btn = e.target.closest('.add-option-btn');
                const fieldId = btn.dataset.fieldId;
                this.addSelectOption(fieldId);
                return;
            }
            
            // Удаление варианта для select
            if (e.target.closest('.remove-option-btn')) {
                const btn = e.target.closest('.remove-option-btn');
                const fieldId = btn.dataset.fieldId;
                const idx = btn.dataset.optionIndex;
                this.removeSelectOption(fieldId, parseInt(idx));
                return;
            }
            
            // Сортировка вверх
            if (e.target.closest('.sort-up-btn')) {
                const btn = e.target.closest('.sort-up-btn');
                if (btn.disabled) return;
                this.moveFieldUp(btn.dataset.fieldId);
                return;
            }
            
            // Сортировка вниз
            if (e.target.closest('.sort-down-btn')) {
                const btn = e.target.closest('.sort-down-btn');
                if (btn.disabled) return;
                this.moveFieldDown(btn.dataset.fieldId);
                return;
            }
            //отправка формы
            if (e.target.closest('.form-builder-save-btn')) {
                e.preventDefault();
                this.saveFormData();
                return;
            }
        });
        
        this.container.addEventListener('input', (e) => {
            const target = e.target;
            
            // Обработка стандартных полей
            if (target.dataset.fieldId && target.dataset.setting) {
                this.updateFieldSetting(target.dataset.fieldId, target.dataset.setting, target.value);
                return;
            }
            
            // Обработка опций select
            if (target.dataset.fieldId && target.dataset.optionIndex !== undefined) {
                this.updateSelectOption(target.dataset.fieldId, parseInt(target.dataset.optionIndex), target.dataset.optionField, target.value);
                return;
            }
            
            // Обработка заголовка формы
            if (target.classList.contains('form-title-input')) {
                this.formData.formName = target.value;
                this.saveToLocalStorage();
                this.rerenderFormFields();
            }
        });
        
        // Обработчик потери фокуса для поля name
        this.container.addEventListener('blur', (e) => {
            const target = e.target;
            
            if (target.dataset.setting === 'name' && target.value.trim() === '') {
                const fieldId = target.dataset.fieldId;
                const field = this.formData.fields.find(f => f.id === fieldId);
                
                if (field) {
                    // Генерируем новое имя на основе вопроса
                    const newName = this.generateUniqueFieldName(field.question || '');
                    field.name = newName;
                    target.value = newName;
                    
                    this.saveToLocalStorage();
                    this.rerenderFormFields();
                    
                    console.log(`Автоматически сгенерировано имя для поля: ${newName}`);
                }
            }
        }, true);
        
        this.container.addEventListener('change', (e) => {
            const target = e.target;
            if (target.matches('input[type="checkbox"][data-setting="required"]')) {
                const fieldId = target.dataset.fieldId;
                const checked = target.checked;
                const label = document.getElementById(`label_${target.id}`);
                if (label) label.textContent = checked ? 'Да' : 'Нет';
                this.updateFieldSetting(fieldId, 'required', checked);
                return;
            }
            if (target.matches('input[type="checkbox"][data-setting="allowedFormats"]')) {
                this.updateFileFormats(target.dataset.fieldId, target.dataset.format, target.checked);
                return;
            }
            if (target.matches('input[type="number"][data-setting="maxSize"]')) {
                this.updateFieldSetting(target.dataset.fieldId, 'maxSize', parseInt(target.value) || 2);
                return;
            }
        });
    }
    
    // Методы сортировки
    moveFieldUp(fieldId) {
        const index = this.formData.fields.findIndex(f => f.id === fieldId);
        if (index <= 0) return;
        this.reorderFields(index, index - 1);
    }
    
    moveFieldDown(fieldId) {
        const index = this.formData.fields.findIndex(f => f.id === fieldId);
        if (index === -1 || index >= this.formData.fields.length - 1) return;
        this.reorderFields(index, index + 1);
    }
    
    reorderFields(oldIndex, newIndex) {
        const fields = [...this.formData.fields];
        const [moved] = fields.splice(oldIndex, 1);
        fields.splice(newIndex, 0, moved);
        this.formData.fields = fields;
        this.render();
        this.rerenderFormFields();
        this.saveToLocalStorage();
    }
    
    // Обновление типа поля
    updateFieldType(fieldId, newType) {
        const index = this.formData.fields.findIndex(f => f.id === fieldId);
        if (index === -1) return;
        
        const old = this.formData.fields[index];
        
        // Проверяем name на пустоту
        let name = old.name;
        if (!name || name.trim() === '') {
            name = this.generateUniqueFieldName(old.question || '');
        }
        
        const updated = {
            id: fieldId,
            type: newType,
            question: old.question || '',
            name: name,
            required: old.required || false,
            settings: {}
        };
        
        // Переносим специфические поля
        if (newType === 'text' || newType === 'textarea') {
            updated.placeholder = old.placeholder || '';
        } else if (newType === 'select') {
            updated.options = old.options || [{ value: '', label: '' }];
        } else if (newType === 'file') {
            updated.allowedFormats = old.allowedFormats || ['jpeg', 'png', 'pdf'];
            updated.maxSize = old.maxSize || 2;
        }
        
        this.formData.fields[index] = updated;
        this.render();
        this.rerenderFormFields();
        this.saveToLocalStorage();
    }
    
    // Обновление отдельной настройки поля
    updateFieldSetting(fieldId, setting, value) {
        const field = this.formData.fields.find(f => f.id === fieldId);
        if (!field) return;
        
        field[setting] = value;
        
        // Если обновляется вопрос и поле name пустое - генерируем имя
        if (setting === 'question' && (!field.name || field.name.trim() === '')) {
            field.name = this.generateUniqueFieldName(value);
            
            // Обновляем значение в инпуте name
            const nameInput = this.container.querySelector(`input[data-field-id="${fieldId}"][data-setting="name"]`);
            if (nameInput) {
                nameInput.value = field.name;
            }
        }
        
        // Если обновляется вопрос, обновляем заголовок секции
        if (setting === 'question') {
            const titleEl = this.container.querySelector(`.form-section[data-field-id="${fieldId}"] .title`);
            if (titleEl) titleEl.textContent = value || 'Новое поле';
        }
        
        this.saveToLocalStorage();
        this.rerenderFormFields();
    }
    
    // Работа с вариантами select
    addSelectOption(fieldId) {
        const field = this.formData.fields.find(f => f.id === fieldId);
        if (!field || field.type !== 'select') return;
        
        if (!field.options) field.options = [];
        field.options.push({ value: '', label: '' });
        this.renderSelectOptions(field, fieldId);
        this.saveToLocalStorage();
        this.rerenderFormFields();
    }
    
    removeSelectOption(fieldId, optionIndex) {
        const field = this.formData.fields.find(f => f.id === fieldId);
        if (!field || !field.options) return;
        
        field.options.splice(optionIndex, 1);
        if (field.options.length === 0) field.options.push({ value: '', label: '' });
        
        this.renderSelectOptions(field, fieldId);
        this.saveToLocalStorage();
        this.rerenderFormFields();
    }
    
    updateSelectOption(fieldId, optionIndex, prop, value) {
        const field = this.formData.fields.find(f => f.id === fieldId);
        if (!field || !field.options || !field.options[optionIndex]) return;
        
        field.options[optionIndex][prop] = value;
        this.saveToLocalStorage();
        this.rerenderFormFields();
    }
    
    // Работа с форматами файлов
    updateFileFormats(fieldId, format, checked) {
        const field = this.formData.fields.find(f => f.id === fieldId);
        if (!field) return;
        
        if (!field.allowedFormats) field.allowedFormats = [];
        
        if (checked && !field.allowedFormats.includes(format)) {
            field.allowedFormats.push(format);
        } else if (!checked) {
            field.allowedFormats = field.allowedFormats.filter(f => f !== format);
        }
        
        if (field.allowedFormats.length === 0) {
            field.allowedFormats = ['jpeg'];
            // Вернуть чекбокс
            setTimeout(() => {
                const cb = this.container.querySelector(`input[type="checkbox"][data-field-id="${fieldId}"][data-format="jpeg"]`);
                if (cb) cb.checked = true;
            }, 0);
        }
        
        this.saveToLocalStorage();
        this.rerenderFormFields();
    }
    
    // Добавление нового поля
    addNewField() {
        const question = "Новое поле";
        const newField = {
            id: `field_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`,
            type: "text",
            question: question,
            placeholder: "",
            name: this.generateUniqueFieldName(question),
            required: false,
            settings: {}
        };
        this.formData.fields.push(newField);
        this.render();
        this.rerenderFormFields();
        this.saveToLocalStorage();
    }
    
    // Удаление поля
    deleteField(fieldId) {
        this.formData.fields = this.formData.fields.filter(f => f.id !== fieldId);
        this.render();
        this.rerenderFormFields();
        this.saveToLocalStorage();
    }

    //отправка формы
    saveFormData() {
        // 1. Находим форму, в которой лежит контейнер
        const form = this.container.closest('form');
        console.log('🔍 Форма:', form);

        // 2. Проверяем, что форма действительно найдена
        if (!form || !(form instanceof HTMLFormElement)) {
            console.error('Форма не найдена. Убедитесь, что контейнер находится внутри <form>.');
            return;
        }

        // 3. Проверяем наличие атрибута action (если нет — форма уйдёт на текущий URL, но лучше указать)
        if (!form.action) {
            console.warn('⚠️ У формы нет атрибута action, отправка произойдёт на текущий URL');
        }

        // 4. Удаляем предыдущее скрытое поле (чтобы не дублировать)
        const oldField = form.querySelector('input[name="form_builder_data"]');
        if (oldField) oldField.remove();

        // 5. Создаём новое скрытое поле с данными
        const hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = 'form_builder_data';
        
        // Проверяем, что у всех полей есть name перед отправкой
        this.validateFieldNames();
        
        try {
            hiddenField.value = JSON.stringify(this.formData);
        } catch (e) {
            console.error('Ошибка JSON.stringify:', e);
            alert('Не удалось преобразовать данные для отправки');
            return;
        }

        // 6. Проверяем размер данных (необязательно, но полезно)
        const dataSize = hiddenField.value.length;
        console.log(`📦 Размер данных: ${dataSize} байт`);
        if (dataSize > 5 * 1024 * 1024) {
            console.warn('Данные слишком большие (>5MB), сервер может их не принять');
        }

        // 7. Добавляем поле в форму
        form.appendChild(hiddenField);

        // 8. Убеждаемся, что в форме есть CSRF-токен (для Laravel)
        const csrfToken = form.querySelector('input[name="_token"]');
        if (!csrfToken) {
            console.warn('В форме не найден CSRF-токен. Сервер может вернуть ошибку 419.');
        }

        // 9. ВАЖНО: выводим всё, что будет отправлено, для отладки
        console.log('Данные формы перед отправкой:');
        const formData = new FormData(form);
        for (let pair of formData.entries()) {
            console.log(pair[0], pair[1]);
        }

        // 10. Отправляем форму с гарантией вызова оригинального метода
        setTimeout(() => {
            try {
                HTMLFormElement.prototype.submit.call(form);
                console.log('✅ Форма отправлена');
            } catch (e) {
                console.error('❌ Ошибка при вызове submit:', e);
                form.submit();
            }
        }, 0);
    }
    
    // Валидация полей name перед отправкой
    validateFieldNames() {
        let hasEmptyNames = false;
        
        this.formData.fields.forEach((field, index) => {
            if (!field.name || field.name.trim() === '') {
                hasEmptyNames = true;
                const newName = this.generateUniqueFieldName(field.question || `field_${index}`);
                field.name = newName;
                console.log(`Автоматически сгенерировано имя для поля ${index + 1}: ${newName}`);
            }
        });
        
        if (hasEmptyNames) {
            this.render(); // Перерендериваем, чтобы обновить отображение
        }
    }
    
    // Генерация HTML предпросмотра полей
    rerenderFormFields() {
        const event = new CustomEvent('formBuilderChange', {
            detail: {
                formData: this.formData,
                fieldsHtml: this.generateFormFields()
            }
        });
        document.dispatchEvent(event);
        if (this.onChangeCallback) this.onChangeCallback(this.formData);
    }
    
    generateFormFields() {
        return this.formData.fields.map(field => {
            const required = field.required ? 'required' : '';
            const name = field.name || this.generateUniqueFieldName(field.question);
            
            switch (field.type) {
                case 'textarea':
                    return `
                        <div class="form-preview-field">
                            <label>${this.escapeHtml(field.question)}</label>
                            <textarea name="${this.escapeHtml(name)}" 
                                      placeholder="${this.escapeHtml(field.placeholder || '')}" 
                                      ${required}></textarea>
                        </div>`;
                case 'select':
                    const options = (field.options || []).map(opt => 
                        `<option value="${this.escapeHtml(opt.value)}">${this.escapeHtml(opt.label)}</option>`
                    ).join('');
                    return `
                        <div class="form-preview-field">
                            <label>${this.escapeHtml(field.question)}</label>
                            <select name="${this.escapeHtml(name)}" ${required}>
                                <option value="">Выберите...</option>
                                ${options}
                            </select>
                        </div>`;
                case 'file':
                    const formats = (field.allowedFormats || ['jpeg', 'png', 'pdf']).join(', ');
                    const maxSize = field.maxSize || 2;
                    return `
                        <div class="form-preview-field">
                            <label>${this.escapeHtml(field.question)}</label>
                            <input type="file" 
                                   name="${this.escapeHtml(name)}" 
                                   accept=".${(field.allowedFormats || ['jpeg', 'png', 'pdf']).join(',.')}"
                                   data-max-size="${maxSize}"
                                   ${required}>
                            <small>Допустимые форматы: ${formats}. Макс. размер: ${maxSize}МБ</small>
                        </div>`;
                default:
                    return `
                        <div class="form-preview-field">
                            <label>${this.escapeHtml(field.question)}</label>
                            <input type="text" 
                                   name="${this.escapeHtml(name)}" 
                                   placeholder="${this.escapeHtml(field.placeholder || '')}" 
                                   ${required}>
                        </div>`;
            }
        }).join('');
    }
    
    // Экранирование HTML
    escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Сохранение/загрузка в localStorage
    saveToLocalStorage() {
        localStorage.setItem('formBuilderData', JSON.stringify(this.formData));
    }
    
    loadFromLocalStorage() {
        const saved = localStorage.getItem('formBuilderData');
        if (saved) {
            this.formData = JSON.parse(saved);
            this.render();
        }
    }
    
    // API методы
    getFormData() {
        return this.formData;
    }
    
    getFormFieldsHtml() {
        return this.generateFormFields();
    }
    
    onChange(callback) {
        this.onChangeCallback = callback;
    }
}

// Использование:
let formDataSettings = document.getElementById('form-data')
let formSettings = fieldset; // fieldset определена выше

if (formDataSettings) { // проверяем, что элемент существует
    const content = formDataSettings.textContent || formDataSettings.value; // пробуем оба варианта
    if (content && typeof content === 'string') {
        const trimmed = content.trim();
        if (trimmed) {
            try {
                formSettings = JSON.parse(trimmed);
            } catch (e) {
                console.warn('Ошибка парсинга JSON, используется fallback:', e);
            }
        }
    }
}

// Проверяем и генерируем name для всех полей при инициализации
if (formSettings && formSettings.fields) {
    formSettings.fields.forEach((field, index) => {
        if (!field.name || field.name.trim() === '') {
            field.name = new FormBuilder().generateUniqueFieldName(field.question || `field_${index}`);
        }
    });
}

const builder = new FormBuilder('form-builder', formSettings);

// Подписка на изменения
builder.onChange((formData) => {
    console.log('Форма изменилась:', formData);
    // Здесь можно обновлять предпросмотр формы
    document.getElementById('form-preview').innerHTML = builder.getFormFieldsHtml();
});

// Для начального рендера предпросмотра
document.getElementById('form-preview').innerHTML = builder.getFormFieldsHtml();
document.getElementById('form-preview').insertAdjacentHTML('afterbegin', `<h3 class="form-preview-title">предпросмотр формы</h3> `);