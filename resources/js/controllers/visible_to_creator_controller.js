import { Controller } from "@hotwired/stimulus"
import { current } from 'libs/current'

// Connects to data-controller="visible-to-creator"
export default class extends Controller {
    static values = {
        'id': String,
    };

    static classes = ['hidden'];

    connect() {
        this.toggleVisibility();
    }

    toggleVisibility() {
        if (this.idValue == current.identity.id) {
            this.element.classList.remove(...this.hiddenClasses);
        } else {
            this.element.classList.add(...this.hiddenClasses);
        }
    }
}
