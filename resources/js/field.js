// Функция для скрытия всех полей
function hideAllFields() {
    var fields = document.querySelectorAll('#dynamicFields input');
    fields.forEach(function(field) {
        field.style.display = 'none';
    });
}

// Функция для отображения полей для выбранного типа
function showFieldsForType(type) {
    var fields = document.querySelectorAll('#dynamicFields input[name^="' + type + '"]');
    fields.forEach(function(field) {
        field.style.display = 'block';
    });
}

// Назначаем обработчик события изменения значения в поле "Тип"
document.getElementById('typeSelect').addEventListener('change', function(event) {
    // Скрываем все поля
    hideAllFields();
    // Получаем выбранное значение
    var selectedType = event.target.value;
    // Отображаем соответствующие поля для выбранного типа
    showFieldsForType(selectedType);
});

// При загрузке страницы скрываем все поля
hideAllFields();
