import { Controller } from "@hotwired/stimulus"
import { leave, enter } from "el-transition"

// Connects to data-controller="dropdown"
export default class extends Controller {
    static targets = ['trigger', 'menu']

    static values = {
        open: { type: Boolean, default: false },
    }

    close(event) {
        if (! this.openValue) return;
        if (this.triggerTarget.contains(event.target)) return

        this.openValue = false;
    }

    toggle() {
        this.openValue = ! this.openValue;
    }

    closeNow() {
        this.menuTarget.classList.add('hidden');
    }

    openValueChanged() {
        if (this.openValue) {
            enter(this.menuTarget)
        } else {
            leave(this.menuTarget)
        }
    }
}
