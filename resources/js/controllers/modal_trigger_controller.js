import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="modal-trigger"
export default class extends Controller {
    static outlets = ['modal'];

    open() {
        this.modalOutlet.open();
    }
}
