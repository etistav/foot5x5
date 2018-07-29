class Tooltip {

    /**
     * Apply tooltip system on elements
     * @param {string} selector 
     */
    static bind (selector) {
        document.querySelectorAll(selector).forEach(element => new Tooltip(element))
    }

    /**
     * 
     * @param {HTMLElement} element 
     */
    constructor(element) {
        this.element = element
        let tooltipTarget = this.element.getAttribute('data-tooltip')
        if (tooltipTarget) {
            this.title = document.querySelector(tooltipTarget).innerHTML
            this.tooltip = null
            this.element.addEventListener('mouseover', this.mouseover.bind(this))
            this.element.addEventListener('mouseout', this.mouseout.bind(this))
        }        
    }

    mouseover() {
        let tooltip = this.createTooltip()
        let width = this.tooltip.offsetWidth
        let height = this.tooltip.offsetHeight
        let left = this.element.getBoundingClientRect().left + document.documentElement.scrollLeft + this.element.offsetWidth + 15
        let top = this.element.getBoundingClientRect().top + document.documentElement.scrollTop + this.element.offsetHeight / 2 - height / 2 - 2
        tooltip.style.left = left + "px"
        tooltip.style.top = top + "px"
        tooltip.classList.add('visible')
    }

    mouseout() {
        if (this.tooltip !== null) {
            this.tooltip.classList.remove('visible')
            this.tooltip.addEventListener('transitionend', () => {
                if (this.tooltip !== null) {
                    document.body.removeChild(this.tooltip)
                    this.tooltip = null
                }
            })
        }
    }

    /**
     * Create and inject the tooltip in HTML
     * @returns {HTMLElement}
     */
    createTooltip() {
        if (this.tooltip === null) {   
            let tooltip = document.createElement('div')
            tooltip.innerHTML = this.title
            tooltip.classList.add('foot5x5_tooltip')
            document.body.appendChild(tooltip)
            this.tooltip = tooltip
            return tooltip
        }
        return this.tooltip
    }
}

Tooltip.bind('i')