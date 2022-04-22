export default {
    data() {
        return {
        }
    },
    methods: {
        // вырезает теги html из текста
        cutTags(text){
            let regex = /<\/?[^>]+(>|$)/gi
            return text.replace(regex, "")
        },
        // поиск значения в массиве объектов
        lookingValueInArrayObjects(property_name, property_value, arrSearch){
            let bool = false
            let response = arrSearch.find(obj => obj[property_name] == property_value)
            if(response !== undefined){
                bool = true
            }

            return bool
        }
    },
}
