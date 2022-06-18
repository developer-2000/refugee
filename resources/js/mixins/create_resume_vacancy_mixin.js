export default {
    data() {
        return {

        }
    },
    methods: {
        // клик по одной из названий position в подсказке списка
        setValuePosition(value){
            $('#position_list').removeClass('show')
            this.position = value
        },
        // проверка на ввод зарплаты
        checkSalary() {
            // если выбран сектор а поля не заполнены
            if(
                (this.objSalary.salary_but == "range" && (this.objSalary.from === '' || this.objSalary.to === '') ) ||
                (this.objSalary.salary_but == "single_value" && this.objSalary.salary_sum === '')
            ){
                this.objSalary.switchSalary = true
                return true;
            }
            this.objSalary.switchSalary = false
            return false;
        },
        // выровнять последнее число по первому если оно меньше
        alignNumbers(obj, from, to) {
            if(this.checkingInteger(obj[from]) && this.checkingInteger(obj[to])){
                if(parseInt(obj[from]) > parseInt(obj[to])){
                    obj[to] = obj[from]
                }
            }
        },
        // добавляет и удаляет язык из блока выбора языков
        fillingLanguages(){
            // language
            $('#language').on('select2:select', (e) => {
                this.objLanguage.languages.push( parseInt(e.params.data.id) );
            })
            $('#language').on("select2:unselect", (e) => {
                // удалить этот елемент
                this.objLanguage.languages.splice(this.objLanguage.languages.indexOf( parseInt(e.params.data.id) ), 1)
                // отключить раскрытие после удаления
                if (!e.params.originalEvent) {
                    return;
                }
                e.params.originalEvent.stopPropagation();
            });
        },
        // инициализация данных
        initializationFunc() {
            this.createArrayCategories()
            this.fillingLanguages()
            this.objLocations.load_countries = this.settings.obj_countries
        },
    },
    mounted() {
        // инициализация всплывающих подсказок
        $('[data-toggle="tooltip"]').tooltip();
    },
}
