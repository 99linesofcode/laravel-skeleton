import { Controller } from "@hotwired/stimulus"
import { enter, leave } from "el-transition";

// Connects to data-controller="modal"
export default class extends Controller {
    static targets = ['overlay', 'content'];

    static values = {
        open: Boolean,
        focusable: Boolean,
    }

    static classes = ['overlay']

    open() {
        this.openValue = true;
    }

    close () {
        this.openValue = false;
    }

    hijackFocus(event) {
        if (event.shiftKey) {
            this.focusPrevious()
        } else {
            this.focusNext()
        }
    }

    focusNext() {
        this.nextFocusable.focus()
    }

    focusPrevious() {
        this.prevFocusable.focus()
    }

    closeNow() {
        this.overlayTarget.classList.add('hidden')
        this.contentTarget.classList.add('hidden')
        document.body.classList.remove(this.overlayClass)
        this.openValue = false
    }

    // private

    openValueChanged() {
        if (this.openValue) {
            Promise.all([
                enter(this.element),
                enter(this.overlayTarget),
                enter(this.contentTarget),
            ]).then(() => {
                if (this.focusableValue) {
                    this.firstFocusable.focus()
                    document.body.classList.add(this.overlayClass)
                }
            })
        } else {
            leave(this.element)
            leave(this.contentTarget)
            leave(this.overlayTarget)

            if (this.focusableValue) document.body.classList.remove(this.overlayClass)
        }
    }

    get focusables() {
        let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'

        return [...this.element.querySelectorAll(selector)]
            // All non-disabled elements...
            .filter(el => ! el.hasAttribute('disabled'))
    }

    get firstFocusable() {
        return this.focusables[0]
    }

    get lastFocusable() {
        return this.focusables.slice(-1)[0]
    }

    get nextFocusable() {
        return this.focusables[this.nextFocusableIndex] || this.firstFocusable
    }

    get prevFocusable() {
        return this.focusables[this.prevFocusableIndex] || this.lastFocusable
    }

    get nextFocusableIndex() {
        return this.focusables.indexOf(document.activeElement) + 1 % (this.focusables.length + 1)
    }

    get prevFocusableIndex() {
        return Math.max(0, this.focusables.indexOf(document.activeElement) -1)
    }
}
