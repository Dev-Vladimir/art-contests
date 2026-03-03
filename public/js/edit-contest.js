document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('nominations-container');
    const addButton = document.getElementById('addNomination');
    
    // Функция создания нового элемента номинации
    function createNominationItem() {
        const div = document.createElement('div');
        div.className = 'nomination-item d-flex';
        
        div.innerHTML = `
            <input type="text" 
                   name="nominations[]" 
                   placeholder="Название номинации" 
                   class="form-control">
            <button type="button" class="remove-nomination"><i class="bi bi-trash3-fill"></i></button>
        `;
        
        // Добавляем обработчик для кнопки удаления
        div.querySelector('.remove-nomination').addEventListener('click', function() {
            div.remove();
        });
        
        return div;
    }
    
    // Обработчик добавления
    addButton.addEventListener('click', function() {
        container.appendChild(createNominationItem());
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('groups-container');
    const addButton = document.getElementById('addGroup');
    
    // Функция создания нового элемента группы
    function createGroupItem() {
        const div = document.createElement('div');
        div.className = 'group-item d-flex';
        
        div.innerHTML = `
            <input type="text" 
                   name="groups[]" 
                   placeholder="Название группы" 
                   class="form-control">
            <button type="button" class="remove-group"><i class="bi bi-trash3-fill"></i></button>
        `;
        
        // Добавляем обработчик для кнопки удаления
        div.querySelector('.remove-group').addEventListener('click', function() {
            div.remove();
        });
        
        return div;
    }
    
    // Обработчик добавления
    addButton.addEventListener('click', function() {
        container.appendChild(createGroupItem());
    });
});