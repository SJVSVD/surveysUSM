// ################################################################################################################
// Nota: Los elementos de un componente tiene prioridad a los de los mixins que pueda poseer.
// ################################################################################################################

// Notificaciones:
import { useToast } from "vue-toastification";

// EXPORT
export const mixin = {
    data: {
        toast: useToast(),
    },
    created() {

    },
    computed: {
        todayDate() {
            return moment().format("DD-MM-YYYY");
        },
        todayDay() {
            return moment().format("DD");
        },
        todayMonth() {
            return moment().format("MM");
        },
        todayYear() {
            return moment().format("YYYY");
        },
        todayCalendar() {
            return moment().calendar();
        },
    },
};