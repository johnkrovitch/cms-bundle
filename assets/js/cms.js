import 'select2';
import 'select2/dist/css/select2.min.css';
import '../scss/cms.scss';
import Modal from './cms/modal/Modal';
import Select2 from "./cms/select2/Select2";

$(document).ready(function () {
    // Initialize select2 inputs
    new Select2();

    // Create a modal component with the default options
    let modal = new Modal();
    modal.bind();
    
});
